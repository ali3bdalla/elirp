<?php

namespace App\Listeners\Inventory;

use App\Domains\Accounting\Jobs\CreateInventoryAccountJob;
use App\Events\Inventory\InventoryCreatedEvent;
use App\Models\Account;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Lucid\Bus\UnitDispatcher;

class CreateInventoryAccountListener
{
    use UnitDispatcher;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TaxCreatedEvent $event
     * @return Account
     */
    public function handle(InventoryCreatedEvent $event) : Account
    {
        if (! $event->inventory->account_id) {
            return $this->run(
                CreateInventoryAccountJob::class,
                [
                'inventory' => $event->inventory
                ]
            );
        }

        return $event->tax->account;
    }
}
