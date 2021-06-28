<?php

namespace App\Services\Document\Features;

use App\Enums\DocumentTypeEnum;
use App\Services\Document\Operations\StoreDocumentOperation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Lucid\Units\Feature;

class StoreDocumentFeature extends Feature
{


    public function handle(Request $request)
    {
        $document = $this->run(StoreDocumentOperation::class, [
            'request'          => $request->all(),
            'documentTypeEnum' => DocumentTypeEnum::from($request->input('type'))
        ]);

        return $document;
    }
}
