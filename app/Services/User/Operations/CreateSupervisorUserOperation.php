<?php

namespace App\Services\User\Operations;

use App\Domains\User\Jobs\CreateNewUserJob;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Lucid\Units\Operation;

class CreateSupervisorUserOperation extends Operation
{
    private Company $company;
    private $email;
    private $name;
    private $password;
    private $keycloakId;
    
    /**
     * Create a new operation instance.
     *
     * @return void
     */
    public function __construct(Company $company,$keycloakId, $email = '', $password = '', $name = '')
    {
        //
        $this->company  = $company;
        $this->email    = $email;
        $this->password = $password;
        $this->name     = $name;
        $this->keycloakId=$keycloakId;
    }

    /**
     * Execute the operation.
     *
     * @return User
     */
    public function handle() : User
    {
        if (Auth::check()) {
            $user = Auth::user();
        } else {
            $user = $this->run(
                CreateNewUserJob::class,
                [
                'keycloakId'      => $this->keycloakId,
                'name'      => $this->name,
                'email'     => $this->email,
                'password'  => Hash::make($this->password),
                'companyId' => $this->company->id,
                'locale'    => 'en-GB',
                'enabled'   => '1',
                ]
            );
        }

        return   $user ;
    }
}
