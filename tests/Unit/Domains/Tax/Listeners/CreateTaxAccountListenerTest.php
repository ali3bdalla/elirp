<?php

namespace Tests\Unit\Domains\Tax\Listeners;

use App\Enums\AccountGroupEnum;
use App\Enums\AccountSlugsEnum;
use App\Events\Tax\TaxCreatedEvent;
use App\Listeners\Tax\CreateTaxAccountListener;
use App\Models\Account;
use App\Models\User;
use App\Models\Tax;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class CreateTaxAccountListenerTest extends TestCase
{
    public function test_create_tax_accout_listener()
    {
        Event::fake();
        $user = User::factory()->create();
        Account::factory()->create([
            'slug' => AccountSlugsEnum::DEFAULT_TAX_ACCOUNT(),
            'group' => AccountGroupEnum::TAX(),
            'company_id' => $user->company_id
        ]);
        $tax = Tax::factory()->create([
            'company_id' => $user->company_id,
        ]);
        $event = new TaxCreatedEvent($tax);
        $job = new CreateTaxAccountListener();
        $taxAccount = $job->handle($event);
        $this->assertInstanceOf(Account::class, $taxAccount);
        $this->assertSame($taxAccount->fresh()->toArray(), $tax->account->toArray());
    }
}
