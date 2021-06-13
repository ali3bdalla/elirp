<?php

namespace App\Listeners\Bill;

use App\Events\Bill\BillHasBeenMarkedAsReceivedEvent;
use App\Models\Entry;
use App\Services\Accounting\Operations\StoreReceivedBillEntryOperation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Lucid\Bus\UnitDispatcher;

class RegisterReceivedBillAccountingEntryListener implements ShouldQueue
{
    use UnitDispatcher;

    /**
     * Handle the event.
     *
     * @param BillHasBeenMarkedAsReceivedEvent $event
     * @return void
     */
    public function handle(BillHasBeenMarkedAsReceivedEvent $event) : Entry
    {
        return $this->run(StoreReceivedBillEntryOperation::class, [
            'document' => $event->document
        ]);
    }
}
