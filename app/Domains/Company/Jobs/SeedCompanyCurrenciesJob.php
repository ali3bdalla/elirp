<?php

namespace App\Domains\Company\Jobs;

use App\Models\Company;
use App\Models\Currency;
use Lucid\Units\Job;

class SeedCompanyCurrenciesJob extends Job
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
                'company_id'          => $this->company->id,
                'name'                => trans('demo.currencies.sar'),
                'code'                => 'SAR',
                'rate'                => '3.75',
                'precision'           => config('money.SAR.precision'),
                'symbol'              => config('money.SAR.symbol'),
                'symbol_first'        => config('money.SAR.symbol_first'),
                'decimal_mark'        => config('money.SAR.decimal_mark'),
                'thousands_separator' => config('money.SAR.thousands_separator'),
            ],

            [
                'company_id'          => $this->company->id,
                'name'                => trans('demo.currencies.usd'),
                'code'                => 'USD',
                'rate'                => '1.00',
                'enabled'             => '1',
                'precision'           => config('money.USD.precision'),
                'symbol'              => config('money.USD.symbol'),
                'symbol_first'        => config('money.USD.symbol_first'),
                'decimal_mark'        => config('money.USD.decimal_mark'),
                'thousands_separator' => config('money.USD.thousands_separator'),
            ],
            [
                'company_id'          => $this->company->id,
                'name'                => trans('demo.currencies.eur'),
                'code'                => 'EUR',
                'rate'                => '1.25',
                'precision'           => config('money.EUR.precision'),
                'symbol'              => config('money.EUR.symbol'),
                'symbol_first'        => config('money.EUR.symbol_first'),
                'decimal_mark'        => config('money.EUR.decimal_mark'),
                'thousands_separator' => config('money.EUR.thousands_separator'),
            ],
        ];

        foreach ($rows as $row) {
            Currency::create($row);
        }
    }
}
