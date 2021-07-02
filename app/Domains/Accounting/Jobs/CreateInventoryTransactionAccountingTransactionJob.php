<?php

namespace App\Domains\Accounting\Jobs;

use App\Enums\AccountingTypeEnum;
use App\Enums\InventoryTransactionTypeEnum;
use App\Models\Entry;
use App\Models\InventoryTransaction;
use App\Models\Transaction;
use Lucid\Units\Job;

class CreateInventoryTransactionAccountingTransactionJob extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private InventoryTransaction $inventoryTransaction, private Entry $entry)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $account         = $this->inventoryTransaction->inventory?->account;
        $transactionType = $this->inventoryTransaction->type->equals(InventoryTransactionTypeEnum::IR()) ? AccountingTypeEnum::DEBIT() : AccountingTypeEnum::CREDIT();

        $amount =round($this->inventoryTransaction->unit_cost * $this->inventoryTransaction->quantity, 2);

        return Transaction::create(
            [
                'document_id'              => $this->inventoryTransaction->document_id,
                'inventory_transaction_id' => $this->inventoryTransaction->id,
                'document_item_id'         => $this->inventoryTransaction->document_item_id,
                'account_id'               => $account->id,
                'amount'                   => $amount,
                'type'                     => $transactionType,
                'entry_id'                 => $this->entry->id,
                'item_id'                  => $this->inventoryTransaction->item_id,
                'currency_code'            => 'USD',
                'currency_rate'            => 1,
                'company_id'               => company_id(),
            ]
        );
    }
}
