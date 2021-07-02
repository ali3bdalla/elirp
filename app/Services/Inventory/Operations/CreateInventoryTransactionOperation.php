<?php

namespace App\Services\Inventory\Operations;

use App\Domains\Accounting\Jobs\CreateInventoryTransactionAccountingTransactionJob;
use App\Domains\Inventory\Jobs\CalcNewTransactionUnitCostJob;
use App\Domains\Inventory\Jobs\CreateInventoryTransacitonJob;
use App\Enums\InventoryTransactionTypeEnum;
use App\Models\DocumentItem;
use App\Models\Entry;
use App\Models\Inventory;
use App\Models\Item;
use Lucid\Units\Operation;

class CreateInventoryTransactionOperation extends Operation
{
    /**
     * Create a new operation instance.
     *
     * @return void
     */
    public function __construct(
        public Inventory $inventory,
        public Item $item,
        public float $quantity,
        public InventoryTransactionTypeEnum $type,
        public DocumentItem | null $documentItem = null,
        public Entry | null $entry = null,
        public float | null $unitCost = null,
        public bool $isReverseing = false,
    ) {
        //
    }

    /**
     * Execute the operation.
     *
     * @return void
     */
    public function handle()
    {
        $unitCost = $this->run(
            CalcNewTransactionUnitCostJob::class,
            [
                'item'         => $this->item,
                'unitCost'     => $this->unitCost,
                'documentItem' => $this->documentItem,
                'isReverseing' => $this->isReverseing,
            ]
        );
        $parameters = [
            'unit_cost'    => $unitCost,
            'item_id'      => $this->item->id,
            'quantity'     => $this->quantity,
            'inventory_id' => $this->inventory->id,
            'type'         => $this->type
        ];
        if ($this->documentItem) {
            $parameters = array_merge(
                $parameters,
                [
                    'document_item_id' => $this->documentItem->id,
                    'document_id'      => $this->documentItem->document_id,
                ]
            );
        }
        $inventoryTransaction = $this->run(
            CreateInventoryTransacitonJob::class,
            [
                'data' => $parameters
            ]
        );

        if ($this->entry) {
            $this->run(
                CreateInventoryTransactionAccountingTransactionJob::class,
                [
                    'inventoryTransaction' => $inventoryTransaction,
                    'entry'                => $this->entry
                ]
            );
        }

        return $inventoryTransaction;
    }
}
