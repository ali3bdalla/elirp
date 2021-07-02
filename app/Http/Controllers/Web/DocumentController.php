<?php

namespace App\Http\Controllers\Web;

use App\Enums\DocumentTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\DocumentItem;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Invoice;

class DocumentController extends Controller
{
    public function printDocument(Document $document)
    {
        if ($document->type === DocumentTypeEnum::BILL()) {
            $buyer = new Buyer([
                'name'          => Auth::user()->name,
                'custom_fields' => [
                    'email' => Auth::user()->email,
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
                'name'          => Auth::user()->name,
                'custom_fields' => [
                    'email' => Auth::user()->email,
                ],
            ]);
        }

        $invoice = Invoice::make()
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

        return $invoice->stream();
    }
}
