<?php

namespace App\Domains\Bill\Jobs;

use App\Enums\DocumentStatusEnum;
use App\Enums\DocumentTypeEnum;
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
//        if ($this->document->status != DocumentStatusEnum::partial()) {
//            $this->document->status = 'received';
//            $this->document->save();
//        }
        if (($this->document->status != DocumentStatusEnum::draft() && $this->document->status != DocumentStatusEnum::pending()) || $this->document->type != DocumentTypeEnum::bill()) {
            throw ValidationException::withMessages([
               'status' => 'invalid document status'
            ]);
        }

        return true;
    }
}
