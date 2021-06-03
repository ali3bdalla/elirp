<?php

namespace Tests\Unit\Domains\Document\Jobs;

use App\Domains\Document\Jobs\StoreDocumentItemTaxesJob;
use App\Enums\DocumentTypeEnum;
use App\Enums\TaxTypeEnum;
use App\Models\User;
use App\Models\Document;
use App\Models\DocumentItem;
use App\Models\DocumentItemTax;
use App\Models\Tax;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreDocumentItemTaxesJobTest extends TestCase
{
    use WithFaker;

    public function test_store_document_item_taxes_job()
    {
        $user = User::factory()->create();

        $document = Document::factory()->invoice()->create([
            'company_id' => $user->company_id,
            'type' => $this->faker->randomElement(DocumentTypeEnum::toValues())
        ]);

        $taxes = Tax::factory()->fixed()->count($this->faker->numberBetween(1, 3))->create([
            'company_id' => $user->company_id
        ]);

        $taxesIds = $taxes->pluck('id')->toArray();
        $documentItems = DocumentItem::factory()->count($this->faker->numberBetween(1, 5))->create([
            'company_id' => $user->company_id,
            'document_id' => $document->id
        ]);
        $precision = 2;
        $totalInclusiveRate = Tax::whereIn('id', $taxesIds)->where('type', TaxTypeEnum::inclusive())->sum('rate');
        foreach ($documentItems as $documentItem) {
            $baseRate = $documentItem->total / (1 + $totalInclusiveRate / 100);

            $job = new StoreDocumentItemTaxesJob($documentItem, $taxesIds);
            $result = $job->handle();
            $this->assertIsArray($result);
            $taxTotal = 0;
            foreach ($result as $documentItemTax) {
                $this->assertInstanceOf(DocumentItemTax::class, $documentItemTax);
                $this->assertTrue(in_array($documentItemTax->tax_id, $taxesIds));
                $tax = $documentItemTax->tax;
                $this->assertInstanceOf(Tax::class, $tax);
                $taxAmount = $tax->rate * (double)$documentItem->quantity;
                $this->assertEquals(round(abs($taxAmount), $precision), $documentItemTax->amount);
                $taxTotal += round(abs($taxAmount), $precision);
            }

            $this->assertEquals(round($documentItem->tax,$precision), round($taxTotal, $precision));
        }
    }
}
