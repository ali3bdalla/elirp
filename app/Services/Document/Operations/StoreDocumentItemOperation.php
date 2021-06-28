<?php

namespace App\Services\Document\Operations;

use App\Domains\Document\Jobs\StoreDocumentItemJob;
use App\Domains\Document\Jobs\StoreDocumentItemTaxesJob;
use App\Models\Document;
use App\Models\DocumentItem;
use App\Models\Item;
use Illuminate\Foundation\Http\FormRequest;
use Lucid\Units\Operation;

class StoreDocumentItemOperation extends Operation
{
    private Document $document;
    private Item $item;
    private FormRequest $request;
    /**
     * @var null
     */
    private $discount;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Document $document, Item $item, $request, $discount = null)
    {
        $this->document = $document;
        $this->item     = $item;
        $this->request  = parse_request_instance($request);
        $this->discount = $discount;
    }

    /**
     * Execute the operation.
     *
     * @return DocumentItem
     */
    public function handle() : DocumentItem
    {
        $this->request->validate([
            'price'     => 'required|amount|min:0',
            'quantity'  => 'required|min:1',
            'name'      => 'required|string',
            'discount'  => 'nullable|amount|min:0',
            'tax_ids'   => 'nullable|array',
            'tax_ids.*' => 'required|integer|exists:taxes,id',
        ]);

        $documentItem = $this->run(StoreDocumentItemJob::class, [
            'document'       => $this->document,
            'item'           => $this->item,
            'data'           => $this->request->all(),
            'globalDiscount' => $this->discount
        ]);
        $documentItemTaxes = $this->run(StoreDocumentItemTaxesJob::class, [
            'documentItem' => $documentItem,
            'taxIds'       => $this->request->input('tax_ids')
        ]);

        return $documentItem;
    }
}
