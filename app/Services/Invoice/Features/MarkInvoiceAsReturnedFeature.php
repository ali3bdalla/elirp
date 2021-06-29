<?php

namespace App\Services\Invoice\Features;

use App\Domains\Accounting\Jobs\CreateBaseEntryJob;
use App\Domains\Accounting\Jobs\StoreDeliveredInvoiceCogsTransactionsJob;
use App\Domains\Accounting\Jobs\StoreDeliveredInvoiceSalesTransactionsJob;
use App\Domains\Accouting\Jobs\StoreDeliveredInvoiceCustomerTransactionJob;
use App\Domains\Accouting\Jobs\StoreDeliveredInvoiceTaxTransactionsJob;
use App\Domains\Document\Jobs\ChangeDocumentStatusJob;
use App\Domains\Document\Jobs\StoreDocumentHistoryJob;
use App\Domains\Invoice\Jobs\ValidateDeliverableInvoiceJob;
use App\Domains\Invoice\Jobs\ValidateReturnableInvoiceJob;
use App\Enums\AccountingTypeEnum;
use App\Enums\DocumentStatusEnum;
use App\Models\Document;
use App\Services\Inventory\Operations\RegisterDocumentInventoryTransactionsOperation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lucid\Units\Feature;

class MarkInvoiceAsReturnedFeature extends Feature
{
    private Document $document;

    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    public function handle(Request $request): Document
    {
        return DB::transaction(
            function () {
                if ($this->run(
                    ValidateReturnableInvoiceJob::class,
                    [
                        'document' => $this->document
                    ]
                )
                ) {
                    $entry = $this->run(
                        CreateBaseEntryJob::class,
                        [
                            'documentId'  => $this->document->id,
                            'description' => 'private-key::invoice_returned',
                            'isPending'   => false
                        ]
                    );

                    $inventoryTransactions = $this->run(
                        RegisterDocumentInventoryTransactionsOperation::class,
                        [
                            'entry'    => $entry,
                            'document' => $this->document,
                            'reverse' => true
                        ]
                    );
                    $this->run(
                        StoreDeliveredInvoiceCustomerTransactionJob::class,
                        [
                            'entry'    => $entry,
                            'document' => $this->document,
                            'reverse' => true
                        ]
                    );
                    $this->run(
                        StoreDeliveredInvoiceTaxTransactionsJob::class,
                        [
                            'entry'    => $entry,
                            'document' => $this->document,
                            'reverse' => true
                        ]
                    );

                    $this->run(
                        StoreDeliveredInvoiceCogsTransactionsJob::class,
                        [
                            'entry'    => $entry,
                            'inventoryTransactions' => $inventoryTransactions,
                            'document' => $this->document,
                            'reverse' => true
                        ]
                    );

                    $this->run(
                        StoreDeliveredInvoiceSalesTransactionsJob::class,
                        [
                            'entry'    => $entry,
                            'document' => $this->document,
                            'reverse' => true
                        ]
                    );


                    $entry->update(
                        [
                            'amount' => $entry->transactions()->where('type', AccountingTypeEnum::DEBIT())->sum('amount')
                        ]
                    );





                    $this->run(
                        ChangeDocumentStatusJob::class,
                        [
                            'document'           => $this->document,
                            'documentStatusEnum' => DocumentStatusEnum::returned()
                        ]
                    );


                    $this->run(
                        StoreDocumentHistoryJob::class,
                        [
                            'document'    => $this->document->fresh(),
                            'notify'      => 0,
                            'description' => 'Marked as Returned'
                        ]
                    );

                    return $this->document;
                }
            }
        );
    }
}
