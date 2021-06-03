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
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class StoreReceivedBillItemsTransactionsJobTest extends TestCase
{
    use WithFaker;
    public function test_store_received_bill_items_transactions_job()
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
        $precision = 2;
        $stock = Account::default(AccountSlugsEnum::DEFAULT_STOCK_ACCOUNT());
        $job = new StoreReceivedBillItemsTransactionsJob($entry, $document);
        $transactions = $job->handle();
        $this->assertIsArray($transactions);
        foreach ($transactions as $transaction) {
            $this->assertInstanceOf(Transaction::class, $transaction);
            $item = $documentItems->where('id', $transaction->item_id)->first();
            $this->assertEquals(round($transaction->amount, $precision), round($item->subtotal, $precision));
            $this->assertEquals($transaction->account_id, $stock->id);
        }
    }
}
