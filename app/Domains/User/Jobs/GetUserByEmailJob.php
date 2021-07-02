<?php

namespace App\Domains\User\Jobs;

use App\Models\User;
use Lucid\Units\Job;

class GetUserByEmailJob extends Job
{
    private $keycloakId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $keycloakId = null)
    {
        //
        $this->keycloakId = $keycloakId;
    }

    /**
     * Execute the job.
     *
     * @return User|null
     */
    public function handle() : ?User
    {
        return User::where('keycloak_id', $this->keycloakId)->first();
    }
}
