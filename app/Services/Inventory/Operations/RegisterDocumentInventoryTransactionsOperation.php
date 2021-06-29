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
     * @return array
     */
    public function handle(): array
    {
        $transactions = [];
        $inventory = $this->run(GetCurrentInventoryJob::class);

        $type = InventoryTransactionTypeEnum::IS();
        if ($this->document->type->equals(DocumentTypeEnum::BILL())) {
            $type  = InventoryTransactionTypeEnum::IR();
        }
        if ($this->reverse) {
            $type = $type->equals(InventoryTransactionTypeEnum::IS()) ? InventoryTransactionTypeEnum::IR() : InventoryTransactionTypeEnum::IS();
        }
        foreach ($this->document->items()->get() as $documentItem) {
            $transactions[] = $this->run(
                CreateInventoryTransactionOperation::class,
                [
                    'inventory' => $inventory,
                    'item' => $documentItem->item,
                    'quantity' => $documentItem->quantity,
                    'documentItem' => $documentItem,
                    'type' => $type,
                    'entry' => $this->entry
                ]
            );
        }

        return $transactions;
    }
}
