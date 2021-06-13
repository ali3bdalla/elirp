<?php

namespace App\Domains\Company\Jobs;

use App\Models\Company;
use Lucid\Units\Job;

class IsActiveCompanyJob extends Job
{
    private Company $company;

    public function __construct(Company $company)
    {
        //
        $this->company = $company;
    }

    /**
     * Execute the job.
     *
     * @return boolean
     */
    public function handle() : bool
    {
        return $this->company->id > 0;
    }
}
