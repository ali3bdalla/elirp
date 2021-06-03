<?php

namespace App\Domains\User\Jobs;

use App\Models\User;
use Lucid\Units\Job;

class AttachRolesToUserJob extends Job
{
    private User $user;
    private $roles;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, $roles)
    {
        //
        $this->user = $user;
        $this->roles = $roles;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->user->roles()->attach($this->roles);
    }
}
