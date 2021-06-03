<?php

namespace Tests\Unit\Domains\Bill\Jobs;

use App\Enums\DocumentStatusEnum;
use App\Models\Document;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;
use App\Domains\Bill\Jobs\ValidateReceiableBillJob;

class ValidateReceiableBillJobTest extends TestCase
{
    public function test_validate_receiable_bill_job_invalid_document_type()
    {
        $this->expectException(ValidationException::class);
        $document = Document::factory()->INVOICE()->create([
           'status' => DocumentStatusEnum::pending()
       ]);

        $job = new ValidateReceiableBillJob($document);
        $job->handle();
    }

    public function test_validate_receiable_bill_job_invalid_document_status()
    {
        $this->expectException(ValidationException::class);
        $document = Document::factory()->BILL()->create([
            'status' => DocumentStatusEnum::received()
        ]);

        $job = new ValidateReceiableBillJob($document);
        $job->handle();
    }


    public function test_validate_receiable_bill_job()
    {
        $document = Document::factory()->BILL()->create([
            'status' => DocumentStatusEnum::pending()
        ]);

        $job = new ValidateReceiableBillJob($document);
        $this->assertTrue($job->handle());
    }
}
