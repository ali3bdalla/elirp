<?php

namespace App\Domains\Document\Jobs;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Document;
use App\Models\DocumentTotal;
use App\Models\Tax;
use Lucid\Units\Job;

class StoreDocumentTotalJob extends Job
{
    private Document $document;
    private $items;
    private FormRequest $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Document $document, $request = [])
    {
        //
        $this->document = $document;
        $this->request = parse_request_instance($request);
    }

    /**
     * Execute the job.
     *
     * @return array<DocumentTotal>
     */
    public function handle(): array
    {
        $this->request->validate([
            'totals' => 'nullable|array',
            'totals.*.code' => 'nullable|string',
            'totals.*.amount' => 'required|amount',
            'totals.*.operator' => 'required|in:addition,subtraction'
        ]);

        $precision = 2;
        $itemsQuery = $this->document->items();
        $subtotal = $itemsQuery->clone()->sum('subtotal');
        $total = $itemsQuery->clone()->sum('total');
        $totals = [];
        $discount = 0;
        foreach ($itemsQuery->clone()->get() as $item) {
            $discount += $item->discount;
        }
        $sort_order = 1;
        // Add sub total
        $totals[] = DocumentTotal::create([
            'company_id' => $this->document->company_id,
            'type' => $this->document->type,
            'document_id' => $this->document->id,
            'code' => 'total',
            'name' => 'invoices.total',
            'amount' => round($total, $precision),
            'sort_order' => $sort_order,
        ]);
        $sort_order++;

        if ($discount > 0) {
            $totals[] = DocumentTotal::create([
                'company_id' => $this->document->company_id,
                'type' => $this->document->type,
                'document_id' => $this->document->id,
                'code' => 'item_discount',
                'name' => 'invoices.item_discount',
                'amount' => round($discount, $precision),
                'sort_order' => $sort_order,
            ]);
            $sort_order++;


            $totals[] = DocumentTotal::create([
                'company_id' => $this->document->company_id,
                'type' => $this->document->type,
                'document_id' => $this->document->id,
                'code' => 'sub_total',
                'name' => 'invoices.sub_total',
                'amount' => round($subtotal, $precision),
                'sort_order' => $sort_order,
            ]);
            $sort_order++;
        }


        $taxes = $this->document->itemsTaxes()->groupBy('tax_id')->selectRaw('tax_id, sum(amount) as total_amount')->get();
        foreach ($taxes as $tax) {
            $taxEntity = Tax::findOrFail($tax['tax_id']);
            $totals[] = DocumentTotal::create([
                'company_id' => $this->document->company_id,
                'type' => $this->document->type,
                'document_id' => $this->document->id,
                'code' => 'tax',
                'name' => $taxEntity->name,
                'amount' => round($tax['total_amount'], $precision),
                'sort_order' => $sort_order,
            ])->toArray();
            $subtotal += $tax['total_amount'];
            $sort_order++;
        }

        $subtotal = round($subtotal, $precision);
        $totals[] = DocumentTotal::create([
            'company_id' => $this->document->company_id,
            'type' => $this->document->type,
            'document_id' => $this->document->id,
            'code' => 'net',
            'name' => 'invoices.net',
            'amount' => $subtotal,
            'sort_order' => $sort_order,
        ]);
        $this->document->update(
            [
                'amount' => $subtotal
            ]
        );
        return $totals;
    }
}
