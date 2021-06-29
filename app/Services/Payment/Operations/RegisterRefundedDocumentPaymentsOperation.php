<?php

namespace App\Services\Payment\Operations;

use App\Domains\Accounting\Jobs\CreatePaymentAccountingTransactionJob;
use App\Domains\Payment\Jobs\CreatePaymentJob;
use App\Domains\PaymentMethod\Jobs\GetCurrentPaymentMethodJob;
use App\Enums\DocumentTypeEnum;
use App\Enums\PaymentTypeEnum;
use App\Models\Document;
use App\Models\Entry;
use Lucid\Units\Operation;

class RegisterRefundedDocumentPaymentsOperation extends Operation
{
    /**
     * Create a new operation instance.
     *
     * @return void
     */
    public function __construct(public Document $document, public Entry $entry)
    {
        //
    }
    /**
     * Execute the operation.
     *
     * @return void
     */
    public function handle()
    {
        $paymentMethod = $this->run(GetCurrentPaymentMethodJob::class);
        $parameters = [
            'amount' => $this->document->amount,
            'document_id' => $this->document->id,
            'payment_method_id' => $paymentMethod->id,
            'contact_id' => $this->document->contact_id,
            'type' =>
            $this->document->type->equals(DocumentTypeEnum::INVOICE()) ? PaymentTypeEnum::PAYMENT() : PaymentTypeEnum::RECEIPT()
        ];

        $payment = $this->run(
            CreatePaymentJob::class,
            [
            'data' => $parameters
            ]
        );

        $this->run(
            CreatePaymentAccountingTransactionJob::class,
            [
            'payment' =>$payment,
            'entry' => $this->entry
            ]
        );

        return  $payment;
    }
}
