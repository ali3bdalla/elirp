<?php

namespace App\Services\Document\Operations;

use Illuminate\Foundation\Http\FormRequest;
use App\Domains\Document\Jobs\ValidateDocumentItemsJob;
use App\Enums\DocumentTypeEnum;
use App\Models\Document;
use App\Models\DocumentItem;
use Lucid\Units\Operation;

class StoreDocumentItemsOperation extends Operation
{
    private FormRequest $request;
    private Document $document;
    /**
     * @var null
     */
    private $discount;

    /**
     * Create a new operation instance.
     *
     * @return void
     */
    public function __construct(Document $document, $request, $discount = 0)
    {
        //
        $this->request = parse_request_instance($request);
        $this->document = $document;
        $this->discount = $discount;
    }

    /**
     * Execute the operation.
     *
     * @return array<DocumentItem>
     */
    public function handle(): array
    {
        $this->run(ValidateDocumentItemsJob::class, [
            'request' => $this->request
        ]);

        $items = [];
        foreach ($this->request->input('items') as $item) {
            $itemCollection = collect($item);
            $itemEntity = $this->run(GetItemInstanceForDocumentOperation::class, [
                'documentType' => $this->document->type,
                'request' => $itemCollection
            ]);
            $items[] = $this->run(StoreDocumentItemOperation::class, [
                'document' => $this->document,
                'item' => $itemEntity,
                'discount' => $this->discount,
                'request' => $itemCollection->toArray()
            ]);
        }
        return $items;
    }
}
