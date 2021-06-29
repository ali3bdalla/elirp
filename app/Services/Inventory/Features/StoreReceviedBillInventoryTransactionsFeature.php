<?php

namespace App\Services\Inventory\Features;

use App\Models\Document;
use Illuminate\Http\Request;
use Lucid\Units\Feature;

class StoreReceviedBillInventoryTransactionsFeature extends Feature
{
    public function __construct(public Document $document)
    {
        // code...
    }
    public function handle(Request $request)
    {
    }
}
