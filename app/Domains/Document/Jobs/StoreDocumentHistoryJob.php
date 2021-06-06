<?php

namespace App\Domains\Document\Jobs;

use App\Models\Document;
use App\Models\DocumentHistory;
use Lucid\Units\Job;

class StoreDocumentHistoryJob extends Job
{
    protected Document $document;

    protected $notify;

    protected $description;

    /**
     * Create a new job instance.
     *
     * @param  Document $document
     * @param  $notify
     * @param  $description
     */
    public function __construct(Document $document, $notify = 0, $description = null)
    {
        $this->document    = $document;
        $this->notify      = $notify;
        $this->description = $description;
    }

    /**
     * Execute the job.
     *
     * @return DocumentHistory
     */
    public function handle() : DocumentHistory
    {
        $description = $this->description ?: trans_choice('general.payments', 1);

        return  DocumentHistory::create([
            'company_id'  => $this->document->company_id,
            'type'        => $this->document->type,
            'document_id' => $this->document->id,
            'status'      => $this->document->status,
            'notify'      => $this->notify,
            'description' => $description,
        ]);
    }
}
