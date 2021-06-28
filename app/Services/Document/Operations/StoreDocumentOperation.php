<?php

namespace App\Services\Document\Operations;

use App\Domains\Document\Jobs\CreateDocumentRecurringJob;
use App\Domains\Document\Jobs\StoreDocumentHistoryJob;
use App\Domains\Document\Jobs\StoreDocumentJob;
use App\Domains\Document\Jobs\StoreDocumentTotalJob;
use App\Domains\Document\Jobs\UploadDocumentAttachmentJob;
use App\Enums\DocumentTypeEnum;
use App\Events\Document\BillDocumentCreatedEvent;
use App\Events\Document\InvoiceDocumentCreatedEvent;
use App\Models\Document;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Lucid\Units\Operation;

class StoreDocumentOperation extends Operation
{
    private FormRequest $request;
    private DocumentTypeEnum $documentTypeEnum;

    /**
     * Create a new operation instance.
     *
     * @return void
     */
    public function __construct($request, $documentTypeEnum)
    {
        $this->request          = parse_request_instance($request);
        $this->documentTypeEnum = $documentTypeEnum;
    }

    /**
     * Execute the operation.
     *
     * @return Document
     */
    public function handle() : Document
    {
        return DB::transaction(function () {
            $document = $this->run(StoreDocumentJob::class, [
                'request'          => $this->request,
                'documentTypeEnum' => $this->documentTypeEnum
            ]);
            $this->run(UploadDocumentAttachmentJob::class, [
                'document' => $document,
                'request'  => $this->request
            ]);
            $items = $this->run(StoreDocumentItemsOperation::class, [
                'request'  => $this->request,
                'discount' => $this->request->input('discount', 0),
                'document' => $document
            ]);
            $this->run(StoreDocumentTotalJob::class, [
                'document' => $document,
            ]);

            $this->run(StoreDocumentHistoryJob::class, [
                'document'    => $document,
                'notify'      => 0,
                'description' => trans('messages.success.added', ['type' => $document->document_number])
            ]);
            if ($document->type == DocumentTypeEnum::INVOICE()) {
                event(new InvoiceDocumentCreatedEvent($document));
            } else {
                event(new BillDocumentCreatedEvent($document));
            }

            return $document;
        });
    }
}
