<?php


namespace Tests\Unit\Domains\Tax\Events;

use App\Events\Tax\TaxCreatedEvent;
use App\Listeners\Tax\CreateTaxAccountListener;
use App\Models\User;
use App\Models\Tax;
use Illuminate\Events\CallQueuedListener;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class TaxCreatedEventTest extends TestCase
{
    use WithFaker;

    public function test_tax_created_event()
    {
        Event::fake();
        $user = User::factory()->create();
        Tax::factory()->create([
            'company_id' => $user->company_id
        ]);

        Event::assertDispatched(TaxCreatedEvent::class);
    }

    use WithFaker;

    public function test_tax_created_has_create_tax_account_listener()
    {
        Event::fake();
        Event::assertListening(TaxCreatedEvent::class, CreateTaxAccountListener::class);
    }


//    public function test_tax_created_event_should_queue_create_tax_account_listener()
//    {
//        $user = User::factory()->create();
//        Queue::fake();
//        Tax::factory()->create([
//            'company_id' => $user->company_id
//        ]);
//        Queue::assertPushed(CallQueuedListener::class, function ($job) {
//            return $job->class == CreateTaxAccountListener::class;
//        });
//    }
}
