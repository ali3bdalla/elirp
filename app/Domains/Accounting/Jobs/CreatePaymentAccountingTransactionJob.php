<?php

namespace App\Domains\Accounting\Jobs;

use App\Enums\AccountingTypeEnum;
use App\Enums\PaymentTypeEnum;
use App\Models\Entry;
use App\Models\Payment;
use App\Models\Transaction;
use Lucid\Units\Job;

class CreatePaymentAccountingTransactionJob extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private Payment $payment, private Entry $entry)
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
        $account         = $this->payment->paymentMethod?->account;
        $transactionType = $this->payment->type->equals(PaymentTypeEnum::PAYMENT()) ? AccountingTypeEnum::CREDIT() : AccountingTypeEnum::DEBIT();
        $amount          =round($this->payment->amount, 2);
        return Transaction::create(
            [
                'document_id'   => $this->payment->document_id,
                'account_id'    => $account->id,
                'payment_id'    => $this->payment->id,
                'amount'        => $amount,
                'type'          => $transactionType,
                'entry_id'      => $this->entry->id,
                'currency_code' => 'USD',
                'currency_rate' => 1,
                'company_id'    => company_id(),
            ]
        );
    }
}
