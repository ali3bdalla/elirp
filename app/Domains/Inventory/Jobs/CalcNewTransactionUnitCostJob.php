<?php

namespace App\Domains\Inventory\Jobs;

use App\Enums\DocumentTypeEnum;
use App\Models\DocumentItem;
use App\Models\Item;
use Lucid\Units\Job;

class CalcNewTransactionUnitCostJob extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        public Item $item,
        public DocumentItem|null $documentItem = null,
        public float|null $unitCost = null,
    ) {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->unitCost) {
            return round($this->unitCost, 2);
        }

        if ($this->documentItem) {
            if ($this->documentItem->type->equals(DocumentTypeEnum::BILL())) {
                return round((float)($this->documentItem->subtotal) / (float)($this->documentItem->quantity ? $this->documentItem->quantity : 1), 2);
            } else {
                //
                return round((float)($this->documentItem->subtotal) / (float)($this->documentItem->quantity ? $this->documentItem->quantity : 1), 2);
            }
        }

        return 0;
    }
}
