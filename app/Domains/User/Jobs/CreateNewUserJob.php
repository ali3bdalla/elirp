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

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($name, $email, $password, $companyId, $locale = 'ar', $enabled = true)
    {
        //
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->locale = $locale;
        $this->enabled = $enabled;
        $this->companyId = $companyId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        return User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'company_id' => $this->companyId,
            'locale' => $this->locale,
            'enabled' => $this->enabled
        ]);
    }
}
