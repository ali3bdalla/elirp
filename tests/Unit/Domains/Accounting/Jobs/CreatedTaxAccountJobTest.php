<?php

namespace Tests\Unit\Domains\Accounting\Jobs;

use App\Events\Tax\TaxCreatedEvent;
use App\Listeners\Tax\CreateTaxAccountListener;
use App\Models\Account;
use App\Models\User;
use App\Models\Tax;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use App\Domains\Accounting\Jobs\CreatedTaxAccountJob;

class CreatedTaxAccountJobTest extends TestCase
{
    public function test_created_tax_account_job()
    {
        Event::fake();
        $user = User::factory()->create();
        $tax = Tax::factory()->create([
            'company_id' => $user->company_id,
        ]);
        $job = new CreatedTaxAccountJob($tax);
        $taxAccount = $job->handle();
        $this->assertInstanceOf(Account::class, $taxAccount);
        $this->assertSame($taxAccount->fresh()->toArray(), $tax->account->toArray());
    }
}
