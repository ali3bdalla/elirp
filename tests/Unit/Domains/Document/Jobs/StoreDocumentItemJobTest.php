<?php

namespace Tests\Unit\Domains\Document\Jobs;

use App\Domains\Document\Jobs\StoreDocumentItemJob;
use App\Enums\DocumentTypeEnum;
use App\Models\User;
use App\Models\Item;
use App\Models\Document;
use App\Models\DocumentItem;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreDocumentItemJobTest extends TestCase
{
    use WithFaker;

    public function test_store_document_item_job()
    {
        $user = User::factory()->create();

        $document = Document::factory()->INVOICE()->create([
            'company_id' => $user->company_id,
            'type' => $this->faker->randomElement(DocumentTypeEnum::toValues())
        ]);

        $item = Item::factory()->create([
            'company_id' => $user->company_id
        ]);

        $data = [
            'price' => $this->faker->randomFloat(2, 10, 20),
            'quantity' => $this->faker->numberBetween(2, 3),
            'name' => $item->name,
            'discount' => $this->faker->numberBetween(1, 2),
        ];
        $job = new StoreDocumentItemJob($document, $item, $data, 0);
        $result = $job->handle();
        $precision = 2;

        $this->assertInstanceOf(DocumentItem::class, $result);
        $this->assertEquals($result->total, round($data['price'] * $data['quantity'], $precision));
        $this->assertEquals($result->discount_rate, (double)$data['discount']);
        $this->assertEquals($result->type, $document->type);
    }
}
