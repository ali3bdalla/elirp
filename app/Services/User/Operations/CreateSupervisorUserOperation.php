<?php

namespace App\Services\User\Operations;

use App\Domains\User\Jobs\AttachRolesToUserJob;
use App\Domains\User\Jobs\CreateNewUserJob;
use App\Domains\User\Jobs\CreateUserDashboardJob;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Lucid\Units\Operation;

class CreateSupervisorUserOperation extends Operation
{
    private Company $company;
    private $email;
    private $password;

    /**
     * Create a new operation instance.
     *
     * @return void
     */
    public function __construct(Company $company, $email, $password)
    {
        //
        $this->company = $company;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * Execute the operation.
     *
     * @return void
     */
    public function handle()
    {
        if (Auth::check()) {
            $user = Auth::user();
        } else {
            $user = $this->run(CreateNewUserJob::class, [
                'name' => 'Admin',
                'email' => $this->email,
                'password' => $this->password,
                'companyId' => $this->company->id,
                'locale' => 'en-GB',
                'enabled' => '1',
            ]);
        }

        $this->run(AttachRolesToUserJob::class, [
            'user' => $user,
            'roles' => [1]
        ]);

        $this->run(CreateUserDashboardJob::class, [
            'user' => $user,
            'company' => $this->company
        ]);
    }
}
