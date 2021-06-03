<?php

namespace App\Domains\Company\Jobs;

use App\Models\Company;
use Lucid\Units\Job;

class IsActiveCompanyJob extends Job
{
    private Company $company;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Company $company)
    {
        //
        $this->company = $company;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (Company::getCurrent()) {
            return Company::getCurrent()->id === $this->company->id;
        }

        return true;
    }
}
