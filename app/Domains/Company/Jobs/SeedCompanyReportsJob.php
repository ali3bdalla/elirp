<?php

namespace App\Domains\Company\Jobs;

use App\Models\Company;
use App\Models\Report;
use Lucid\Units\Job;

class SeedCompanyReportsJob extends Job
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
        $rows = [
            [
                'company_id' => $this->company->id,
                'class' => 'App\Reports\IncomeSummary',
                'name' => trans('reports.summary.income'),
                'description' => trans('demo.reports.income'),
                'settings' => ['group' => 'category', 'period' => 'monthly', 'basis' => 'accrual', 'chart' => 'line'],
            ],
            [
                'company_id' => $this->company->id,
                'class' => 'App\Reports\ExpenseSummary',
                'name' => trans('reports.summary.expense'),
                'description' => trans('demo.reports.expense'),
                'settings' => ['group' => 'category', 'period' => 'monthly', 'basis' => 'accrual', 'chart' => 'line'],
            ],
            [
                'company_id' => $this->company->id,
                'class' => 'App\Reports\IncomeExpenseSummary',
                'name' => trans('reports.summary.income_expense'),
                'description' => trans('demo.reports.income_expense'),
                'settings' => ['group' => 'category', 'period' => 'monthly', 'basis' => 'accrual', 'chart' => 'line'],
            ],
            [
                'company_id' => $this->company->id,
                'class' => 'App\Reports\ProfitLoss',
                'name' => trans('reports.profit_loss'),
                'description' => trans('demo.reports.profit_loss'),
                'settings' => ['group' => 'category', 'period' => 'quarterly', 'basis' => 'accrual'],
            ],
            [
                'company_id' => $this->company->id,
                'class' => 'App\Reports\TaxSummary',
                'name' => trans('reports.summary.tax'),
                'description' => trans('demo.reports.tax'),
                'settings' => ['period' => 'quarterly', 'basis' => 'accrual'],
            ],
        ];

        foreach ($rows as $row) {
            Report::create($row);
        }
    }
}
