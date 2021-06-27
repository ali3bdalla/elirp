<?php

namespace App\Services\Item\Features;

use App\Domains\Item\Jobs\StoreItemJob;
use App\Domains\Item\Jobs\ValidateItemJob;
use App\Domains\Item\Jobs\ValidateNewItemJob;
use Illuminate\Http\Request;
use Lucid\Units\Feature;

class StoreItemFeature extends Feature
{
    public function handle(Request $request)
    {
        $this->run(ValidateItemJob::class, [
            'request' => $request->all()
        ]);
        return $this->run(StoreItemJob::class, [
            'data' => $request->only('name', 'sku', 'model_number', 'model_name', 'brand', 'sale_price', 'purchase_price', 'description', 'tags')
        ]);
    }
}
