<?php

namespace App\Domains\Company\Jobs;

use App\Enums\AccountGroupEnum;
use App\Enums\AccountingTypeEnum;
use App\Models\Account;
use App\Models\Company;
use Lucid\Units\Job;

class SeedCompanyAccountingEquityAccountsJob extends Job
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
        $Equity = Account::create([
            'type'           => AccountingTypeEnum::CREDIT(),
            'group'          => AccountGroupEnum::EQUITY(),
            'name'           => 'Equity',
            'auto_generated' => true,
            'company_id'     => $this->company->id
        ]);

        Account::create([
            'parent_id'      => $Equity->id,
            'type'           => AccountingTypeEnum::DEBIT(),
            'group'          => AccountGroupEnum::EQUITY(),
            'name'           => 'Withdrawals',
            'auto_generated' => true,
            'company_id'     => $this->company->id
        ]);
        Account::create([
            'parent_id'      => $Equity->id,
            'type'           => AccountingTypeEnum::CREDIT(),
            'group'          => AccountGroupEnum::EQUITY(),
            'name'           => 'capital',
            'auto_generated' => true,
            'company_id'     => $this->company->id
        ]);
    }
}
