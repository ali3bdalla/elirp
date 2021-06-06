<?php

namespace App\Domains\Accounting\Jobs;

use App\Enums\AccountGroupEnum;
use App\Enums\AccountSlugsEnum;
use App\Models\Account;
use App\Models\Tax;
use Lucid\Units\Job;

class CreatedTaxAccountJob extends Job
{
    private Tax $tax;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Tax $tax)
    {
        //
        $this->tax = $tax;
    }

    /**
     * Execute the job.
     *
     * @return Account
     */
    public function handle() : Account
    {
        $parentAccount           = Account::default(AccountSlugsEnum::DEFAULT_TAX_ACCOUNT());
        $account                 = new Account();
        $account->company_id     = $this->tax->company_id;
        $account->name           = $this->tax->name;
        $account->auto_generated = true;
        $account->group          = AccountGroupEnum::TAX();
        $account->parent_id      = $parentAccount->id;
        $account->type           = $parentAccount->type;
        $account->save();
        $this->tax->update([
            'account_id' => $account->id
        ]);

        return $account;
    }
}
