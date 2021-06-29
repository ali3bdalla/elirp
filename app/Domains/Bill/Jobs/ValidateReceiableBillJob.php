<?php

namespace App\Domains\Bill\Jobs;

use App\Enums\DocumentStatusEnum;
use App\Enums\DocumentTypeEnum;
use App\GraphQL\Queries\DocumentStatuses;
use App\Models\Document;
use Illuminate\Validation\ValidationException;
use Lucid\Units\Job;

class ValidateReceiableBillJob extends Job
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
        $this->document = $document;
    }

    /**
     * Execute the job.
     *
     * @return boolean
     */
    public function handle()
    {
        if ($this->document->histories()->where('status', DocumentStatusEnum::refunded())->first()
            || $this->document->histories()->where('status', DocumentStatusEnum::received())->first() || !$this->document->type->equals(DocumentTypeEnum::BILL())
        ) {
            throw ValidationException::withMessages(
                [
                'status' => 'invalid document status'
                ]
            );
        }
        return true;
    }
}
