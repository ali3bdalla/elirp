<?php

namespace Tests\Unit\Domains\Document\Jobs;

use App\Domains\Document\Jobs\StoreDocumentJob;
use App\Enums\DocumentTypeEnum;
use App\Models\User;
use App\Models\Contact;
use App\Models\Document;
use App\Models\Currency;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class StoreDocumentJobTest extends TestCase
{
    use WithFaker;

    public function test_store_bill_job()
    {
        $user = User::factory()->enabledFactoryState()->create();
        $this->actingAs($user);
        $contact = Contact::factory()->enabledFactoryState()->vendor()->create([
            'company_id' => $user->company_id
        ]);
        $currency = Currency::factory()->enabledFactoryState()->create([
            'company_id' => $user->company_id
        ]);

        $job = new StoreDocumentJob([
            'contact_id' => $contact->id,
            'document_number' => $this->faker->sentence,
            'amount' => $this->faker->numberBetween(1, 500),
            'status' => 'pending',
            'issued_at' => $this->faker->dateTime(),
            'due_at' => $this->faker->dateTime(),
            'currency_code' => $currency->code,
            'currency_rate' => $currency->rate
        ], DocumentTypeEnum::bill());
        $document = $job->handle();
        $this->assertInstanceOf(Document::class, $document);
    }


    public function test_store_invoice_job()
    {
        $user = User::factory()->enabledFactoryState()->create();
        $this->actingAs($user);
        $contact = Contact::factory()->enabledFactoryState()->customer()->create([
            'company_id' => $user->company_id
        ]);
        $currency = Currency::factory()->enabledFactoryState()->create([
            'company_id' => $user->company_id
        ]);
        $job = new StoreDocumentJob([
            'contact_id' => $contact->id,
            'document_number' => $this->faker->sentence,
            'amount' => $this->faker->numberBetween(1, 500),
            'status' => 'pending',
            'issued_at' => $this->faker->dateTime(),
            'due_at' => $this->faker->dateTime(),
            'currency_code' => $currency->code,
            'currency_rate' => $currency->rate
        ], DocumentTypeEnum::invoice());
        $document = $job->handle();
        $this->assertInstanceOf(Document::class, $document);
    }

    public function test_throw_execption_contact_id_require()
    {
        $this->expectException(ValidationException::class);
        $user = User::factory()->enabledFactoryState()->create();
        $this->actingAs($user);
        $currency = Currency::factory()->enabledFactoryState()->create([
            'company_id' => $user->company_id
        ]);
        $job = new StoreDocumentJob([
            'document_number' => $this->faker->sentence,
            'amount' => $this->faker->numberBetween(1, 500),
            'status' => 'pending',
            'issued_at' => $this->faker->dateTime(),
            'due_at' => $this->faker->dateTime(),
            'currency_code' => $currency->code,
            'currency_rate' => $currency->rate
        ], DocumentTypeEnum::bill());
        $document = $job->handle();
    }
}
