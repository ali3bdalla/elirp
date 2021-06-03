<?php

namespace Tests\Feature\Purchases;

use App\Events\Document\BillDocumentCreatedEvent;
use App\Events\Document\DocumentCreated;
use App\Models\User;
use App\Models\Contact;
use App\Models\Item;
use App\Models\Recurring;
use App\Models\Document;
use App\Models\Currency;
use App\Models\Tax;
use Carbon\Carbon;
use Excel;
use Illuminate\Support\Facades\Event;
use Str;
use Tests\Feature\FeatureTestCase;

class BillControllerTest extends FeatureTestCase
{
    public function test_it_should_see_bill_list_page()
    {
        $this->loginAs()
            ->get(route('bills.index', $this->company->id))
            ->assertStatus(200)
            ->assertSeeText(trans_choice('general.bills', 2));
    }

    public function test_it_should_see_bill_create_page()
    {
        $this->loginAs()
            ->get(route('bills.create', $this->company->id))
            ->assertStatus(200)
            ->assertSeeText(trans('general.title.new', ['type' => trans_choice('general.bills', 1)]));
    }

    public function test_it_should_create_bill()
    {
        Event::fake();
        $user = User::factory()->enabledFactoryState()->create();

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
            'issued_at' => Carbon::now()->toDateTimeString(),
            'due_at' => Carbon::now()->addDays(30)->toDateTimeString(),
            'currency_code' => $currency->code,
            'currency_rate' => $currency->rate
        ];

        $taxes = Tax::factory()->count($this->faker->numberBetween(1, 3))->create([
            'company_id' => $user->company_id
        ]);
        $taxesIds = $taxes->pluck('id')->toArray();
        foreach ($items as $item) {
            $request['items'][] = [
                'id' => $item->id,
                'price' => $this->faker->randomFloat(2, 10, 20),
                'quantity' => $this->faker->numberBetween(2, 3),
                'name' => $item->name,
                'discount' => $this->faker->numberBetween(1, 2),
                'tax_ids' => $taxesIds
            ];
        }


        $this
            ->actingAs($user)
            ->post(route('bills.store'), $request)
            ->dump()
            ->assertOk();

        $this->assertFlashLevel('success');

        $this->assertDatabaseHas('documents', [
            'document_number' => $request['document_number'],
        ]);
        Event::assertDispatched(DocumentCreated::class);
        Event::assertDispatched(BillDocumentCreatedEvent::class);
    }

    public function test_it_should_create_bill_with_recurring()
    {
        Event::fake();
        $user = User::factory()->enabledFactoryState()->create();

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
            'issued_at' => Carbon::now()->toDateTimeString(),
            'due_at' => Carbon::now()->addDays(30)->toDateTimeString(),
            'currency_code' => $currency->code,
            'currency_rate' => $currency->rate,
            'recurring_frequency' => 'yes',
            'recurring_interval' => $this->faker->numberBetween(1, 3),
            'recurring_custom_frequency' => $this->faker->randomElement(['monthly', 'weekly']),
            'recurring_count' => $this->faker->numberBetween(1, 3),
        ];

        $taxes = Tax::factory()->count($this->faker->numberBetween(1, 3))->create([
            'company_id' => $user->company_id
        ]);
        $taxesIds = $taxes->pluck('id')->toArray();
        foreach ($items as $item) {
            $request['items'][] = [
                'id' => $item->id,
                'price' => $this->faker->randomFloat(2, 10, 20),
                'quantity' => $this->faker->numberBetween(2, 3),
                'name' => $item->name,
                'discount' => $this->faker->numberBetween(1, 2),
                'tax_ids' => $taxesIds
            ];
        }


        $this
            ->actingAs($user)
            ->post(route('bills.store'), $request)
            ->assertOk();

        $this->assertFlashLevel('success');

        $this->assertDatabaseHas('documents', [
            'document_number' => $request['document_number'],
        ]);
        Event::assertDispatched(DocumentCreated::class);
        Event::assertDispatched(BillDocumentCreatedEvent::class);

        $document = Document::where('document_number', $request['document_number'])->first();
        $this->assertInstanceOf(Recurring::class, $document->recurring);
        $this->assertEquals($document->recurring->started_at, $document->issued_at);
    }
//


//    public function testItShouldSeeBillUpdatePage()
//    {
//        $request = $this->getRequest();
//
//        $bill = $this->dispatch(new CreateDocument($request));
//
//        $this->loginAs()
//            ->get(route('bills.edit', $bill->id))
//            ->assertStatus(200)
//            ->assertSee($bill->contact_email);
//    }
//
//    public function testItShouldUpdateBill()
//    {
//        $request = $this->getRequest();
//
//        $bill = $this->dispatch(new CreateDocument($request));
//
//        $request['contact_email'] = $this->faker->safeEmail;
//
//        $this->loginAs()
//            ->patch(route('bills.update', $bill->id), $request)
//            ->assertStatus(200)
//            ->assertSee($request['contact_email']);
//
//        $this->assertFlashLevel('success');
//
//        $this->assertDatabaseHas('documents', [
//            'document_number' => $request['document_number'],
//            'contact_email' => $request['contact_email'],
//        ]);
//    }
//
//    public function testItShouldDeleteBill()
//    {
//        $request = $this->getRequest();
//
//        $bill = $this->dispatch(new CreateDocument($request));
//
//        $this->loginAs()
//            ->delete(route('bills.destroy', $bill->id))
//            ->assertStatus(200);
//
//        $this->assertFlashLevel('success');
//
//        $this->assertSoftDeleted('documents', [
//            'document_number' => $request['document_number'],
//        ]);
//    }
//
//    public function testItShouldExportBills()
//    {
//        $count = 5;
//        Document::factory()->bill()->count($count)->create();
//
//        Excel::fake();
//
//        $this->loginAs()
//            ->get(route('bills.export'))
//            ->assertStatus(200);
//
//        Excel::assertDownloaded(
//            Str::filename(trans_choice('general.bills', 2)) . '.xlsx',
//            function (Export $export) use ($count) {
//                // Assert that the correct export is downloaded.
//                return $export->sheets()['bills']->collection()->count() === $count;
//            }
//        );
//    }
//
//    public function testItShouldExportSelectedBills()
//    {
//        $count = 5;
//        $bills = Document::factory()->bill()->count($count)->create();
//
//        Excel::fake();
//
//        $this->loginAs()
//            ->post(
//                route('bulk-actions.action', ['group' => 'purchases', 'type' => 'bills']),
//                ['handle' => 'export', 'selected' => [$bills->random()->id]]
//            )
//            ->assertStatus(200);
//
//        Excel::assertDownloaded(
//            Str::filename(trans_choice('general.bills', 2)) . '.xlsx',
//            function (Export $export) {
//                return $export->sheets()['bills']->collection()->count() === 1;
//            }
//        );
//    }
//
//    public function testItShouldImportBills()
//    {
//        Excel::fake();
//
//        $this->loginAs()
//            ->post(
//                route('bills.import'),
//                [
//                    'import' => UploadedFile::fake()->createWithContent(
//                        'bills.xlsx',
//                        File::get(public_path('files/import/bills.xlsx'))
//                    ),
//                ]
//            )
//            ->assertStatus(200);
//
//        Excel::assertImported('bills.xlsx');
//
//        $this->assertFlashLevel('success');
//    }
}
