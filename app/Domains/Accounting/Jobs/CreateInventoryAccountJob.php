<?php

namespace App\Domains\Accounting\Jobs;

use App\Enums\AccountGroupEnum;
use App\Enums\AccountSlugsEnum;
use App\Models\Account;
use App\Models\Inventory;
use Lucid\Units\Job;

class CreateInventoryAccountJob extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public Inventory $inventory)
    {
    }

    /**
     * Execute the job.
     *
     * @return Account
     */
    public function handle() : Account
    {
        $parentAccount           = Account::default(AccountSlugsEnum::DEFAULT_STOCK_ACCOUNT());
        $account                 = new Account();
        $account->company_id     = $this->inventory->company_id;
        $account->name           = $this->inventory->name;
        $account->auto_generated = true;
        $account->group          = AccountGroupEnum::CURRENT_ASSETS();
        $account->parent_id      = $parentAccount->id;
        $account->type           = $parentAccount->type;
        $account->save();
        $this->inventory->update(
            [
                'account_id' => $account->id
            ]
        );

        return $account;
    }
}
