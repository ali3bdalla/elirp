<?php

namespace App\Domains\Company\Jobs;

use App\Enums\AccountGroupEnum;
use App\Enums\AccountingTypeEnum;
use App\Enums\AccountSlugsEnum;
use App\Models\Account;
use App\Models\Company;
use Lucid\Units\Job;

class SeedCompanyAccountingAssetsAccountsJob extends Job
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
        $assets = Account::create([
            'type'           => AccountingTypeEnum::DEBIT(),
            'group'          => AccountGroupEnum::ASSETS(),
            'name'           => 'Assets',
            'auto_generated' => true,
            'company_id'     => $this->company->id
        ]);

        $currentAssets = Account::create([
            'parent_id'      => $assets->id,
            'type'           => AccountingTypeEnum::DEBIT(),
            'group'          => AccountGroupEnum::CURRENT_ASSETS(),
            'name'           => 'Current Assets',
            'auto_generated' => true,
            'company_id'     => $this->company->id
        ]);

        $customers = Account::create([
            'parent_id'      => $currentAssets->id,
            'type'           => AccountingTypeEnum::DEBIT(),
            'group'          => AccountGroupEnum::RECEIVABLE(),
            'name'           => 'Receivalbe Customers',
            'slug'           => AccountSlugsEnum::DEFAULT_RECEIABLE_ACCOUNT(),
            'auto_generated' => true,
            'company_id'     => $this->company->id
        ]);

        $cash = Account::create([
            'parent_id'      => $currentAssets->id,
            'type'           => AccountingTypeEnum::DEBIT(),
            'group'          => AccountGroupEnum::BANK(),
            'name'           => 'Cash',
            'slug'           => AccountSlugsEnum::DEFAULT_BANK_ACCOUNT(),
            'auto_generated' => true,
            'company_id'     => $this->company->id
        ]);

        $stock = Account::create([
            'parent_id'      => $currentAssets->id,
            'type'           => AccountingTypeEnum::DEBIT(),
            'group'          => AccountGroupEnum::CURRENT_ASSETS(),
            'name'           => 'Stock',
            'slug'           => AccountSlugsEnum::DEFAULT_STOCK_ACCOUNT(),
            'auto_generated' => true,
            'company_id'     => $this->company->id
        ]);
        $bank = Account::create([
            'parent_id'      => $currentAssets->id,
            'type'           => AccountingTypeEnum::DEBIT(),
            'group'          => AccountGroupEnum::BANK(),
            'name'           => 'Bank',
            'auto_generated' => true,
            'company_id'     => $this->company->id
        ]);

        $fixedAssets = Account::create([
            'parent_id'      => $assets->id,
            'type'           => AccountingTypeEnum::DEBIT(),
            'group'          => AccountGroupEnum::FIXED_ASSETS(),
            'name'           => 'Fixed Assets',
            'auto_generated' => true,
            'company_id'     => $this->company->id
        ]);
    }
}
