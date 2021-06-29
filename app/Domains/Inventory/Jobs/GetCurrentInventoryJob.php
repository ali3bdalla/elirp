<?php

namespace App\Domains\Inventory\Jobs;

use App\Domains\Company\Jobs\SeedCompanyMainInventoryJob;
use App\Models\Inventory;
use Lucid\Units\Job;

class GetCurrentInventoryJob extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
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
        $inventory = Inventory::first();
        if (!$inventory) {
            $createJob = new SeedCompanyMainInventoryJob(company());
            $inventory= $createJob->handle();
        }
        return $inventory;
    }
}
