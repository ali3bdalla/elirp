<?php

namespace App\Services\Bill\Features;

use App\Domains\Accounting\Jobs\CreateBaseEntryJob;
use App\Domains\Accounting\Jobs\StoreReceivedBillVendorTransactionJob;
use App\Domains\Accounting\Jobs\StoreReceviedBillTaxTransactionsJob;
use App\Domains\Bill\Jobs\ValidateReturnableBillJob;
use App\Domains\Document\Jobs\ChangeDocumentStatusJob;
use App\Domains\Document\Jobs\StoreDocumentHistoryJob;
use App\Enums\AccountingTypeEnum;
use App\Enums\DocumentStatusEnum;
use App\Models\Document;
use App\Services\Inventory\Operations\RegisterDocumentInventoryTransactionsOperation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lucid\Units\Feature;

class MarkBillAsReturnedFeature extends Feature
{
    public function __construct(public Document $document)
    {
    }

    public function handle(Request $request) : Document
    {
        return DB::transaction(
            function () {
                if ($this->run(
                    ValidateReturnableBillJob::class,
                    [
                        'document' => $this->document
                    ]
                )
                ) {
                    $entry = $this->run(
                        CreateBaseEntryJob::class,
                        [
                            'documentId'  => $this->document->id,
                            'description' => 'private-key::bill_returned',
                            'isPending'   => false
                        ]
                    );

                    $this->run(
                        RegisterDocumentInventoryTransactionsOperation::class,
                        [
                            'entry'    => $entry,
                            'document' => $this->document,
                            'reverse'  => true
                        ]
                    );
                    $this->run(
                        StoreReceivedBillVendorTransactionJob::class,
                        [
                            'entry'    => $entry,
                            'document' => $this->document,
                            'reverse'  => true
                        ]
                    );
                    $this->run(
                        StoreReceviedBillTaxTransactionsJob::class,
                        [
                            'entry'    => $entry,
                            'document' => $this->document,
                            'reverse'  => true
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
                            'description' => 'Marked as received'
                        ]
                    );

                    return $this->document;
                }
            }
        );
    }
}
