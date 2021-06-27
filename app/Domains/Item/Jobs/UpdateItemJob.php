<?php

namespace App\Domains\Item\Jobs;

use App\Models\Item;
use Illuminate\Foundation\Http\FormRequest;
use Lucid\Units\Job;

class UpdateItemJob extends Job
{
    private FormRequest $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public Item  $item, $data)
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
        $this->item->update($data);
        return $this->item->fresh();
    }
}
