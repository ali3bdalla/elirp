<?php

namespace App\Domains\Contact\Jobs;

use Illuminate\Foundation\Http\FormRequest;
use Lucid\Units\Job;

class ValidateContactJob extends Job
{
    public FormRequest $request;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request = parse_request_instance($request);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
       $this->request->validate([
            'email'                 => 'nullable|email:rfc,dns,spoof,filter,strict',
            'reference'              => 'nullable|min:3|string|max:200',
            'website'                       => 'nullable|string|active_url',
            'tax_number'              => 'nullable|min:3|string|max:200',
            'phone'              => 'nullable|min:8|string|max:200',
            'address'              => 'nullable|min:3|string|max:200',
            'is_vendor'              => 'required|boolean',
            'is_customer'              => 'required|boolean',
            'currency_code'              => 'nullable|min:2|string|max:4',
            'name'                  => 'required|string|max:30'
        ]);
    }
}
