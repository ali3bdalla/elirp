<?php

namespace App\Providers;

use App\Events\Bill\BillHasBeenMarkedAsReceivedEvent;
use App\Events\Document\BillDocumentCreatedEvent;
use App\Events\Document\InvoiceDocumentCreatedEvent;
use App\Events\Inventory\InventoryCreatedEvent;
use App\Events\PaymentMethod\PaymentMethodCreatedEvent;
use App\Events\Tax\TaxCreatedEvent;
use App\Listeners\Bill\RegisterReceivedBillAccountingEntryListener;
use App\Listeners\Bill\RegisterReceivedBillInventoryTransactionsListener;
use App\Listeners\Inventory\CreateInventoryAccountListener;
use App\Listeners\PaymentMethod\CreatePaymentMethodAccountListener;
use App\Listeners\Tax\CreateTaxAccountListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        InvoiceDocumentCreatedEvent::class => [
        ],
        BillDocumentCreatedEvent::class => [
        ],
        BillHasBeenMarkedAsReceivedEvent::class => [
            // RegisterReceivedBillInventoryTransactionsListener::class,
            // RegisterReceivedBillAccountingEntryListener::class,
        ],
        TaxCreatedEvent::class => [
            CreateTaxAccountListener::class
        ],
        InventoryCreatedEvent::class => [
            CreateInventoryAccountListener::class
        ],
        PaymentMethodCreatedEvent::class => [
            CreatePaymentMethodAccountListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
