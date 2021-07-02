<?php

namespace App\Domains\Accounting\Jobs;

use App\Enums\AccountingTypeEnum;
use App\Enums\AccountSlugsEnum;
use App\Models\Account;
use App\Models\Document;
use App\Models\Entry;
use Lucid\Units\Job;

class StoreDeliveredInvoiceCogsTransactionsJob extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private Entry $entry, private Document $document, private array $inventoryTransactions = [], private bool $reverse = false)
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $cogsAmount = 0;
        foreach (collect($this->inventoryTransactions) as $item) {
            $cogsAmount = $cogsAmount + (round($item->unit_cost * $item->quantity, 2));
        }
        $payable               = Account::default(AccountSlugsEnum::DEFAULT_COGS_ACCOUNT());
        $data['entry_id']      = $this->entry->id;
        $data['is_pending']    = $this->entry->is_pending;
        $data['reference']     = uniqid('transaction_');
        $data['amount']        = round($cogsAmount, 2);
        $data['company_id']    = $this->entry->company_id;
        $data['document_id']   = $this->document->id;
        $data['currency_rate'] = $this->document->currency_rate;
        $data['currency_code'] = $this->document->currency_code;
        $data['type']          = $this->reverse ? AccountingTypeEnum::CREDIT() : AccountingTypeEnum::DEBIT();
        return $payable->transactions()->create($data);
    }
}
