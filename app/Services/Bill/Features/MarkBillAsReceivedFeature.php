<?php

namespace App\Services\Bill\Features;

use App\Domains\Bill\Jobs\ValidateReceiableBillJob;
use App\Domains\Document\Jobs\ChangeDocumentStatusJob;
use App\Domains\Document\Jobs\StoreDocumentHistoryJob;
use App\Enums\DocumentStatusEnum;
use App\Events\Bill\BillHasBeenMarkedAsReceivedEvent;
use App\Models\Document;
use Illuminate\Http\Request;
use Lucid\Units\Feature;

class MarkBillAsReceivedFeature extends Feature
{
    private Document $document;

    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    public function handle(Request $request) : Document
    {
        $this->run(ValidateReceiableBillJob::class, [
            'document' => $this->document
        ]);
        $this->run(ChangeDocumentStatusJob::class, [
            'document'           => $this->document,
            'documentStatusEnum' => DocumentStatusEnum::received()
        ]);

        $this->run(StoreDocumentHistoryJob::class, [
            'document'    => $this->document->fresh(),
            'notify'      => 0,
            'description' => 'Mark As Billed'
        ]);

        event(new BillHasBeenMarkedAsReceivedEvent($this->document));

        return $this->document;
    }
}
