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
            'id' => 'nullable|integer|exists:items,id',
            'name' => 'required|string',
            'sku' => 'nullable|string',
            'description' => 'nullable|string',
            'sale_price' => 'nullable|amount',
            'purchase_price' => 'nullable|amount',
            'fixed_price' => 'nullable|boolean',
            'is_service' => 'nullable|boolean',
            'has_detail' => 'nullable|boolean',
            'picture' => 'nullable|image', //mimes:\' . config(\'filesystems.mimes\') . \'|between:0,\' . config
            //(\'filesystems.max_size\') * 1024
            'tax_ids' => 'nullable|array',
            'tax_ids.*' => 'required|integer|exists:taxes,id'
        ]);
    }
}
