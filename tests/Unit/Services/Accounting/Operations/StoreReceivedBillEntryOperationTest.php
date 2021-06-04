<?php

namespace Tests\Unit\Services\Accounting\Operations;

use App\Enums\AccountGroupEnum;
use App\Enums\AccountingTypeEnum;
use App\Enums\AccountSlugsEnum;
use App\Models\Account;
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
        $document = Document::factory()->BILL()->create([
            'company_id' => $user->company_id
        ]);
        Account::factory()->create([
            'slug' => AccountSlugsEnum::DEFAULT_PAYABLE_ACCOUNT(),
            'group' => AccountGroupEnum::PAYABLE(),
            'company_id' => $user->company_id
        ]);
        Account::factory()->create([
            'slug' => AccountSlugsEnum::DEFAULT_STOCK_ACCOUNT(),
            'group' => AccountGroupEnum::CURRENT_ASSETS(),
            'company_id' => $user->company_id
        ]);
        Account::factory()->create([
            'slug' => AccountSlugsEnum::DEFAULT_TAX_ACCOUNT(),
            'group' => AccountGroupEnum::TAX(),
            'company_id' => $user->company_id
        ]);
        $documentItems = DocumentItem::factory()->count($this->faker->numberBetween(1, 5))->create([
            'document_id' => $document->id,
            'type' => $document->type
        ]);
        $document->update([
           'amount' =>  $documentItems->sum('subtotal')
        ]);
        $this->actingAs($user);
        $job = new StoreReceivedBillEntryOperation($document);
        $entry = $job->handle();
        $this->assertInstanceOf(Entry::class, $entry);
        $this->assertEquals(round($entry->amount), round($documentItems->sum('subtotal')));
        $this->assertEquals(round($entry->transactions()->where('type', AccountingTypeEnum::DEBIT())->sum('amount')), round($entry->transactions()->where('type', AccountingTypeEnum::CREDIT())->sum('amount')));
    }
}
