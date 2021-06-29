<?php

namespace App\Domains\Payment\Jobs;

use App\Models\Payment;
use Lucid\Units\Job;

class CreatePaymentJob extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private array $data)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return Payment
     */
    public function handle() : Payment
    {
        $this->data['company_id'] = company_id();
        return Payment::create($this->data);
    }
}
