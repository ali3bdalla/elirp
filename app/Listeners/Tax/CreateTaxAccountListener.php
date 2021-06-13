<?php

namespace App\Listeners\Tax;

use App\Domains\Accounting\Jobs\CreatedTaxAccountJob;
use App\Events\Tax\TaxCreatedEvent;
use App\Models\Account;
use Lucid\Bus\UnitDispatcher;

class CreateTaxAccountListener
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
     * @param TaxCreatedEvent $event
     * @return Account
     */
    public function handle(TaxCreatedEvent $event) : Account
    {
        if (! $event->tax->account_id) {
            return $this->run(CreatedTaxAccountJob::class, [
                'tax' => $event->tax
            ]);
        }

        return $event->tax->account;
    }
}
