<?php

namespace App\Services\Document\Features;

use App\Domains\Accounting\Jobs\CreateBaseEntryJob;
use App\Domains\Accounting\Jobs\StorePaidDocumentContactTransactionJob;
use App\Domains\Document\Jobs\ChangeDocumentStatusJob;
use App\Domains\Document\Jobs\StoreDocumentHistoryJob;
use App\Domains\Document\Jobs\ValidatePayableDocumentJob;
use App\Enums\AccountingTypeEnum;
use App\Enums\DocumentStatusEnum;
use App\Models\Document;
use App\Notifications\Document\DocumentPaidNotification;
use App\Services\Payment\Operations\RegisterPaidDocumentPaymentsOperation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lucid\Units\Feature;

class MarkDocumentAsPaidFeature extends Feature
{
    public function __construct(public Document $document)
    {
    }

    public function handle(Request $request) : Document
    {
        return DB::transaction(
            function () {
                if ($this->run(
                    ValidatePayableDocumentJob::class,
                    [
                        'document' => $this->document
                    ]
                )
                ) {
                    $entry = $this->run(
                        CreateBaseEntryJob::class,
                        [
                            'documentId'  => $this->document->id,
                            'description' => 'private-key::document_paid',
                            'isPending'   => false
                        ]
                    );

                    $payment = $this->run(
                        RegisterPaidDocumentPaymentsOperation::class,
                        [
                            'entry'    => $entry,
                            'document' => $this->document
                        ]
                    );

                    $this->run(
                        StorePaidDocumentContactTransactionJob::class,
                        [
                            'document' => $this->document,
                            'payment'  => $payment,
                            'entry'    => $entry
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
                            'documentStatusEnum' => DocumentStatusEnum::paid()
                        ]
                    );

                    $this->run(
                        StoreDocumentHistoryJob::class,
                        [
                            'document'    => $this->document->fresh(),
                            'notify'      => 0,
                            'description' => 'Marked as Paid'
                        ]
                    );
                    $this->document->contact->notify(new DocumentPaidNotification($this->document));
                    return $this->document;
                }
            }
        );
    }
}
