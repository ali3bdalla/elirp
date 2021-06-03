<?php

namespace App\Domains\Document\Jobs;

use App\Enums\DocumentStatusEnum;
use App\Models\Document;
use Lucid\Units\Job;

class ChangeDocumentStatusJob extends Job
{
    private Document $document;
    private DocumentStatusEnum $status;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Document $document,DocumentStatusEnum $documentStatusEnum)
    {
        //
        $this->status = $documentStatusEnum;
        $this->document = $document;
    }

    /**
     * Execute the job.
     *
     * @return Document
     */
    public function handle(): Document
    {
        $this->document->update([
            'status' => $this->status
        ]);

        return $this->document->fresh();
    }
}
