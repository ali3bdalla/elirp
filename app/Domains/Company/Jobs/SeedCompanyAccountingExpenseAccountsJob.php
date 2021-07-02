<?php

namespace App\Domains\Company\Jobs;

use App\Enums\AccountGroupEnum;
use App\Enums\AccountingTypeEnum;
use App\Enums\AccountSlugsEnum;
use App\Models\Account;
use App\Models\Company;
use Lucid\Units\Job;

class SeedCompanyAccountingExpenseAccountsJob extends Job
{
    private Company $company;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Company $company)
    {
        //
        $this->company = $company;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $Expense = Account::create(
            [
                'type'           => AccountingTypeEnum::DEBIT(),
                'group'          => AccountGroupEnum::EXPENSE(),
                'name'           => 'Expense',
                'auto_generated' => true,
                'company_id'     => $this->company->id
            ]
        );

        Account::create(
            [
                'parent_id'      => $Expense->id,
                'type'           => AccountingTypeEnum::DEBIT(),
                'group'          => AccountGroupEnum::EQUITY(),
                'name'           => 'inventory adjustments',
                'auto_generated' => true,
                'company_id'     => $this->company->id
            ]
        );

        Account::create(
            [
                'parent_id'      => $Expense->id,
                'type'           => AccountingTypeEnum::DEBIT(),
                'group'          => AccountGroupEnum::EQUITY(),
                'name'           => 'COGS',
                'slug'           => AccountSlugsEnum::DEFAULT_COGS_ACCOUNT(),
                'auto_generated' => true,
                'company_id'     => $this->company->id
            ]
        );
    }
}
