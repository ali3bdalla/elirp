<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Document\Features\StoreDocumentFeature;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function store()
    {
        return $this->serve(StoreDocumentFeature::class);
    }
}
