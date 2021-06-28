<?php

namespace App\Listeners\Bill;

use App\Events\Bill\BillHasBeenMarkedAsReceivedEvent;
use App\Services\Inventory\Features\StoreReceviedBillInventoryTransactionsFeature;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Lucid\Bus\UnitDispatcher;

class RegisterReceivedBillInventoryTransactionsListener
{
      use UnitDispatcher;

    /**
     * Handle the event.
     *
     * @param BillHasBeenMarkedAsReceivedEvent $event
     * @return void
     */
    public function handle(BillHasBeenMarkedAsReceivedEvent $event) : array
    {
        return $this->run(StoreReceviedBillInventoryTransactionsFeature::class, [
            'document' => $event->document
        ]);
    }
}
