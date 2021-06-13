<?php

namespace Tests\Unit\Services\Item\Operations;

use App\Events\Item\ItemCreatedEvent;
use App\Models\Item;
use App\Models\Tax;
use App\Models\User;
use App\Services\Item\Operations\StoreItemOperation;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class StoreItemOperationTest extends TestCase
{
    use WithFaker;

    public function test_store_item_operation()
    {
        Event::fake();
        $user  = User::factory()->create();
        $taxes = Tax::factory()->count($this->faker->numberBetween(1, 5))->create([
            'company_id' => $user->company_id
        ]);
        $taxesIds = [];
        foreach ($taxes as $tax) {
            $taxesIds[] = $tax->id;
        }
        $this->actingAs($user);
        $data = [
            'name'           => $this->faker->sentence,
            'sku'            => $this->faker->bankAccountNumber,
            'description'    => $this->faker->sentence,
            'sale_price'     => $this->faker->randomFloat(2, 10, 20),
            'purchase_price' => $this->faker->randomFloat(2, 10, 20),
            'fixed_price'    => $this->faker->boolean,
            'is_service'     => $this->faker->boolean,
            'has_detail'     => $this->faker->boolean,
            'picture'        => UploadedFile::fake()->image('avatar.png'),
            'tax_ids'        => $taxesIds
        ];

        $job  = new StoreItemOperation($data);
        $item = $job->handle();
        $this->assertInstanceOf(Item::class, $item);
        $this->assertEquals($data['name'], $item->name);
        $this->assertEquals($data['sale_price'], $item->sale_price);
        $this->assertEquals($data['sku'], $item->sku);
        $this->assertEquals($data['description'], $item->description);
        $this->assertEquals($data['purchase_price'], $item->purchase_price);
        $this->assertEquals($data['fixed_price'], $item->fixed_price);
        $this->assertEquals($data['is_service'], $item->is_service);
        $this->assertEquals($data['has_detail'], $item->has_detail);
        $this->assertEquals(count($data['tax_ids']), $item->taxes()->count());
        Event::assertDispatched(ItemCreatedEvent::class);
    }
}
