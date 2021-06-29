<?php

namespace App\Services\Company\Operations;

use App\Domains\Company\Jobs\SeedCompanyAccountingAssetsAccountsJob;
use App\Domains\Company\Jobs\SeedCompanyAccountingEquityAccountsJob;
use App\Domains\Company\Jobs\SeedCompanyAccountingExpenseAccountsJob;
use App\Domains\Company\Jobs\SeedCompanyAccountingIncomeAccountsJob;
use App\Domains\Company\Jobs\SeedCompanyAccountingLiabilitiesAccountsJob;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Lucid\Units\Operation;

class SeedCompanyBaseAccountsOperation extends Operation
{
    private Company $company;

    /**
     * Create a new operation instance.
     *
     * @return void
     */
    public function __construct(Company $company)
    {
        //
        $this->company = $company;
    }

    /**
     * Execute the operation.
     *
     * @return void
     */
    public function handle()
    {
        DB::transaction(
            function () {
                $this->run(
                    SeedCompanyAccountingAssetsAccountsJob::class,
                    [
                    'company' => $this->company
                    ]
                );
                $this->run(
                    SeedCompanyAccountingLiabilitiesAccountsJob::class,
                    [
                    'company' => $this->company
                    ]
                );

                $this->run(
                    SeedCompanyAccountingEquityAccountsJob::class,
                    [
                    'company' => $this->company
                    ]
                );
                $this->run(
                    SeedCompanyAccountingIncomeAccountsJob::class,
                    [
                    'company' => $this->company
                    ]
                );
                $this->run(
                    SeedCompanyAccountingExpenseAccountsJob::class,
                    [
                    'company' => $this->company
                    ]
                );
            }
        );
    }
}
