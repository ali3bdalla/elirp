<?php

namespace App\Domains\User\Jobs;

use App\Models\User;
use Lucid\Units\Job;

class AttachPermissionsToUserJob extends Job
{
    private User $user;
    private $permissions;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, $permissions)
    {
        //
        $this->user        = $user;
        $this->permissions = $permissions;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->user->permissions()->attach($this->permissions);
    }
}
