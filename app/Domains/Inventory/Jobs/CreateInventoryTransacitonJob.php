<?php

namespace App\Domains\Inventory\Jobs;

use App\Models\InventoryTransaction;
use Lucid\Units\Job;

class CreateInventoryTransacitonJob extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private array $data)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return InventoryTransaction
     */
    public function handle() : InventoryTransaction
    {
        $this->data['company_id'] = company_id();
        return InventoryTransaction::create($this->data);
    }
}
