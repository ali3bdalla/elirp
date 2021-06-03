<?php

namespace App\Listeners\Bill;

use App\Events\Bill\BillHasBeenMarkedAsReceivedEvent;
use App\Models\Document;
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
    public function handle(BillHasBeenMarkedAsReceivedEvent $event): Document
    {
        return $this->run(StoreReceivedBillEntryOperation::class, [
            'document' => $event->document
        ]);
    }
}
