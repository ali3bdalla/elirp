<?php

namespace Tests\Unit\Domains\Document\Jobs;

use App\Models\Document;
use App\Models\DocumentHistory;
use Tests\TestCase;
use App\Domains\Document\Jobs\StoreDocumentHistoryJob;

class StoreDocumentHistoryJobTest extends TestCase
{
    public function test_store_document_history_job()
    {
        $document = Document::factory()->BILL()->create();
        $job = new StoreDocumentHistoryJob($document, 0, trans('messages.success.added', ['type' => $document->document_number]));
        $result = $job->handle();

        $this->assertInstanceOf(DocumentHistory::class, $result);
        $this->assertEquals($result->description, trans('messages.success.added', ['type' => $document->document_number]));
        $this->assertEquals($result->status, $document->status);
    }
}
