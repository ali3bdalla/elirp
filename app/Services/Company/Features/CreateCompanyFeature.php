<?php

namespace App\Services\Company\Features;

use App\Domains\Company\Jobs\SeedCategoriesJob;
use App\Domains\Company\Jobs\SeedCompanyCurrenciesJob;
use App\Domains\Company\Jobs\SeedCompanyEmailTemplatesJob;
use App\Domains\Company\Jobs\SeedCompanyReportsJob;
use App\Domains\Company\Jobs\StoreCompanyJob;
use App\Domains\Utility\Jobs\SetAppLocalizationJob;
use App\Events\Common\CompanyCreated;
use App\Events\Common\CompanyCreating;
use App\Http\Requests\Company\CreateCompanyRequest;
use App\Models\Company;
use App\Services\Company\Operations\SeedCompanyBaseAccountsOperation;
use App\Services\Company\Operations\SeedCompanySettingOperation;
use App\Services\User\Operations\CreateSupervisorUserOperation;
use Illuminate\Support\Facades\DB;
use Lucid\Units\Feature;

class CreateCompanyFeature extends Feature
{
    private CreateCompanyRequest $request;

    public function __construct(CreateCompanyRequest $request)
    {
        $this->request = $request;
    }

    /**
     * @return Company
     */
    public function handle(): Company
    {
        $request = $this->request;
        return DB::transaction(function () use ($request) {
            event(new CompanyCreating($this->request));
            $company = $this->run(StoreCompanyJob::class, [
                'companyName' => $request->input('company_name'),
                'companyEmail' => $request->input('company_email'),
            ]);
            $this->run(SetAppLocalizationJob::class, [
                'locale' => 'en-GB'
            ]);
            $this->run(SeedCompanyBaseAccountsOperation::class, [
                'company' => $company
            ]);
            $this->run(SeedCompanyCurrenciesJob::class, [
                'company' => $company
            ]);
            $this->run(SeedCompanyEmailTemplatesJob::class, [
                'company' => $company
            ]);
            $this->run(SeedCompanyReportsJob::class, [
                'company' => $company
            ]);
            $this->run(SeedCompanySettingOperation::class, [
                'company' => $company
            ]);

            $this->run(CreateSupervisorUserOperation::class, [
                'company' => $company,
                'email' => $request->input('supervisor_email'),
                'password' => $request->input('supervisor_password'),
            ]);
            $this->run(SeedCategoriesJob::class, [
                'company' => $company
            ]);
            event(new CompanyCreated($company));
            return $company;
        });
    }
}
