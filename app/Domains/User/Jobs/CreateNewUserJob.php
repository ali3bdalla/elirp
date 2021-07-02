<?php

namespace App\Domains\User\Jobs;

use App\Models\User;
use Lucid\Units\Job;

class CreateNewUserJob extends Job
{
    private $name;
    private $email;
    private $password;
    private string $locale;
    private int $enabled;
    private $companyId;
    private $keycloakId;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($keycloakId,$companyId,$name = '', $email = '', $password = '',  $locale = 'ar', $enabled = true)
    {
        //
        $this->name      = $name;
        $this->email     = $email;
        $this->password  = $password;
        $this->locale    = $locale;
        $this->enabled   = $enabled;
        $this->companyId = $companyId;
        $this->keycloakId=$keycloakId;
    }

    /**
     * Execute the job.
     *
     * @return User
     */
    public function handle() : User
    {
        return User::create(
            [
            'name'       => $this->name,
            'email'      => $this->email,
            'password'   => $this->password,
            'company_id' => $this->companyId,
            'keycloak_id' => $this->keycloakId,
            'locale'     => $this->locale,
            'enabled'    => $this->enabled
            ]
        );
    }
}
