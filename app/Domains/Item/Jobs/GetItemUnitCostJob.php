<?php

namespace App\Domains\Item\Jobs;

use App\Models\InventoryTransaction;
use App\Models\Item;
use Lucid\Units\Job;

class GetItemUnitCostJob extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private Item $item)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return float
     */
    public function handle() : float
    {
        $count = InventoryTransaction::whereItemId($this->item->id)->count();
        if ($count === 0) {
            return 0;
        }
        return round(InventoryTransaction::whereItemId($this->item->id)->sum('unit_cost') / $count, 2);
    }
}
