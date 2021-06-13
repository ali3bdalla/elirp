<?php

namespace Tests\Unit\Domains\Document\Jobs;

use App\Domains\Document\Jobs\GenerateDocumentPaymentUsingDefaultCashJob;
use App\Enums\AccountGroupEnum;
use App\Enums\AccountSlugsEnum;
use App\Enums\DocumentStatusEnum;
use App\Models\Account;
use App\Models\Document;
use App\Models\DocumentItem;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GenerateDocumentPaymentUsingDefaultCashJobTest extends TestCase
{
    use WithFaker;

    public function test_generate_document_payment_using_default_cash_job()
    {
        $document = Document::factory()->BILL()->create([
            'status' => DocumentStatusEnum::received()
        ]);
        Account::factory()->create([
            'slug'       => AccountSlugsEnum::DEFAULT_BANK_ACCOUNT(),
            'group'      => AccountGroupEnum::BANK(),
            'company_id' => $document->company_id
        ]);
        $documentItems = DocumentItem::factory()->count($this->faker->numberBetween(1, 5))->create([
            'document_id' => $document->id,
            'type'        => $document->type
        ]);
        $job    = new GenerateDocumentPaymentUsingDefaultCashJob($document);
        $result = $job->handle();
        $this->assertIsArray($result);
        $this->assertSame($document->amount, $result['amount']);
    }
}
