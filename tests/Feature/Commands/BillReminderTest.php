<?php

namespace Tests\Feature\Commands;

use App\Jobs\Document\CreateDocument;
use App\Models\Document;
use App\Notifications\Purchase\Bill as BillNotification;
use App\Utilities\Date;
use Illuminate\Support\Facades\Notification as Notification;
use Tests\Feature\FeatureTestCase;

class BillReminderTest extends FeatureTestCase
{
    public $add_days;

    protected function setUp(): void
    {
        parent::setUp();

        $this->add_days = 3;
    }

    public function testBillReminderByDueDate()
    {
        Notification::fake();

        $bill = $this->dispatch(new CreateDocument($this->getRequest()));

        Date::setTestNow(Date::now()->subDays($this->add_days));

        $this->artisan('reminder:bill');

        Notification::assertSentTo(
            $this->user,
            BillNotification::class,
            function ($notification, $channels) use ($bill) {
                return $notification->bill->id === $bill->id;
            }
        );
    }

    public function getRequest()
    {
        return Document::factory()->bill()->items()->received()->raw([
            'due_at' => Date::now()->subDays($this->add_days - 1),
        ]);
    }
}
