<?php

namespace App\Http\Controllers\Web;

use App\Enums\DocumentTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\Document;
use Inertia\Inertia;

class BillController extends Controller
{
    public function index()
    {
        return Inertia::render(
            'Documents/Index',
            [
                'type'       => DocumentTypeEnum::BILL()->value,
                'title'      => 'bill',
                'create_url' => route('bills.create'),
                'url'        => route('bills.index')
            ]
        );
    }

    public function create()
    {
        return Inertia::render(
            'Documents/Create',
            [
                'document_number' => Document::generatedNextDocumentNumber(DocumentTypeEnum::BILL()),
                'type'            => DocumentTypeEnum::BILL()->label,
                'title'           => 'bill',
                'url'             => route('bills.index')
            ]
        );
    }

    public function edit(Document $bill)
    {
        return Inertia::render(
            'Documents/Edit',
            [
                'type'     => $bill->type,
                'document' => $bill->load('items.item', 'contact', 'histories.createdBy', 'transactions.account', 'inventoryTransactions.item'),
                'title'    => 'bill',
                'url'      => route('bills.index')
            ]
        );
    }
}
