<?php

namespace Tests\Unit\Domains\Document\Jobs;

use App\Domains\Document\Jobs\UploadDocumentAttachmentJob;
use App\Models\Document;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class UploadDocumentAttachmentJobTest extends TestCase
{
    public function test_upload_document_attachment_job()
    {
        $user     = User::factory()->create();
        $document = Document::factory()->INVOICE()->create([
            'company_id' => $user->company_id
        ]);

        $job = new UploadDocumentAttachmentJob($document, [
            'attachment' => [UploadedFile::fake()->image('fake.png')]
        ]);
        $job->handle();
        $this->assertTrue(true);
    }

    public function test_upload_document_attachment_job_invalid_document()
    {
        $this->expectException(ValidationException::class);
        $user     = User::factory()->create();
        $document = Document::factory()->INVOICE()->create([
            'company_id' => $user->company_id
        ]);

        $job = new UploadDocumentAttachmentJob($document, [
            'attachment' => ['']
        ]);
        $job->handle();
    }

    public function test_upload_document_attachment_job_invalid_document_attachment_not_array()
    {
        $this->expectException(ValidationException::class);
        $user     = User::factory()->create();
        $document = Document::factory()->INVOICE()->create([
            'company_id' => $user->company_id
        ]);

        $job = new UploadDocumentAttachmentJob($document, [
            'attachment' => UploadedFile::fake()->image('fake.png')
        ]);
        $job->handle();
    }
}
