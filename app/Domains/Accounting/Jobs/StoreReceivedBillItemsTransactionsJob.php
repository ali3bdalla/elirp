<?php

namespace App\Domains\Accounting\Jobs;

use App\Enums\AccountingTypeEnum;
use App\Enums\AccountSlugsEnum;
use App\Models\Account;
use App\Models\Entry;
use App\Models\Transaction;
use App\Models\Document;
use Lucid\Units\Job;

class StoreReceivedBillItemsTransactionsJob extends Job
{
    private Entry $entry;
    private Document $document;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Entry $entry, Document $document)
    {
        //
        $this->entry = $entry;
        $this->document = $document;
    }
    
    /**
     * Execute the job.
     *
     * @return array<Transaction>
     */
    public function handle(): array
    {
        $stock = Account::default(AccountSlugsEnum::DEFAULT_STOCK_ACCOUNT());
        $items = $this->document->items()->get();
        $result = [];
        foreach ($items as $item) {
            $data['entry_id'] = $this->entry->id;
            $data['is_pending'] = $this->entry->is_pending;
            $data['reference'] = uniqid('transaction_');
            $data['amount'] = $item->subtotal;
            $data['contact_id'] = $this->document->contact_id;
            $data['company_id'] = $this->entry->company_id;
            $data['document_id'] = $this->document->id;
            $data['currency_rate'] = $this->document->currency_rate;
            $data['currency_code'] = $this->document->currency_code;
            $data['type'] = AccountingTypeEnum::DEBIT();
            $data['item_id'] = $item->id;
            $result[] = $stock->transactions()->create($data);
        }
        
        return $result;
    }
}
