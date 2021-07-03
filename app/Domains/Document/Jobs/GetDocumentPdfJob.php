<?php

namespace App\Domains\Document\Jobs;

use App\Enums\DocumentTypeEnum;
use App\Models\Document;
use App\Models\DocumentItem;
use Illuminate\Support\Carbon;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Invoice;
use Lucid\Units\Job;

class GetDocumentPdfJob extends Job
{
    private Document $document;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Document $document)
    {
        //
        $this->document=$document;
    }

    /**
     * Execute the job.
     *
     * @return Invoice
     */
    public function handle() : Invoice
    {
        $document = $this->document;
        if ($document->type === DocumentTypeEnum::BILL()) {
            $buyer = new Buyer([
                'name'          => webUser()->name,
                'custom_fields' => [
                    'email' => webUser()->email,
                ],
            ]);

            $seller = new Buyer([
                'name'          => $document->contact_name,
                'custom_fields' => [
                    'email' => $document->contact_email,
                ],
            ]);
        } else {
            $buyer = new Buyer([
                'name'          => $document->contact_name,
                'custom_fields' => [
                    'email' => $document->contact_email,
                ],
            ]);

            $seller = new Buyer([
                'name'          => webUser()->name,
                'custom_fields' => [
                    'email' => webUser()->email,
                ],
            ]);
        }

        return Invoice::make()
            ->buyer($buyer)
            ->seller($seller)
            ->series($document->document_number)
            ->sequence($document->id)
            ->serialNumberFormat('{SEQUENCE}/{SERIES}')
            ->name($document->type.' - '.$document->status)
            ->notes("{$document->notes}")
            ->date(Carbon::parse($document->issued_at))
            ->template()
            ->addItems($document->items()->get()->map(function (DocumentItem $documentItem) {
                return  (new InvoiceItem())->title($documentItem->name)->pricePerUnit($documentItem->price)
                    ->quantity($documentItem->quantity)
                    ->subTotalPrice($documentItem->subtotal)
                    ->discount($documentItem->discount);
            }));
    }
}
