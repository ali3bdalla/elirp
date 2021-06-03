<?php

namespace App\Domains\Company\Jobs;

use App\Events\Common\CompanyForgettingCurrent;
use App\Events\Common\CompanyForgotCurrent;
use App\Models\Company;
use Lucid\Units\Job;

class ForgetActiveCompanyJob extends Job
{

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $current = Company::getCurrent();
        if (is_null($current)) {
            return null;
        }
        event(new CompanyForgettingCurrent($current));
        // Remove from container
        app()->forgetInstance(Company::class);
        setting()->forgetAll();

        event(new CompanyForgotCurrent($current));
    }
}
