<?php

namespace Tests\Unit\Services\Document\Operations;

use App\Enums\DocumentTypeEnum;
use App\Enums\TaxTypeEnum;
use App\Models\User;
use App\Models\Item;
use App\Models\Document;
use App\Models\DocumentItem;
use App\Models\DocumentItemTax;
use App\Models\Tax;
use App\Services\Document\Operations\StoreDocumentItemOperation;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreDocumentItemOperationTest extends TestCase
{
    use WithFaker;

    public function test_store_document_item_operation()
    {
        $user = User::factory()->create();
        $document = Document::factory()->invoice()->create([
            'company_id' => $user->company_id,
            'type' => $this->faker->randomElement(DocumentTypeEnum::toValues())
        ]);

        $item = Item::factory()->create([
            'company_id' => $user->company_id
        ]);
        $taxes = Tax::factory()->count($this->faker->numberBetween(1, 3))->create([
            'company_id' => $user->company_id
        ]);
        $taxesIds = $taxes->pluck('id')->toArray();
        $data = [
            'price' => $this->faker->randomFloat(2, 10, 20),
            'quantity' => $this->faker->numberBetween(2, 3),
            'name' => $item->name,
            'discount' => $this->faker->numberBetween(1, 2),
            'tax_ids' => $taxesIds
        ];
        $job = new StoreDocumentItemOperation($document, $item, $data, 0);
        $documentItem = $job->handle();
        $precision = 2;
        $this->assertInstanceOf(DocumentItem::class, $documentItem);
        $this->assertEquals($documentItem->total, round($data['price'] * $data['quantity'], $precision));
        $this->assertEquals($documentItem->discount_rate, (double)$data['discount']);
        $this->assertEquals($documentItem->type, $document->type);
        $this->assertSame($documentItem->taxes()->count(), count($taxesIds));
    }
}
