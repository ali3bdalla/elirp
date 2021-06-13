<?php

namespace App\Domains\Item\Jobs;

use App\Models\Item;
use App\Models\ItemTax;
use Illuminate\Support\Collection;
use Lucid\Units\Job;

class StoreItemTaxesJob extends Job
{
    private Collection $taxes;
    private Item $item;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Item $item, $taxesIds = [])
    {
        //
        $this->item  = $item;
        $this->taxes = new Collection($taxesIds);
    }

    /**
     * Execute the job.
     *
     * @return array<ItemTax>
     */
    public function handle() : array
    {
        $taxes = [];
        foreach ($this->taxes as $taxId) {
            $taxes[] = ItemTax::create([
                'item_id'    => $this->item->id,
                'company_id' => $this->item->company_id,
                'tax_id'     => $taxId,
            ]);
        }

        return $taxes;
    }
}
