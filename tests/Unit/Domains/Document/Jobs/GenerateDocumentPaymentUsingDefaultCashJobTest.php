<?php

namespace Tests\Unit\Domains\Document\Jobs;

use Tests\TestCase;
use App\Domains\Document\Jobs\GenerateDocumentPaymentUsingDefaultCashJob;
use App\Enums\DocumentStatusEnum;
use App\Models\Document;
use App\Models\DocumentItem;
use Illuminate\Foundation\Testing\WithFaker;

class GenerateDocumentPaymentUsingDefaultCashJobTest extends TestCase
{
    use WithFaker;
    public function test_generate_document_payment_using_default_cash_job()
    {
        $document = Document::factory()->bill()->create([
            'status' => DocumentStatusEnum::received()
        ]);
        $documentItems = DocumentItem::factory()->count($this->faker->numberBetween(1, 5))->create([
            'document_id' => $document->id,
            'type' => $document->type
        ]);
        $job = new GenerateDocumentPaymentUsingDefaultCashJob($document);
        $result = $job->handle();
        $this->assertIsArray($result);
        $this->assertSame($document->amount,$result['amount']);
    }
}
