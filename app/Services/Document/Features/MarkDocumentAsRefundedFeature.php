<?php

namespace App\Services\Document\Features;

use App\Domains\Accounting\Jobs\CreateBaseEntryJob;
use App\Domains\Accounting\Jobs\StorePaidDocumentContactTransactionJob;
use App\Domains\Document\Jobs\ChangeDocumentStatusJob;
use App\Domains\Document\Jobs\StoreDocumentHistoryJob;
use App\Domains\Document\Jobs\ValidateRefundableDocumentJob;
use App\Enums\AccountingTypeEnum;
use App\Enums\DocumentStatusEnum;
use App\Models\Document;
use App\Services\Payment\Operations\RegisterRefundedDocumentPaymentsOperation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lucid\Units\Feature;

class MarkDocumentAsRefundedFeature extends Feature
{
    public function __construct(public Document $document)
    {
    }

    public function handle(Request $request): Document
    {
        return DB::transaction(
            function () {
                if ($this->run(
                    ValidateRefundableDocumentJob::class,
                    [
                    'document' => $this->document
                    ]
                )
                ) {
                    $entry = $this->run(
                        CreateBaseEntryJob::class,
                        [
                        'documentId'  => $this->document->id,
                        'description' => 'private-key::document_refunded',
                        'isPending'   => false
                        ]
                    );

                    $payment = $this->run(
                        RegisterRefundedDocumentPaymentsOperation::class,
                        [
                             'entry'    => $entry,
                            'document' => $this->document
                        ]
                    );


                    $this->run(
                        StorePaidDocumentContactTransactionJob::class,
                        [
                        'document' => $this->document,
                        'payment' => $payment,
                        'entry' => $entry
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
                        'documentStatusEnum' => DocumentStatusEnum::refunded()
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

                    return $this->document;
                }
            }
        );
    }
}
