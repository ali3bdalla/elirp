<?php

namespace App\Domains\Document\Jobs;

use Illuminate\Foundation\Http\FormRequest;
use Lucid\Units\Job;

class ValidateDocumentItemsJob extends Job
{
    private FormRequest $request;

    /**
     * Create a new job instance.
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
     * @return FormRequest
     */
    public function handle()
    {
        $this->request->validate([
            'items'             => 'required|array',
            'items.*.item_id'   => 'nullable',
            'items.*.name'      => 'required|string',
            'items.*.quantity'  => 'required|numeric',
            'items.*.price'     => 'required|amount',
            'items.*.tax_ids'   => 'nullable|array',
            'items.*.tax_ids.*' => 'required|integer|exists:taxes,id',
        ]);

        return $this->request;
    }
}
