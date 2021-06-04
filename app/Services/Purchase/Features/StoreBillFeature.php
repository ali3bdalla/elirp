<?php

namespace App\Services\Purchase\Features;

use App\Domains\Document\Jobs\CreateDocumentHistoryJob;
use Illuminate\Foundation\Http\FormRequest;
use App\Enums\DocumentTypeEnum;
use App\Services\Document\Operations\StoreDocumentOperation;
use Illuminate\Http\JsonResponse;
use Lucid\Units\Feature;

class StoreBillFeature extends Feature
{
    private FormRequest $request;

    public function __construct($request)
    {
        $this->request = parse_request_instance($request);
    }

    public function handle(): JsonResponse
    {
        $document = $this->run(StoreDocumentOperation::class, [
            'request' => $this->request,
            'documentTypeEnum' => DocumentTypeEnum::BILL()
        ]);
    
       
        return $document;
    }
}
