<?php

namespace App\Services\Accounting\Operations;

use App\Domains\Accounting\Jobs\CreateBaseEntryJob;
use App\Domains\Accounting\Jobs\StoreReceivedBillItemsTransactionsJob;
use App\Domains\Accounting\Jobs\StoreReceivedBillVendorTransactionJob;
use App\Domains\Accounting\Jobs\StoreReceviedBillTaxTransactionsJob;
use App\Enums\AccountingTypeEnum;
use App\Models\Document;
use App\Models\Entry;
use Illuminate\Support\Facades\DB;
use Lucid\Units\Operation;

class StoreReceivedBillEntryOperation extends Operation
{
    private Document $document;

    /**
     * Create a new operation instance.
     *
     * @return void
     */
    public function __construct(Document $document)
    {
        //
        $this->document = $document;
    }

    /**
     * Execute the operation.
     *
     * @return Entry
     */
    public function handle() : ?Entry
    {
        return DB::transaction(
            function () {
                $entry = $this->run(
                    CreateBaseEntryJob::class, [
                    'documentId'  => $this->document->id,
                    'description' => 'private-key::bill_received',
                    'isPending'   => false
                    ]
                );

                $this->run(
                    StoreReceivedBillItemsTransactionsJob::class, [
                    'entry'    => $entry,
                    'document' => $this->document
                    ]
                );

                $this->run(
                    StoreReceivedBillVendorTransactionJob::class, [
                    'entry'    => $entry,
                    'document' => $this->document
                    ]
                );
                $this->run(
                    StoreReceviedBillTaxTransactionsJob::class, [
                    'entry'    => $entry,
                    'document' => $this->document
                    ]
                );

                $entry->update(
                    [
                    'amount' => $entry->transactions()->where('type', AccountingTypeEnum::DEBIT())->sum('amount')
                    ]
                );

                return $entry;
            }
        );
    }
}
