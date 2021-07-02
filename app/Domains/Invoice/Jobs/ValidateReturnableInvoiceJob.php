<?php

namespace App\Domains\Invoice\Jobs;

use App\Enums\DocumentStatusEnum;
use App\Enums\DocumentTypeEnum;
use App\Models\Document;
use Illuminate\Validation\ValidationException;
use Lucid\Units\Job;

class ValidateReturnableInvoiceJob extends Job
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
            || ! $this->document->histories()->where('status', DocumentStatusEnum::delivered())->first() || ! $this->document->type->equals(DocumentTypeEnum::INVOICE())
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
