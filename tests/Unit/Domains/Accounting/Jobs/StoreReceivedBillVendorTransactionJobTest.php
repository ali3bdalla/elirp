<?php

namespace Tests\Unit\Domains\Accounting\Jobs;

use App\Domains\Accounting\Jobs\StoreReceivedBillItemsTransactionsJob;
use App\Enums\AccountSlugsEnum;
use App\Models\Account;
use App\Models\Entry;
use App\Models\Transaction;
use App\Models\Document;
use App\Models\DocumentItem;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Domains\Accounting\Jobs\StoreReceivedBillVendorTransactionJob;

class StoreReceivedBillVendorTransactionJobTest extends TestCase
{
    use WithFaker;
    public function test_store_received_bill_vendor_transaction_job()
    {
        $document = Document::factory()->bill()->create();
        $documentItems = DocumentItem::factory()->count($this->faker->numberBetween(1, 5))->create([
            'document_id' => $document->id,
            'type' => $document->type
        ]);
        $entry = Entry::factory()->create([
            'document_id' => $document->id,
            'company_id' => $document->company_id,
        ]);
        $precision = config('money.' . $document->currency_code . '.precision');
        $payable = Account::default(AccountSlugsEnum::DEFAULT_PAYABLE_ACCOUNT());
        $job = new StoreReceivedBillVendorTransactionJob($entry, $document);
        $transaction = $job->handle();
        $this->assertInstanceOf(Transaction::class, $transaction);
        $this->assertEquals(round($transaction->amount, $precision), round($document->amount, $precision));
        $this->assertEquals($transaction->account_id, $payable->id);
    }
}
