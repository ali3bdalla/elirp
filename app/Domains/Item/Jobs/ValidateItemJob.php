<?php

namespace App\Domains\Item\Jobs;

use Illuminate\Foundation\Http\FormRequest;
use Lucid\Units\Job;

class ValidateItemJob extends Job
{
    private FormRequest $request;

    /**
     * Create a new operation instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        //
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
            'id'             => 'nullable|integer|exists:items,id',
            'name' => 'required|string|min:4|max:200',
            'sku' => 'nullable|string|max:200',
            'model_number' => 'nullable|string|max:200',
            'model_name' => 'nullable|string|max:200',
            'brand' => 'nullable|string|max:200',
            'sale_price' => 'nullable|amount|numeric|min:0|max:100000',
            'purchase_price' => 'nullable|amount|numeric|min:0|max:100000',
            'tags' => 'nullable|string|max:2000',
            'description' => 'nullable|string|max:500'
        ]);
    }
}
