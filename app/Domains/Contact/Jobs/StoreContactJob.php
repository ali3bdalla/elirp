<?php

namespace App\Domains\Contact\Jobs;

use App\Models\Contact;
use Lucid\Units\Job;

class StoreContactJob extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public array $data)
    {
    }

    /**
     * Execute the job.
     *
     * @return Contact
     */
    public function handle() : Contact
    {
        $data               = $this->data;
        $data['company_id'] = company_id();
        return Contact::create($data);
    }
}
