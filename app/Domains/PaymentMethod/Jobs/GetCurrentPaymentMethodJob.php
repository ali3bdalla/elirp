<?php

namespace App\Domains\PaymentMethod\Jobs;

use App\Domains\Company\Jobs\SeedCompanyCashPaymentMethodJob;
use App\Models\PaymentMethod;
use Lucid\Units\Job;

class GetCurrentPaymentMethodJob extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
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
        $paymentMethod = PaymentMethod::first();
        if (!$paymentMethod) {
            $createJob = new SeedCompanyCashPaymentMethodJob(company());
            $paymentMethod= $createJob->handle();
        }
        return $paymentMethod;
    }
}
