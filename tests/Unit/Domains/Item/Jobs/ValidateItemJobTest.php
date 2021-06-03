<?php

namespace Tests\Unit\Domains\Item\Jobs;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;
use App\Domains\Item\Jobs\ValidateItemJob;

class ValidateItemJobTest extends TestCase
{
    use WithFaker;
    public function test_validate_item_job_name_is_null()
    {
        $this->expectException(ValidationException::class);
        $data = [
            "name" => null,
            "quantity" => $this->faker->randomFloat(2, 10, 20),
            "sale_price" => $this->faker->randomFloat(2, 10, 20)
        ];
        $job = new ValidateItemJob($data);
        $job->handle();
    }


    public function test_validate_item_job_pass()
    {
        Storage::fake('avatars');
        $data = [
            "name" => $this->faker->sentence,
            "quantity" => $this->faker->randomFloat(2, 10, 20),
            'sku' => $this->faker->bankAccountNumber,
            'description' => $this->faker->sentence,
            'sale_price' => $this->faker->randomFloat(2, 10, 20),
            'purchase_price' => $this->faker->randomFloat(2, 10, 20),
            'category_id' => null,
            'fixed_price' => $this->faker->boolean,
            'is_service' => $this->faker->boolean,
            'has_detail' => $this->faker->boolean,
            'picture' =>  UploadedFile::fake()->image('avatar.png')
        ];

        $job = new ValidateItemJob($data);
        $this->assertNull($job->handle());
    }
}
