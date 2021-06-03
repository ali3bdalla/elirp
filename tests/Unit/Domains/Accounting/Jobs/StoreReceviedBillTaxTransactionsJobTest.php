<?php

namespace Tests\Unit\Domains\Accounting\Jobs;

use App\Domains\Accounting\Jobs\CreatedTaxAccountJob;
use App\Domains\Accounting\Jobs\StoreReceivedBillVendorTransactionJob;
use App\Enums\AccountSlugsEnum;
use App\Enums\DocumentStatusEnum;
use App\Enums\DocumentTypeEnum;
use App\Models\Account;
use App\Models\Entry;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Contact;
use App\Models\Item;
use App\Models\Document;
use App\Models\DocumentItem;
use App\Models\Currency;
use App\Models\Tax;
use App\Services\Document\Operations\StoreDocumentOperation;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use App\Domains\Accounting\Jobs\StoreReceviedBillTaxTransactionsJob;

class StoreReceviedBillTaxTransactionsJobTest extends TestCase
{
    use WithFaker;

    public function test_store_recevied_bill_tax_transactions_job()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $items = Item::factory()->count($this->faker->numberBetween(1, 10))->create([
            'company_id' => $user->company_id
        ]);

        $contact = Contact::factory()->enabledFactoryState()->vendor()->create([
            'company_id' => $user->company_id
        ]);
        $currency = Currency::factory()->enabledFactoryState()->create([
            'company_id' => $user->company_id
        ]);

        $request = [
            'contact_id' => $contact->id,
            'document_number' => $this->faker->sentence,
            'amount' => $this->faker->numberBetween(1, 500),
            'status' => 'pending',
            'issued_at' => $this->faker->dateTime(),
            'due_at' => $this->faker->dateTime(),
            'currency_code' => $currency->code,
            'currency_rate' => $currency->rate
        ];

        $taxes = Tax::factory()->count($this->faker->numberBetween(1, 3))->create([
            'company_id' => $user->company_id
        ]);

        $taxesIds = $taxes->pluck('id')->toArray();
        foreach ($items as $item) {
            $request['items'][] = [
                'item_id' => $item->id,
                'price' => $this->faker->randomFloat(2, 10, 20),
                'quantity' => $this->faker->numberBetween(2, 3),
                'name' => $item->name,
                'discount' => $this->faker->numberBetween(1, 2),
                'tax_ids' => $taxesIds
            ];
        }
        Event::fakeFor(function () use ($request) {
            $mainJob = new StoreDocumentOperation($request, DocumentTypeEnum::bill());
            $document = $mainJob->handle();
            $document->update([
                'status' => DocumentStatusEnum::received()
            ]);
            $entry = Entry::factory()->create([
                'document_id' => $document->id,
                'company_id' => $document->company_id,
            ]);
            $job = new StoreReceviedBillTaxTransactionsJob($entry, $document);
            $result = $job->handle();
            $this->assertIsArray($request);
            foreach ($result as $transaction) {
                $this->assertInstanceOf(Transaction::class, $transaction);
                $this->assertInstanceOf(Account::class, $transaction->account);
                $this->assertInstanceOf(Tax::class, $transaction->account->tax);
                $this->assertSame($transaction->account_id, $transaction->account->tax->account_id);
            }
        });
    }
}
