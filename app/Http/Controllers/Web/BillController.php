<?php

namespace App\Http\Controllers\Web;

use App\Enums\DocumentTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BillController extends Controller
{
    public function index()
    {
        return Inertia::render('Documents/Index', [
            'type' => DocumentTypeEnum::BILL()->value,
            'title' => 'Bill',
            'create_url' => route('bills.create'),
            'url' => route('bills.index')
        ]);
    }
    public function create()
    {
        return Inertia::render('Documents/Create', [
            'document_number' => Document::generatedNextDocumentNumber(DocumentTypeEnum::BILL()),
            'type' => DocumentTypeEnum::BILL()->label,
            'title' => 'Bill',
            'url' => route('bills.index')
        ]);
    }

    public function edit(Document $bill)
    {
        return Inertia::render('Documents/Edit', [
            'type' => $bill->type,
            'document' => $bill->load('items.item','contact','histories','transactions.account'),
            'title' => 'Bill',
            'url' => route('bills.index')
        ]);
    }
}
