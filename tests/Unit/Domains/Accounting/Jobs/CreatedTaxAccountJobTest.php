<?php

namespace Tests\Unit\Domains\Accounting\Jobs;

use App\Domains\Accounting\Jobs\CreatedTaxAccountJob;
use App\Enums\AccountGroupEnum;
use App\Enums\AccountSlugsEnum;
use App\Models\Account;
use App\Models\Tax;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class CreatedTaxAccountJobTest extends TestCase
{
    public function test_created_tax_account_job()
    {
        Event::fake();
        $user = User::factory()->create();
        $tax  = Tax::factory()->create([
            'company_id' => $user->company_id
        ]);
        Account::factory()->create([
            'company_id' => $user->company_id,
            'slug'       => AccountSlugsEnum::DEFAULT_TAX_ACCOUNT(),
            'type'       => AccountGroupEnum::TAX(),
        ]);
        $job        = new CreatedTaxAccountJob($tax);
        $taxAccount = $job->handle();
        $this->assertInstanceOf(Account::class, $taxAccount);
        $this->assertSame($taxAccount->fresh()->toArray(), $tax->account->toArray());
    }
}
