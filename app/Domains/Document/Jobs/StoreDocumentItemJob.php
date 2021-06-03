<?php

namespace App\Domains\Document\Jobs;

use App\Models\Item;
use App\Models\Document;
use App\Models\DocumentItem;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Lucid\Units\Job;

class StoreDocumentItemJob extends Job
{
    private Document $document;
    private Item $item;
    private Collection $data;
    private int $globalDiscount;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Document $document, Item $item, $data, $globalDiscount = 0)
    {
        $this->document = $document;
        $this->item = $item;
        $this->data = new Collection($data);
        $this->globalDiscount = (int)$globalDiscount;
    }

    /**
     * Execute the job.
     *
     * @return DocumentItem
     */
    public function handle(): DocumentItem
    {
        $precision = config('money.' . $this->document->currency_code . '.precision');
        $price = (float)$this->data->get('price');
        $quantity = (float)$this->data->get('quantity');
        $total = $price * $quantity;
        $discountRate = (float)$this->globalDiscount + (float)$this->data->get('discount', 0);
        $discount = round((float)($discountRate * ($total / 100)), $precision);
        $subtotal = $total - $discount;

        $request['type'] = $this->document->type;
        $request['company_id'] = $this->document->company_id;
        $request['document_id'] = $this->document->id;
        $request['item_id'] = $this->item->id;
        $request['name'] = Str::limit($this->data->get('name'), 180, '');
        $request['description'] = $this->data->get('description');
        $request['quantity'] = $quantity;
        $request['price'] = round($price, $precision);
        $request['tax'] = round(0, $precision);
        $request['discount_rate'] = $discountRate;
        $request['subtotal'] = $subtotal;
        $request['total'] = round($total, $precision);
        return DocumentItem::create($request);
    }
}
