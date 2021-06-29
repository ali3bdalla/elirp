<?php

namespace App\Domains\Accounting\Jobs;

use App\Enums\AccountingTypeEnum;
use App\Enums\AccountSlugsEnum;
use App\Enums\DocumentTypeEnum;
use App\Enums\PaymentTypeEnum;
use App\Models\Account;
use App\Models\Document;
use App\Models\Entry;
use App\Models\Payment;
use App\Models\Transaction;
use Lucid\Units\Job;

class StorePaidDocumentContactTransactionJob extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public Entry $entry, private Document $document, private Payment $payment)
    {
    }

    /**
     * Execute the job.
     *
     * @return Transaction
     */
    public function handle() : Transaction
    {
        if ($this->document->type->equals(DocumentTypeEnum::BILL())) {
            $contactAccount = Account::default(AccountSlugsEnum::DEFAULT_PAYABLE_ACCOUNT());
        } else {
            $contactAccount = Account::default(AccountSlugsEnum::DEFAULT_RECEIVABLE_ACCOUNT());
        }
        if ($this->payment->type->equals(PaymentTypeEnum::PAYMENT())) {
            $transactionType = AccountingTypeEnum::DEBIT();
        } else {
            $transactionType = AccountingTypeEnum::CREDIT();
        }
        $data['entry_id']      = $this->entry->id;
        $data['is_pending']    = $this->entry->is_pending;
        $data['reference']     = uniqid('transaction_');
        $data['amount']        = $this->document->amount;
        $data['contact_id']    = $this->document->contact_id;
        $data['company_id']    = $this->entry->company_id;
        $data['document_id']   = $this->document->id;
        $data['currency_rate'] = $this->document->currency_rate;
        $data['currency_code'] = $this->document->currency_code;
        $data['type']          = $transactionType;
        return $contactAccount->transactions()->create($data);
    }
}
