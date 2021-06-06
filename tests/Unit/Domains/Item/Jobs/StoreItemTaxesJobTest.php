<?php

namespace Tests\Unit\Domains\Item\Jobs;

use App\Domains\Item\Jobs\StoreItemTaxesJob;
use App\Enums\AccountGroupEnum;
use App\Enums\AccountSlugsEnum;
use App\Models\Account;
use App\Models\Item;
use App\Models\ItemTax;
use App\Models\Tax;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreItemTaxesJobTest extends TestCase
{
    use WithFaker;

    public function test_store_item_taxes_job()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create([
            'company_id' => $user->company_id
        ]);
        Account::factory()->create([
            'slug'       => AccountSlugsEnum::DEFAULT_TAX_ACCOUNT(),
            'group'      => AccountGroupEnum::TAX(),
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

        $job    = new StoreItemTaxesJob($item, $data);
        $result = $job->handle();
        $this->assertIsArray($result);

        foreach ($result as $itemTax) {
            $this->assertInstanceOf(ItemTax::class, $itemTax);
        }
    }
}
