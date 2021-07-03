<?php

namespace App\Services\Company\Features;

use App\Domains\Company\Jobs\SeedCompanyCashPaymentMethodJob;
use App\Domains\Company\Jobs\SeedCompanyMainInventoryJob;
use App\Domains\Company\Jobs\StoreCompanyJob;
use App\Models\User;
use App\Services\Company\Operations\SeedCompanyBaseAccountsOperation;
use App\Services\User\Operations\CreateSupervisorUserOperation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Lucid\Units\Feature;

class CreateCompanyFeature extends Feature
{
    private $request;

    public function __construct($request)
    {
        $this->request = parse_request_instance($request);
    }

    /**
     * @return User
     */
    public function handle() : User
    {
        $request = $this->request;
        return DB::transaction(
            function () use ($request) {
                $company = $this->run(
                    StoreCompanyJob::class,
                    [
                        'companyName'  => $request->input('name'),
                        'companyEmail' => $request->input('email'),
                    ]
                );
    
                $authUser = $this->run(
                    CreateSupervisorUserOperation::class,
                    [
                        'company'        => $company,
                        'name'           => $request->input('name'),
                        'keycloakId'     => $request->input('keycloakId'),
                        'email'          => $request->input('email'),
                        'password'       => $request->input('password'),
                    ]
                );
                Auth::guard('web')->login($authUser);
                $this->run(
                    SeedCompanyBaseAccountsOperation::class,
                    [
                        'company' => $company
                    ]
                );
                $this->run(
                    SeedCompanyMainInventoryJob::class,
                    [
                        'company' => $company
                    ]
                );
                $this->run(
                    SeedCompanyCashPaymentMethodJob::class,
                    [
                        'company' => $company
                    ]
                );
                return $authUser;
            }
        );
    }
}
