<?php

namespace App\Services\Inventory\Operations;

use App\Domains\Inventory\Jobs\CreateInventoryTransacitonJob;
use App\Domains\Inventory\Jobs\GetCurrentInventoryJob;
use App\Enums\DocumentTypeEnum;
use App\Enums\InventoryTransactionTypeEnum;
use App\Models\Document;
use App\Models\Entry;
use Lucid\Units\Operation;

class RegisterDocumentInventoryTransactionsOperation extends Operation
{
    /**
     * Create a new operation instance.
     *
     * @return void
     */
    public function __construct(public Document $document, public Entry $entry, private bool $reverse = false)
    {
        //
    }

    /**
     * Execute the operation.
     *
     * @return void
     */
    public function handle()
    {
        $inventory = $this->run(GetCurrentInventoryJob::class);
        foreach ($this->document->items()->get() as $documentItem) {
            $this->run(
                CreateInventoryTransactionOperation::class,
                [
                    'inventory' => $inventory,
                    'item' => $documentItem->item,
                    'quantity' => $documentItem->quantity,
                    'documentItem' => $documentItem,
                    'type' => $this->document->type->equals(DocumentTypeEnum::BILL()) && !$this->reverse ? InventoryTransactionTypeEnum::IR() : InventoryTransactionTypeEnum::IS(),
                    'entry' => $this->entry
                ]
            );
        }
    }
}
