<?php

namespace App\Http\Controllers\Web;

use App\Domains\Document\Jobs\GetDocumentPdfJob;
use App\Http\Controllers\Controller;
use App\Models\Document;
use Lucid\Bus\UnitDispatcher;

class DocumentController extends Controller
{
    use UnitDispatcher;

    public function printDocument(Document $document)
    {
        $invoice = $this->run(GetDocumentPdfJob::class, ['document' => $document]);

        return $invoice->stream();
    }
}
