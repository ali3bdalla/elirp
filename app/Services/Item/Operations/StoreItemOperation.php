<?php

namespace App\Services\Item\Operations;

use Illuminate\Foundation\Http\FormRequest;
use App\Domains\Item\Jobs\StoreItemJob;
use App\Domains\Item\Jobs\StoreItemTaxesJob;
use App\Domains\Item\Jobs\ValidateItemJob;
use App\Events\Item\ItemCreatedEvent;
use App\Models\Item;
use Illuminate\Support\Collection;
use Lucid\Units\Operation;

class StoreItemOperation extends Operation
{
    private FormRequest $request;

    /**
     * Create a new operation instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        //
        $this->request = parse_request_instance($data);
    }

    /**
     * Execute the operation.
     *
     * @return ?Item
     */
    public function handle(): ?Item
    {
        $this->run(ValidateItemJob::class, [
            'request' => $this->request
        ]);
        $item = $this->run(StoreItemJob::class, [
            'data' => $this->request
        ]);
        $itemTaxes = $this->run(StoreItemTaxesJob::class, [
            'item' => $item,
            'taxesIds' => $this->request->input('tax_ids')
        ]);
        event(new ItemCreatedEvent($item));
        return $item;
    }
}
