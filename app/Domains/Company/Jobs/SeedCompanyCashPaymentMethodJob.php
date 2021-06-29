<?php

namespace App\Domains\Company\Jobs;

use App\Models\Company;
use App\Models\PaymentMethod;
use Lucid\Units\Job;

class SeedCompanyCashPaymentMethodJob extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public Company $company)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return PaymentMethod
     */
    public function handle() : PaymentMethod
    {
        return PaymentMethod::create(
            [
                'name' => "Cash",
                'description' => "Auto Created Cash Payment Method",
                'company_id' => $this->company->id,
                'enabled' => true
            ]
        );
    }
}
