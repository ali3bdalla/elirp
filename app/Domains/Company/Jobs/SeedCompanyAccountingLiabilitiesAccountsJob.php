<?php

namespace App\Domains\Company\Jobs;

use App\Enums\AccountGroupEnum;
use App\Enums\AccountingTypeEnum;
use App\Enums\AccountSlugsEnum;
use App\Models\Account;
use App\Models\Company;
use Lucid\Units\Job;

class SeedCompanyAccountingLiabilitiesAccountsJob extends Job
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
        $Liabilities = Account::create([
            'type' => AccountingTypeEnum::DEBIT(),
            'group' => AccountGroupEnum::LIABILITIES(),
            'name' => 'Liabilities',
            'auto_generated' => true,
            'company_id' => $this->company->id
        ]);

        $currentLiabilities = Account::create([
            'parent_id' => $Liabilities->id,
            'type' => AccountingTypeEnum::DEBIT(),
            'group' => AccountGroupEnum::CURRENT_LIABILITIES(),
            'name' => 'Current Liabilities',
            'auto_generated' => true,
            'company_id' => $this->company->id
        ]);

        $vendors = Account::create([
            'parent_id' => $currentLiabilities->id,
            'type' => AccountingTypeEnum::CREDIT(),
            'group' => AccountGroupEnum::PAYABLE(),
            'name' => 'Payable Vendors',
            'slug' => AccountSlugsEnum::DEFAULT_PAYABLE_ACCOUNT(),
            'auto_generated' => true,
            'company_id' => $this->company->id
        ]);
        $tax = Account::create([
            'parent_id' => $currentLiabilities->id,
            'type' => AccountingTypeEnum::CREDIT(),
            'group' => AccountGroupEnum::TAX(),
            'name' => 'Tax',
            'auto_generated' => true,
            'slug' => AccountSlugsEnum::DEFAULT_TAX_ACCOUNT(),
            'company_id' => $this->company->id
        ]);
    }
}
