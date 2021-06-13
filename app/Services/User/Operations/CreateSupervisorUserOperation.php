<?php

namespace App\Services\User\Operations;

use App\Domains\User\Jobs\CreateNewUserJob;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Lucid\Units\Operation;

class CreateSupervisorUserOperation extends Operation
{
    private Company $company;
    private $email;
    private $name;
    private $password;

    /**
     * Create a new operation instance.
     *
     * @return void
     */
    public function __construct(Company $company, $email, $password, $name = '')
    {
        //
        $this->company  = $company;
        $this->email    = $email;
        $this->password = $password;
        $this->name     = $name;
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
                'name'      => $this->name,
                'email'     => $this->email,
                'password'  => Hash::make($this->password),
                'companyId' => $this->company->id,
                'locale'    => 'en-GB',
                'enabled'   => '1',
            ]);
        }

        return   $user ;
    }
}
