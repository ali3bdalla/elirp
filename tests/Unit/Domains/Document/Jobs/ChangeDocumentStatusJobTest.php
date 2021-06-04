<?php

namespace Tests\Unit\Domains\Document\Jobs;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Domains\Document\Jobs\ChangeDocumentStatusJob;
use App\Enums\DocumentStatusEnum;
use App\Models\Document;
use App\Models\DocumentItem;

class ChangeDocumentStatusJobTest extends TestCase
{
    use WithFaker;
    public function test_mark_document_as_paid_job()
    {
       $document = Document::factory()->BILL()->create([
            'status' => DocumentStatusEnum::pending()
        ]);

        $documentItems = DocumentItem::factory()->count($this->faker->numberBetween(1, 5))->create([
            'document_id' => $document->id,
            'type' => $document->type
        ]);
        $job = new ChangeDocumentStatusJob($document,DocumentStatusEnum::paid());
        $document = $job->handle();
        $this->assertInstanceOf(Document::class, $document);
        $this->assertEquals($document->status, DocumentStatusEnum::paid());
    }
    public function test_mark_document_as_received_job()
    {
       $document = Document::factory()->BILL()->create([
            'status' => DocumentStatusEnum::pending()
        ]);

        $documentItems = DocumentItem::factory()->count($this->faker->numberBetween(1, 5))->create([
            'document_id' => $document->id,
            'type' => $document->type
        ]);
        $job = new ChangeDocumentStatusJob($document,DocumentStatusEnum::received());
        $document = $job->handle();
        $this->assertInstanceOf(Document::class, $document);
        $this->assertEquals($document->status, DocumentStatusEnum::received());
    }
}
