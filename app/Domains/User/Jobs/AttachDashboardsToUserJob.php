<?php

namespace App\Domains\User\Jobs;

use App\Models\User;
use Lucid\Units\Job;

class AttachDashboardsToUserJob extends Job
{
    private User $user;
    private $dashboards;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, $dashboards)
    {
        //
        $this->user       = $user;
        $this->dashboards = $dashboards;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->user->dashboards()->attach($this->dashboards);
    }
}
