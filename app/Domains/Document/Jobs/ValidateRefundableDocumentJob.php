<?php

namespace App\Domains\Document\Jobs;

use App\Enums\DocumentStatusEnum;
use App\Models\Document;
use Illuminate\Validation\ValidationException;
use Lucid\Units\Job;

class ValidateRefundableDocumentJob extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public Document $document)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return boolean
     */
    public function handle()
    {
        if (! $this->document->histories()->where('status', DocumentStatusEnum::paid())->first() && $this->document->histories()->where('status', DocumentStatusEnum::refunded())->first()) {
            throw ValidationException::withMessages(
                [
                    'status' => 'invalid document status'
                ]
            );
        }
        return true;
    }
}
