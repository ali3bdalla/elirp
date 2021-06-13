<?php

namespace Tests\Unit\Domains\Document\Jobs;

use App\Domains\Document\Jobs\ValidateDocumentItemsJob;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class ValidateDocumentItemsJobTest extends TestCase
{
    use WithFaker;

    public function test_validate_document_items_job_empty_items()
    {
        $this->expectException(ValidationException::class);
        $request = [
            'items' => []
        ];
        $job = new ValidateDocumentItemsJob($request);
        $job->handle();
    }

    public function test_validate_document_items_job_null_item_name()
    {
        $this->expectException(ValidationException::class);
        $request = [
            'items' => [
                [
                    'name'     => null,
                    'quantity' => $this->faker->numberBetween(1, 100000),
                    'price'    => $this->faker->numberBetween(1, 100000),
                ]
            ]
        ];
        $job = new ValidateDocumentItemsJob($request);
        $job->handle();
    }

    public function test_validate_document_items_job_null_price()
    {
        $this->expectException(ValidationException::class);
        $request = [
            'items' => [
                [
                    'name'     => $this->faker->sentence,
                    'quantity' => $this->faker->numberBetween(1, 100000),
                    'price'    => null,
                ]
            ]
        ];
        $job = new ValidateDocumentItemsJob($request);
        $job->handle();
    }

    public function test_validate_document_items_job_null_quantity()
    {
        $this->expectException(ValidationException::class);
        $request = [
            'items' => [
                [
                    'name'     => $this->faker->sentence,
                    'price'    => $this->faker->numberBetween(1, 100000),
                    'quantity' => null,
                ]
            ]
        ];
        $job = new ValidateDocumentItemsJob($request);
        $job->handle();
    }

    public function test_validate_document_items_job_valid()
    {
        $request = [
            'items' => [
                [
                    'name'     => $this->faker->sentence,
                    'quantity' => $this->faker->numberBetween(1, 100000),
                    'price'    => $this->faker->numberBetween(1, 100000),
                ]
            ]
        ];
        $job    = new ValidateDocumentItemsJob($request);
        $result = $job->handle();

        $this->assertInstanceOf(FormRequest::class, $result);
    }
}
