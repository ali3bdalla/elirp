<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Services\Bill\Features\MarkBillAsReceivedFeature;
use App\Services\Bill\Features\MarkBillAsReturnedFeature;
use App\Services\Document\Features\MarkDocumentAsPaidFeature;
use App\Services\Document\Features\MarkDocumentAsRefundedFeature;
use App\Services\Document\Features\StoreDocumentFeature;
use App\Services\Invoice\Features\MarkInvoiceAsDeliveredFeature;
use App\Services\Invoice\Features\MarkInvoiceAsReturnedFeature;

class DocumentController extends Controller
{
    public function store()
    {
        return $this->serve(StoreDocumentFeature::class);
    }

    public function recieved(Document $document)
    {
        return $this->serve(
            MarkBillAsReceivedFeature::class,
            [
                'document' => $document
            ]
        );
    }

    public function paid(Document $document)
    {
        return $this->serve(
            MarkDocumentAsPaidFeature::class,
            [
                'document' => $document
            ]
        );
    }

    public function refunded(Document $document)
    {
        return $this->serve(
            MarkDocumentAsRefundedFeature::class,
            [
                'document' => $document
            ]
        );
    }

    public function billReturned(Document $document)
    {
        return $this->serve(
            MarkBillAsReturnedFeature::class,
            [
                'document' => $document
            ]
        );
    }

    public function delivered(Document $document)
    {
        return $this->serve(
            MarkInvoiceAsDeliveredFeature::class,
            [
                'document' => $document
            ]
        );
    }

    public function invoiceReturned(Document $document)
    {
        return $this->serve(
            MarkInvoiceAsReturnedFeature::class,
            [
                'document' => $document
            ]
        );
    }
}
