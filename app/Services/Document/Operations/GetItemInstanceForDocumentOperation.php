<?php

namespace App\Services\Document\Operations;

use App\Enums\DocumentTypeEnum;
use App\Models\Item;
use App\Services\Item\Operations\StoreItemOperation;
use Illuminate\Support\Collection;
use Lucid\Units\Operation;

class GetItemInstanceForDocumentOperation extends Operation
{
    private Collection $collection;
    private DocumentTypeEnum $documentType;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(DocumentTypeEnum $documentType, $request)
    {
        $this->collection = collect($request);
        $this->documentType = $documentType;
    }

    /**
     * Execute the job.
     *
     * @return Item
     */
    public function handle(): Item
    {
        $salePrice = DocumentTypeEnum::invoice()->equals($this->documentType) ? $this->collection->get('price') : null;
        $purchasePrice = DocumentTypeEnum::bill()->equals($this->documentType) ? $this->collection->get('price') : 0;


        if ($this->collection->get('item_id')) {
            $itemEntity = Item::findOrFail($this->collection->get('item_id'));
        } else {
            $itemEntity = $this->run(StoreItemOperation::class, [
                'data' => [
                    'name' => $this->collection->get('name'),
                    'description' => $this->collection->get('description'),
                    'purchase_price' => $purchasePrice,
                    'sale_price' => $salePrice,
                ]
            ]);
        }

        return $itemEntity;
    }
}
