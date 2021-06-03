<?php


namespace Tests\Unit\Domains\Bill\Listeners;

use App\Enums\AccountGroupEnum;
use App\Enums\AccountingTypeEnum;
use App\Enums\AccountSlugsEnum;
use App\Events\Bill\BillHasBeenMarkedAsReceivedEvent;
use App\Listeners\Bill\RegisterReceivedBillAccountingEntryListener;
use App\Models\Account;
use App\Models\Entry;
use App\Models\User;
use App\Models\Document;
use App\Models\DocumentItem;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterReceivedBillAccountingEntryListenerTest extends TestCase
{
    use WithFaker;

    public function test_register_received_bill_accounting_entry_listener()
    {
        $user = User::factory()->create();
        $document = Document::factory()->BILL()->create([
            'company_id' => $user->company_id
        ]);
        $payable = Account::factory()->create([
            'slug' => AccountSlugsEnum::DEFAULT_PAYABLE_ACCOUNT(),
            'group' => AccountGroupEnum::PAYABLE(),
            'company_id' => $user->company_id
        ]);
        $documentItems = DocumentItem::factory()->count($this->faker->numberBetween(1, 5))->create([
            'document_id' => $document->id,
            'type' => $document->type
        ]);
        $document->update([
            'amount' => $documentItems->sum('subtotal')
        ]);
        $precision = 2;
        $this->actingAs($user);


        $event = new BillHasBeenMarkedAsReceivedEvent($document);
        $listener = new RegisterReceivedBillAccountingEntryListener();
        $entry = $listener->handle($event);

        $this->assertInstanceOf(Entry::class, $entry);
        $this->assertEquals(round($entry->amount, $precision), round($documentItems->sum('subtotal'), $precision));
        $this->assertEquals(round($entry->transactions()->where('type', AccountingTypeEnum::DEBIT())->sum('amount'), $precision), round($entry->transactions()->where('type', AccountingTypeEnum::CREDIT())->sum('amount'), $precision));
    }
}
