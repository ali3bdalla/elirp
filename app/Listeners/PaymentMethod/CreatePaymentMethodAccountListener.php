<?php

namespace App\Listeners\PaymentMethod;

use App\Domains\PaymentMethod\Jobs\CreatePaymentMethodAccountJob;
use App\Events\PaymentMethod\PaymentMethodCreatedEvent;
use App\Models\Account;
use App\Models\PaymentMethod;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Lucid\Bus\UnitDispatcher;

class CreatePaymentMethodAccountListener
{
    use UnitDispatcher;
    /**
     * Handle the event.
     *
     * @param  TaxCreatedEvent $event
     * @return Account
     */
    public function handle(PaymentMethodCreatedEvent $event) : Account
    {
        if (! $event->paymentMethod->account_id) {
            return $this->run(
                CreatePaymentMethodAccountJob::class,
                [
                    'paymentMethod' => $event->paymentMethod
                ]
            );
        }

        return $event->paymentMethod->account;
    }
}
