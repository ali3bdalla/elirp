<?php

namespace App\Http\Controllers\Web;

use App\Enums\DocumentTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\Document;
use Inertia\Inertia;

class InvoiceController extends Controller
{
    public function index()
    {
        return Inertia::render(
            'Documents/Index',
            [
                'type'       => DocumentTypeEnum::INVOICE()->value,
                'title'      => 'invoice',
                'create_url' => route('invoices.create'),
                'url'        => route('invoices.index')
            ]
        );
    }

    public function create()
    {
        return Inertia::render(
            'Documents/Create',
            [
                'document_number' => Document::generatedNextDocumentNumber(DocumentTypeEnum::INVOICE()),
                'type'            => DocumentTypeEnum::INVOICE()->label,
                'title'           => 'invoice',
                'url'             => route('invoices.index')
            ]
        );
    }

    public function edit(Document $invoice)
    {
        return Inertia::render(
            'Documents/Edit',
            [
                'type'     => $invoice->type,
                'document' => $invoice->load('items.item', 'contact', 'histories.createdBy', 'transactions.account', 'inventoryTransactions.item'),
                'title'    => 'invoice',
                'url'      => route('invoices.index')
            ]
        );
    }
}
