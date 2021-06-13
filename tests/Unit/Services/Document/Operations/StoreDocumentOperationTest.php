<?php

namespace Tests\Unit\Services\Document\Operations;

use App\Enums\DocumentTypeEnum;
use App\Events\Document\BillDocumentCreatedEvent;
use App\Events\Document\InvoiceDocumentCreatedEvent;
use App\Models\Contact;
use App\Models\Currency;
use App\Models\Document;
use App\Models\Item;
use App\Models\Tax;
use App\Models\User;
use App\Services\Document\Operations\StoreDocumentOperation;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class StoreDocumentOperationTest extends TestCase
{
    use WithFaker;

    public function test_store_document_operation_bill()
    {
        Event::fake();
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
            'contact_id'      => $contact->id,
            'document_number' => $this->faker->sentence,
            'amount'          => $this->faker->numberBetween(1, 500),
            'status'          => 'pending',
            'issued_at'       => $this->faker->dateTime(),
            'due_at'          => $this->faker->dateTime(),
            'currency_code'   => $currency->code,
            'currency_rate'   => $currency->rate
        ];

        $taxes = Tax::factory()->count($this->faker->numberBetween(1, 3))->create([
            'company_id' => $user->company_id
        ]);
        $taxesIds = $taxes->pluck('id')->toArray();
        foreach ($items as $item) {
            $request['items'][] = [
                'id'       => $item->id,
                'price'    => $this->faker->randomFloat(2, 10, 20),
                'quantity' => $this->faker->numberBetween(2, 3),
                'name'     => $item->name,
                'discount' => $this->faker->numberBetween(1, 2),
                'tax_ids'  => $taxesIds
            ];
        }

        $job      = new StoreDocumentOperation($request, DocumentTypeEnum::BILL());
        $document = $job->handle();

        $this->assertInstanceOf(Document::class, $document);
        Event::assertDispatched(BillDocumentCreatedEvent::class);
        $this->assertSame($document->histories()->count(), 1);
    }

    public function test_store_document_operation_invoice()
    {
        Event::fake();
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
            'contact_id'      => $contact->id,
            'document_number' => $this->faker->sentence,
            'amount'          => $this->faker->numberBetween(1, 500),
            'status'          => 'pending',
            'issued_at'       => $this->faker->dateTime(),
            'due_at'          => $this->faker->dateTime(),
            'currency_code'   => $currency->code,
            'currency_rate'   => $currency->rate
        ];

        $taxes = Tax::factory()->count($this->faker->numberBetween(1, 3))->create([
            'company_id' => $user->company_id
        ]);
        $taxesIds = $taxes->pluck('id')->toArray();
        foreach ($items as $item) {
            $request['items'][] = [
                'id'       => $item->id,
                'price'    => $this->faker->randomFloat(2, 10, 20),
                'quantity' => $this->faker->numberBetween(2, 3),
                'name'     => $item->name,
                'discount' => $this->faker->numberBetween(1, 2),
                'tax_ids'  => $taxesIds
            ];
        }

        $job      = new StoreDocumentOperation($request, DocumentTypeEnum::INVOICE());
        $document = $job->handle();

        $this->assertInstanceOf(Document::class, $document);
        Event::assertDispatched(InvoiceDocumentCreatedEvent::class);
        $this->assertSame($document->histories()->count(), 1);
    }
}
