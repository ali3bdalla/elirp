<?php

namespace App\Services\Document\Features;

use App\Enums\DocumentTypeEnum;
use App\Notifications\Document\DocumentDraftedNotification;
use App\Services\Document\Operations\StoreDocumentOperation;
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
        $document->contact->notify(new DocumentDraftedNotification($document));
        return $document;
    }
}
