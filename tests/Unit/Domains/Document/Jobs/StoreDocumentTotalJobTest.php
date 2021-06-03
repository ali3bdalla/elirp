<?php

namespace Tests\Unit\Domains\Document\Jobs;

use App\Domains\Document\Jobs\StoreDocumentItemTaxesJob;
use App\Domains\Document\Jobs\StoreDocumentTotalJob;
use App\Enums\DocumentTypeEnum;
use App\Models\User;
use App\Models\Document;
use App\Models\DocumentItem;
use App\Models\Tax;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class StoreDocumentTotalJobTest extends TestCase
{
    use WithFaker;

    public function test_store_document_total_job()
    {
        $user = User::factory()->create();

        $document = Document::factory()->invoice()->create([
            'company_id' => $user->company_id,
            'type' => $this->faker->randomElement(DocumentTypeEnum::toValues())
        ]);

        $taxes = Tax::factory()->count($this->faker->numberBetween(1, 3))->create([
            'company_id' => $user->company_id
        ]);

        $taxesIds = $taxes->pluck('id')->toArray();
        $documentItems = DocumentItem::factory()->count($this->faker->numberBetween(1, 5))->create([
            'company_id' => $user->company_id,
            'document_id' => $document->id
        ]);
        $precision = 2;
        foreach ($documentItems as $documentItem) {
            $subJob = new StoreDocumentItemTaxesJob($documentItem, $taxesIds);
            $subJob->handle();
            $documentItem->fresh()->taxes()->sum('amount');
        }

        $job = new StoreDocumentTotalJob($document);
        $result = $job->handle();

        $this->assertIsArray($result);
        $totals = collect($result);
        $this->assertEquals(round($totals->where('code', '=', 'sub_total')->sum('amount'), $precision), round($documentItems->sum('subtotal'), $precision));
        $this->assertEquals(round($totals->where('code', '=', 'item_discount')->sum('amount'), $precision), round($documentItems->sum('discount'), $precision));
        $this->assertEquals(round($totals->where('code', '=', 'tax')->sum('amount'), $precision), round($documentItems->fresh()->sum('tax'), $precision));
    }

    public function test_store_document_total_job_invalid_additional_totals()
    {
        $this->expectException(ValidationException::class);
        Event::fake();
        $user = User::factory()->create();

        
        $document = Document::factory()->invoice()->create([
            'company_id' => $user->company_id,
            'type' => $this->faker->randomElement(DocumentTypeEnum::toValues())
        ]);

        $taxes = Tax::factory()->count($this->faker->numberBetween(1, 3))->create([
            'company_id' => $user->company_id
        ]);
        
        $taxesIds = $taxes->pluck('id')->toArray();
        $documentItems = DocumentItem::factory()->count($this->faker->numberBetween(1, 5))->create([
            'company_id' => $user->company_id,
            'document_id' => $document->id
        ]);
        foreach ($documentItems as $documentItem) {
            $subJob = new StoreDocumentItemTaxesJob($documentItem, $taxesIds);
            $subJob->handle();
        }

        $job = new StoreDocumentTotalJob($document, [
            'totals' => [
                [
                    'amount' => -1
                ]
            ]
        ]);
        $result = $job->handle();
    }
}
