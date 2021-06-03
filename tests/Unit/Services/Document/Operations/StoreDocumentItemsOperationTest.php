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
use App\Services\Document\Operations\StoreDocumentItemsOperation;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreDocumentItemsOperationTest extends TestCase
{
    use WithFaker;
    
    public function test_store_document_items_operation()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $document = Document::factory()->INVOICE()->create([
            'company_id' => $user->company_id,
            'type' => $this->faker->randomElement(DocumentTypeEnum::toValues())
        ]);
        
        $items = Item::factory()->count($this->faker->numberBetween(1, 10))->create([
            'company_id' => $user->company_id
        ]);
        
        $taxes = Tax::factory()->fixed()->count($this->faker->numberBetween(1, 3))->create([
            'company_id' => $user->company_id
        ]);
        $taxesIds = $taxes->pluck('id')->toArray();
        $request = [];
        foreach ($items as $item) {
            $request['items'][] = [
                'item_id' => $item->id,
                'price' => $this->faker->randomFloat(2, 10, 20),
                'quantity' => $this->faker->numberBetween(2, 3),
                'name' => $item->name,
                'discount' => $this->faker->numberBetween(1, 2),
                'tax_ids' => $taxesIds
            ];
        }
        
        
        $job = new StoreDocumentItemsOperation($document, $request, 0);
        $documentItems = $job->handle();
        $this->assertIsArray($documentItems);
        $this->assertSame(count($documentItems), count($request['items']));
        foreach ($documentItems as $documentItem) {
            $data = collect($request['items'])->where('item_id', $documentItem->item_id)->first();
            $precision = 2;
            $this->assertInstanceOf(DocumentItem::class, $documentItem);
            $this->assertEquals($documentItem->total, round($data['price'] * $data['quantity'], $precision));
            $this->assertEquals($documentItem->discount_rate, (double)$data['discount']);
            $this->assertEquals($documentItem->type, $document->type);
            $totalInclusiveRate = Tax::whereIn('id', $taxesIds)->where('type', TaxTypeEnum::inclusive())->sum('rate');
            $baseRate = $documentItem->total / (1 + $totalInclusiveRate / 100);
            $taxTotal = 0;
            foreach ($documentItem->taxes()->get() as $documentItemTax) {
                $this->assertInstanceOf(DocumentItemTax::class, $documentItemTax);
                $this->assertTrue(in_array($documentItemTax->tax_id, $taxesIds));
                $tax = $documentItemTax->tax;
                $this->assertInstanceOf(Tax::class, $tax);
                if ($tax->type == TaxTypeEnum::inclusive()) {
                    $taxAmount = $baseRate * ($tax->rate / 100);
                } elseif ($tax->type == TaxTypeEnum::compound()) {
                    $taxAmount = (($documentItem->subtotal + $taxTotal) / 100) * $tax->rate;
                } elseif ($tax->type == TaxTypeEnum::fixed()) {
                    $taxAmount = $tax->rate * (double)$documentItem->quantity;
                } elseif ($tax->type == TaxTypeEnum::withholding()) {
                    $taxAmount = 0 - $documentItem->subtotal * ($tax->rate / 100);
                } else {
                    $taxAmount = $documentItem->subtotal * ($tax->rate / 100);
                }
                
                $this->assertEquals(round($taxAmount, $precision), $documentItemTax->amount);
                $taxTotal += round($taxAmount, $precision);
            }
            $this->assertEquals(round($documentItem->tax, $precision), $taxTotal);
        }
    }
}
