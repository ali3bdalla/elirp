<?php

namespace Tests\Unit\Services\Accounting\Operations;

use App\Enums\AccountingTypeEnum;
use App\Models\Entry;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Document;
use App\Models\DocumentItem;
use App\Services\Accounting\Operations\StoreReceivedBillEntryOperation;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreReceivedBillEntryOperationTest extends TestCase
{
    use WithFaker;

    public function test_store_received_bill_entry_operation()
    {
        $user = User::factory()->create();
        $document = Document::factory()->bill()->create([
            'company_id' => $user->company_id
        ]);
        $documentItems = DocumentItem::factory()->count($this->faker->numberBetween(1, 5))->create([
            'document_id' => $document->id,
            'type' => $document->type
        ]);
        $document->update([
           'amount' =>  $documentItems->sum('subtotal')
        ]);
        $precision = 2;
        $this->actingAs($user);
        $job = new StoreReceivedBillEntryOperation($document);
        $entry = $job->handle();
        $this->assertInstanceOf(Entry::class, $entry);
        $this->assertEquals(round($entry->amount, $precision), round($documentItems->sum('subtotal'), $precision));
        $this->assertEquals(round($entry->transactions()->where('type', AccountingTypeEnum::DEBIT())->sum('amount'), $precision), round($entry->transactions()->where('type', AccountingTypeEnum::CREDIT())->sum('amount'), $precision));
    }
}
