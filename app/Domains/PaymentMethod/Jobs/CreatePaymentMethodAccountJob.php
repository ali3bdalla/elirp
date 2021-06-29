<?php

namespace App\Domains\PaymentMethod\Jobs;

use App\Enums\AccountGroupEnum;
use App\Enums\AccountSlugsEnum;
use App\Models\Account;
use App\Models\PaymentMethod;
use Lucid\Units\Job;

class CreatePaymentMethodAccountJob extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public PaymentMethod $paymentMethod)
    {
    }

    /**
     * Execute the job.
     *
     * @return Account
     */
    public function handle() : Account
    {
        $parentAccount           = Account::default(AccountSlugsEnum::DEFAULT_BANK_ACCOUNT());
        $account                 = new Account();
        $account->company_id     = $this->paymentMethod->company_id;
        $account->name           = $this->paymentMethod->name;
        $account->auto_generated = true;
        $account->group          = AccountGroupEnum::BANK();
        $account->parent_id      = $parentAccount->id;
        $account->type           = $parentAccount->type;
        $account->save();
        $this->paymentMethod->update(
            [
            'account_id' => $account->id
            ]
        );

        return $account;
    }
}
