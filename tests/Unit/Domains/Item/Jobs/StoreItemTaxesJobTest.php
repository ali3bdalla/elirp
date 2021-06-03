<?php

namespace Tests\Unit\Domains\Item\Jobs;

use App\Models\User;
use App\Models\Item;
use App\Models\ItemTax;
use App\Models\Tax;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Domains\Item\Jobs\StoreItemTaxesJob;

class StoreItemTaxesJobTest extends TestCase
{
    use WithFaker;

    public function test_store_item_taxes_job()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create([
            'company_id' => $user->company_id
        ]);
        $taxes = Tax::factory()->count($this->faker->numberBetween(1, 5))->create([
            'company_id' => $user->company_id
        ]);
        $data = [

        ];
        foreach ($taxes as $tax) {
            $data[] = $tax->id;
        }

        $job = new StoreItemTaxesJob($item, $data);
        $result = $job->handle();
        $this->assertIsArray($result);

        foreach ($result as $itemTax) {
            $this->assertInstanceOf(ItemTax::class, $itemTax);
        }
    }
}
