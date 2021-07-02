<?php

namespace App\Domains\Company\Jobs;

use App\Models\Company;
use App\Models\Inventory;
use Lucid\Units\Job;

class SeedCompanyMainInventoryJob extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public Company $company)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return Inventory
     */
    public function handle() : Inventory
    {
        return Inventory::create(
            [
                'name'        => 'Main Inventory',
                'description' => 'Auto Created Main Inventory',
                'company_id'  => $this->company->id,
                'enabled'     => true
            ]
        );
    }
}
