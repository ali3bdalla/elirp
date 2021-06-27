<?php

namespace App\Services\Item\Features;

use App\Domains\Item\Jobs\UpdateItemJob;
use App\Domains\Item\Jobs\ValidateItemJob;
use App\Models\Item;
use Illuminate\Http\Request;
use Lucid\Units\Feature;

class UpdateItemFeature extends Feature
{
    public function __construct(public Item $item)
    {
        # code...
    }
    public function handle(Request $request)
    {
        $this->run(ValidateItemJob::class, [
            'request' => $request->all()
        ]);

        return $this->run(UpdateItemJob::class, [
            'item' => $this->item,
            'data' => $request->all()
        ]);
    }
}
