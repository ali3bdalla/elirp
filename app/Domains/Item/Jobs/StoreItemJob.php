<?php

namespace App\Domains\Item\Jobs;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Item;
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
        $data = $this->request->only(
            'name',
            'sale_price',
            'purchase_price',
            "sku",
            "description"
        );
        $data['fixed_price'] = $this->request->input('fixed_price', false);
        $data['is_service'] = $this->request->input('is_service', false);
        $data['has_detail'] = $this->request->input('has_detail', false);

        $item =  Auth::user()->company->items()->create($data);

        if ($this->request->file('picture')) {
            $media = $this->getMedia($this->request->file('picture'), 'items');
            $item->attachMedia($media, 'picture');
        }

        return $item;
    }
}
