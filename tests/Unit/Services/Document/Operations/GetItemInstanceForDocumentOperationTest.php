<?php

namespace Tests\Unit\Services\Document\Operations;

use App\Enums\DocumentTypeEnum;
use App\Events\Item\ItemCreatedEvent;
use App\Models\Item;
use App\Models\User;
use App\Services\Document\Operations\GetItemInstanceForDocumentOperation;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class GetItemInstanceForDocumentOperationTest extends TestCase
{
    use WithFaker;

    public function test_get_item_instance_for_document_operation_after_creating_in_invoice()
    {
        Event::fake();
        $user = User::factory()->create();
        $this->actingAs($user);
        $request = [
            'name'  => $this->faker->sentence,
            'price' => $this->faker->randomFloat(2, 10, 20),
        ];

        $job  = new GetItemInstanceForDocumentOperation(DocumentTypeEnum::INVOICE(), $request);
        $item = $job->handle();
        $this->assertInstanceOf(Item::class, $item);
        $this->assertEquals($request['name'], $item->name);
        $this->assertEquals($request['price'], $item->sale_price);
        Event::assertDispatched(ItemCreatedEvent::class);
    }

    public function test_get_item_instance_for_document_operation_after_creating_in_bill()
    {
        Event::fake();
        $user = User::factory()->create();
        $this->actingAs($user);
        $request = [
            'name'  => $this->faker->sentence,
            'price' => $this->faker->randomFloat(2, 10, 20),
        ];

        $job  = new GetItemInstanceForDocumentOperation(DocumentTypeEnum::BILL(), $request);
        $item = $job->handle();
        $this->assertInstanceOf(Item::class, $item);
        $this->assertEquals($request['name'], $item->name);
        $this->assertEquals($request['price'], $item->purchase_price);
        Event::assertDispatched(ItemCreatedEvent::class);
    }

    public function test_get_item_instance_for_document_operation_from_existing_item_in_invoice()
    {
        Event::fake();
        $user = User::factory()->create();
        $this->actingAs($user);
        $existItem = Item::factory()->create([
            'company_id' => $user->company_id
        ]);
        $request = [
            'item_id' => $existItem->id,
            'name'    => $this->faker->sentence,
            'price'   => $this->faker->randomFloat(2, 10, 20),
        ];

        $job  = new GetItemInstanceForDocumentOperation(DocumentTypeEnum::INVOICE(), $request);
        $item = $job->handle();
        $this->assertInstanceOf(Item::class, $item);
        $this->assertTrue($existItem->is($item));
        $this->assertEquals($existItem->id, $item->id);
        $this->assertEquals($existItem->name, $item->name);
        $this->assertEquals($existItem->sale_price, $item->sale_price);
        $this->assertEquals($existItem->purchase_price, $item->purchase_price);
        Event::assertNotDispatched(ItemCreatedEvent::class);
    }

    public function test_get_item_instance_for_document_operation_from_existing_item_in_bill()
    {
        Event::fake();
        $user = User::factory()->create();
        $this->actingAs($user);
        $existItem = Item::factory()->create([
            'company_id' => $user->company_id
        ]);
        $request = [
            'item_id' => $existItem->id,
            'name'    => $this->faker->sentence,
            'price'   => $this->faker->randomFloat(2, 10, 20),
        ];

        $job  = new GetItemInstanceForDocumentOperation(DocumentTypeEnum::BILL(), $request);
        $item = $job->handle();
        $this->assertInstanceOf(Item::class, $item);
        $this->assertTrue($existItem->is($item));
        $this->assertEquals($existItem->id, $item->id);
        $this->assertEquals($existItem->name, $item->name);
        $this->assertEquals($existItem->sale_price, $item->sale_price);
        $this->assertEquals($existItem->purchase_price, $item->purchase_price);
        Event::assertNotDispatched(ItemCreatedEvent::class);
    }
}
