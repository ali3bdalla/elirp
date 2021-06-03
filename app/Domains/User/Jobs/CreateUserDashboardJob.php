<?php

namespace App\Domains\User\Jobs;

use App\Jobs\Common\CreateDashboard;
use App\Models\User;
use App\Models\Company;
use Lucid\Units\Job;

class CreateUserDashboardJob extends Job
{
    private User $user;
    private Company $company;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, Company $company)
    {
        //
        $this->user = $user;
        $this->company = $company;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        dispatch_sync(new CreateDashboard([
            'company_id' => $this->company->id,
            'name' => trans_choice('general.dashboards', 1),
            'default_widgets' => 'core',
            'users' => $this->user->id,
        ]));
    }
}
