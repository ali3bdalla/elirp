<?php

namespace App\Services\Bill\Features;

use App\Domains\Document\Jobs\GenerateDocumentPaymentUsingDefaultCashJob;
use App\Models\Document;
use Illuminate\Http\Request;
use Lucid\Units\Feature;

class MarkBillAsPaidFeature extends Feature
{
    private Document $bill;
    public function __construct(Document $bill) {
        $this->bill = $bill;
    }
    public function handle(Request $request)
     {
            $payment = $this->run(GenerateDocumentPaymentUsingDefaultCashJob::class,[
                'document' => $this->bill
            ]);

            dd($payment);
    }
}
