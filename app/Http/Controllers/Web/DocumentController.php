<?php

namespace App\Http\Controllers\Web;

use App\Domains\Document\Jobs\GetDocumentPdfJob;
use App\Enums\DocumentTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\DocumentItem;
use App\Notifications\Document\DocumentDraftedNotification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Invoice;

class DocumentController extends Controller
{
    public function printDocument(Document $document)
    {
        $invoice = $this->run(GetDocumentPdfJob::class, ['document' => $document]);
     
        return $invoice->stream();
    }
}
