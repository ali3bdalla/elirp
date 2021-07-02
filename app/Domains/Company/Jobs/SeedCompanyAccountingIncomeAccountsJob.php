<?php

namespace App\Domains\Company\Jobs;

use App\Enums\AccountGroupEnum;
use App\Enums\AccountingTypeEnum;
use App\Enums\AccountSlugsEnum;
use App\Models\Account;
use App\Models\Company;
use Lucid\Units\Job;

class SeedCompanyAccountingIncomeAccountsJob extends Job
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
        $incomes = Account::create(
            [
                'type'           => AccountingTypeEnum::CREDIT(),
                'group'          => AccountGroupEnum::INCOMES(),
                'name'           => 'INCOMES',
                'auto_generated' => true,
                'company_id'     => $this->company->id
            ]
        );

        Account::create(
            [
                'parent_id'      => $incomes->id,
                'type'           => AccountingTypeEnum::CREDIT(),
                'group'          => AccountGroupEnum::INCOMES(),
                'name'           => 'Sales Icomes',
                'slug'           => AccountSlugsEnum::DEFAULT_SALES_INCOMES_ACCOUNT(),
                'auto_generated' => true,
                'company_id'     => $this->company->id
            ]
        );

        Account::create(
            [
                'parent_id'      => $incomes->id,
                'type'           => AccountingTypeEnum::DEBIT(),
                'group'          => AccountGroupEnum::INCOMES(),
                'name'           => 'Sales Discounts',
                'slug'           => AccountSlugsEnum::DEFUALT_SALES_DISCOUNTS_ACCOUNT(),
                'auto_generated' => true,
                'company_id'     => $this->company->id
            ]
        );
    }
}
