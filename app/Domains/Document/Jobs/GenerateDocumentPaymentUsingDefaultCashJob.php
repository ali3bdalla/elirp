<?php

namespace App\Domains\Document\Jobs;

use App\Enums\AccountSlugsEnum;
use App\Models\Account;
use App\Models\Document;
use Lucid\Units\Job;

class GenerateDocumentPaymentUsingDefaultCashJob extends Job
{
    private Document $document;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Document $document)
    {
        //
        $this->document = $document;
    }

    /**
     * Execute the job.
     *
     * @return array
     */
    public function handle() : array
    {
        $default = Account::default(AccountSlugsEnum::DEFAULT_BANK_ACCOUNT());

        return [
            'account_id' => $default->id,
            'amount'     => $this->document->amount
        ];
    }
}
