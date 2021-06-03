<?php

namespace Tests\Unit\Domains\Item\Jobs;

use App\Models\User;
use App\Models\Item;
use App\Services\Item\Operations\StoreItemOperation;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use App\Domains\Item\Jobs\StoreItemJob;

class StoreItemJobTest extends TestCase
{
    use WithFaker;

    public function test_store_item_job()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $data = [
            "name" => $this->faker->sentence,
            'sku' => $this->faker->bankAccountNumber,
            'description' => $this->faker->sentence,
            'sale_price' => $this->faker->randomFloat(2, 10, 20),
            'purchase_price' => $this->faker->randomFloat(2, 10, 20),
            'fixed_price' => $this->faker->boolean,
            'is_service' => $this->faker->boolean,
            'has_detail' => $this->faker->boolean,
            'picture' => UploadedFile::fake()->image('avatar.png')
        ];

        $job = new StoreItemJob($data);
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
    }
}
