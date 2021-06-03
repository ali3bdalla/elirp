<?php

namespace App\Domains\Accounting\Jobs;

use App\Enums\AccountingTypeEnum;
use App\Enums\AccountSlugsEnum;
use App\Models\Account;
use App\Models\Entry;
use App\Models\Transaction;
use App\Models\Document;
use App\Models\Tax;
use Lucid\Units\Job;

class StoreReceviedBillTaxTransactionsJob extends Job
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
        $taxes = $this->document->itemsTaxes()->whereHas('tax')->groupBy('tax_id')->selectRaw('tax_id,sum(amount) as tax_mount')->pluck('tax_mount', 'tax_id')->toArray();
        $result = [];
        foreach ($taxes as $taxId => $taxAmount) {
            $tax = Tax::find($taxId);
            $account = Account::find($tax->account_id);
            if ($taxAmount) {
                $data['entry_id'] = $this->entry->id;
                $data['is_pending'] = $this->entry->is_pending;
                $data['reference'] = uniqid('transaction_');
                $data['amount'] = $taxAmount;
                $data['contact_id'] = $this->document->contact_id;
                $data['company_id'] = $this->entry->company_id;
                $data['document_id'] = $this->document->id;
                $data['currency_rate'] = $this->document->currency_rate;
                $data['currency_code'] = $this->document->currency_code;
                $data['type'] = AccountingTypeEnum::DEBIT();
                $result[] = $account->transactions()->create($data);
            }
        }


        return $result;
    }
}
