<?php

namespace App\Domains\Item\Jobs;

use App\Models\Item;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Lucid\Units\Job;

class StoreItemJob extends Job
{
    private FormRequest $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->request = parse_request_instance($data);
    }

    /**
     * Execute the job.
     *
     * @return Item
     */
    public function handle(): Item
    {

        $data = $this->request->all();
        $data['company_id'] = company_id();
        return Item::create($data);
    }
}
