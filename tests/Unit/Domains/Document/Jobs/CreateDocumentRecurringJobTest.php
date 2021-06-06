<?php

namespace Tests\Unit\Domains\Document\Jobs;

use App\Domains\Document\Jobs\CreateDocumentRecurringJob;
use App\Enums\DocumentTypeEnum;
use App\Models\Document;
use App\Models\Recurring;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateDocumentRecurringJobTest extends TestCase
{
    use WithFaker;

    public function test_create_document_recurring_job()
    {
        $this->markTestIncomplete();
//        $user = User::factory()->create();
//        $document = Document::factory()->BILL()->create([
//            'company_id' => $user->company_id,
//            'type' => $this->faker->randomElement(DocumentTypeEnum::toValues())
//        ]);
//
//        $data = [
//            'recurring_frequency' => 'yes',
//            'recurring_interval' => $this->faker->numberBetween(1, 3),
//            'recurring_custom_frequency' => $this->faker->randomElement(['monthly', 'weekly']),
//            'recurring_count' => $this->faker->numberBetween(1, 3),
//        ];
//        $job = new CreateDocumentRecurringJob($document, $data);
//        $result = $job->handle();
//        $this->assertInstanceOf(Recurring::class, $result);
    }
}
