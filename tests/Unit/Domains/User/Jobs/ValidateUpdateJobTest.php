<?php

namespace Tests\Unit\Domains\User\Jobs;

use Tests\TestCase;
use App\Domains\User\Jobs\ValidateUpdateJob;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Validation\ValidationException;

class ValidateUpdateJobTest extends TestCase
{

    use WithFaker;
    public function test_validate_update_job_empty_email()
    {
        $user = User::factory()->create();
           $password = $this->faker->password(25,100);
        $this->expectException(ValidationException::class);
        $name = $this->faker->userName;
        $job = new ValidateUpdateJob($user,[
            'name' => $this->faker->userName,
            'email' => "",
             'password' => $password,
            'password_confirmation' => $password
        ]);
        $job->handle();
    }

    public function test_validate_update_job_invalid_email()
    {
        $user = User::factory()->create();
        $password = $this->faker->password(25,100);
        $this->expectException(ValidationException::class);
        $name = $this->faker->userName;
        $job = new ValidateUpdateJob($user,[
            'name' => $this->faker->userName,
            'email' => $this->faker->userName,
            'password' => $password,
            'password_confirmation' => $password
        ]);
        $job->handle();
    }

     public function test_validate_update_job_empty_name()
    {
        $user = User::factory()->create();
           $password = $this->faker->password(25,100);
        $this->expectException(ValidationException::class);

        $job = new ValidateUpdateJob($user,[
            'name' => '',
            'email' => $this->faker->companyEmail,
             'password' => $password,
            'password_confirmation' => $password
        ]);
        $job->handle();
    }



     public function test_validate_update_job_invalid_password()
    {
        $user = User::factory()->create();
           $password = $this->faker->password(3,6);
        $this->expectException(ValidationException::class);

        $job = new ValidateUpdateJob($user,[
            'name' => $this->faker->userName,
            'email' => $this->faker->companyEmail,
             'password' => $password,
            'password_confirmation' => $password
        ]);
        $job->handle();
    }

      public function test_validate_update_job_invalid_password_confirmation()
    {
        $user = User::factory()->create();
        $this->expectException(ValidationException::class);

        $job = new ValidateUpdateJob($user,[
            'name' => $this->faker->userName,
            'email' => $this->faker->companyEmail,
             'password' => $this->faker->password(25,100),
            'password_confirmation' => $this->faker->password(25,100)
        ]);
        $job->handle();
    }

     public function test_validate_update_job()
    {
        $user = User::factory()->create();
           $password = $this->faker->password(25,100);
        $this->expectNotToPerformAssertions();

        $job = new ValidateUpdateJob($user,[
            'name' => $this->faker->userName,
            'email' => $this->faker->companyEmail,
             'password' => $password,
            'password_confirmation' => $password
        ]);
        $job->handle();
    }
}
