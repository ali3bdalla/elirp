<?php

namespace Tests\Feature\Services\Bill;

use App\Enums\DocumentStatusEnum;
use App\Events\Bill\BillHasBeenMarkedAsReceivedEvent;
use App\Listeners\Bill\RegisterReceivedBillAccountingEntryListener;
use App\Models\Document;
use App\Models\DocumentItem;
use App\Services\Bill\Features\MarkBillAsReceivedFeature;
use Illuminate\Events\CallQueuedListener;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class MarkBillAsReceivedFeatureTest extends TestCase
{
    use WithFaker;

    public function test_mark_bill_as_received_feature()
    {
        Event::fake();
        Queue::fake();
        $document = Document::factory()->BILL()->create([
            'status' => DocumentStatusEnum::pending()
        ]);

        $documentItems = DocumentItem::factory()->count($this->faker->numberBetween(1, 5))->create([
            'document_id' => $document->id,
            'type'        => $document->type
        ]);

        $job = new MarkBillAsReceivedFeature($document);
        $job->handle(new Request());

        $this->assertEquals($document->fresh()->status, DocumentStatusEnum::received());
        Event::assertDispatched(BillHasBeenMarkedAsReceivedEvent::class);
    }

    public function test_mark_bill_as_received_feature_should_queue_listeners()
    {
        Queue::fake();
        $document = Document::factory()->BILL()->create([
            'status' => DocumentStatusEnum::pending()
        ]);

        $documentItems = DocumentItem::factory()->count($this->faker->numberBetween(1, 5))->create([
            'document_id' => $document->id,
            'type'        => $document->type
        ]);

        $job = new MarkBillAsReceivedFeature($document);
        $job->handle(new  Request());
        $this->assertEquals($document->fresh()->status, DocumentStatusEnum::received());
        Queue::assertPushed(CallQueuedListener::class, function ($job) {
            return $job->class == RegisterReceivedBillAccountingEntryListener::class;
        });
    }

    public function test_bill_has_been_marked_as_received_has_expected_listener()
    {
        Event::fake();
        Event::assertListening(BillHasBeenMarkedAsReceivedEvent::class, RegisterReceivedBillAccountingEntryListener::class);
    }

    public function test_mark_bill_as_received_feature_should_queue_register_accounting_class()
    {
        Queue::fake();
        $document = Document::factory()->BILL()->create([
            'status' => DocumentStatusEnum::pending()
        ]);

        $documentItems = DocumentItem::factory()->count($this->faker->numberBetween(1, 5))->create([
            'document_id' => $document->id,
            'type'        => $document->type
        ]);

        $job = new MarkBillAsReceivedFeature($document);
        $job->handle(new Request());

        $this->assertEquals($document->fresh()->status, DocumentStatusEnum::received());
        Queue::assertPushed(function (CallQueuedListener $callQueuedListener) {
            return $callQueuedListener->class === RegisterReceivedBillAccountingEntryListener::class;
        });
    }
}
