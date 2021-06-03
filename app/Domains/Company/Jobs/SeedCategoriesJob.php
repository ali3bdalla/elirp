<?php

namespace App\Domains\Company\Jobs;

use App\Models\Company;
use App\Models\Category;
use Lucid\Units\Job;

class SeedCategoriesJob extends Job
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
                'name' => trans_choice('general.transfers', 1),
                'type' => 'other',
                'color' => '#2c3e50',
                'enabled' => '1',
            ],
            [
                'company_id' => $this->company->id,
                'name' => trans('demo.categories.deposit'),
                'type' => 'income',
                'color' => '#efad32',
                'enabled' => '1',
            ],
            [
                'company_id' => $this->company->id,
                'name' => trans('demo.categories.sales'),
                'type' => 'income',
                'color' => '#6da252',
                'enabled' => '1',
            ],
            [
                'company_id' => $this->company->id,
                'name' => trans_choice('general.others', 1),
                'type' => 'expense',
                'color' => '#e5e5e5',
                'enabled' => '1',
            ],
            [
                'company_id' => $this->company->id,
                'name' => trans('general.general'),
                'type' => 'item',
                'color' => '#328aef',
                'enabled' => '1',
            ],
        ];

        $income_category = $expense_category = false;

        foreach ($rows as $row) {
            $category = Category::create($row);

            switch ($category->type) {
                case 'income':
                    if (empty($income_category)) {
                        $income_category = $category;
                    }
                    break;
                case 'expense':
                    if (empty($expense_category)) {
                        $expense_category = $category;
                    }
                    break;
            }
        }

        setting()->set('default.income_category', $income_category->id);
        setting()->set('default.expense_category', $expense_category->id);
    }
}
