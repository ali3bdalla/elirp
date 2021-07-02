<?php

namespace App\Domains\Bill\Jobs;

use App\Enums\DocumentStatusEnum;
use App\Enums\DocumentTypeEnum;
use App\Models\Document;
use Illuminate\Validation\ValidationException;
use Lucid\Units\Job;

class ValidateReturnableBillJob extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private Document $document)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->document->histories()->where('status', DocumentStatusEnum::returned())->first()
            || ! $this->document->histories()->where('status', DocumentStatusEnum::received())->first() || ! $this->document->type->equals(DocumentTypeEnum::BILL())
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
