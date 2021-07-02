<?php

namespace Tests\Unit\Domains\User\Jobs;

use App\Domains\User\Jobs\ValidateCreateNewUserJob;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class ValidateCreateNewUserJobTest extends TestCase
{
    use WithFaker;

    public function test_validate_create_new_user_job_empty_email()
    {
        $password = $this->faker->password(25, 100);
        $this->expectException(ValidationException::class);
        $name = $this->faker->userName;
        $job  = new ValidateCreateNewUserJob([
            'name'                  => $this->faker->userName,
            'email'                 => '',
            'password'              => $password,
            'password_confirmation' => $password
        ]);
        $job->handle();
    }

    public function test_validate_create_new_user_job_invalid_email()
    {
        $password = $this->faker->password(25, 100);
        $this->expectException(ValidationException::class);
        $name = $this->faker->userName;
        $job  = new ValidateCreateNewUserJob([
            'name'                  => $this->faker->userName,
            'email'                 => $this->faker->userName,
            'password'              => $password,
            'password_confirmation' => $password
        ]);
        $job->handle();
    }

    public function test_validate_create_new_user_job_empty_name()
    {
        $password = $this->faker->password(25, 100);
        $this->expectException(ValidationException::class);

        $job = new ValidateCreateNewUserJob([
            'name'                  => '',
            'email'                 => $this->faker->companyEmail,
            'password'              => $password,
            'password_confirmation' => $password
        ]);
        $job->handle();
    }

    public function test_validate_create_new_user_job_empty_password()
    {
        $password = $this->faker->password(25, 100);
        $this->expectException(ValidationException::class);

        $job = new ValidateCreateNewUserJob([
            'name'                  => $this->faker->userName,
            'email'                 => $this->faker->companyEmail,
            'password'              => '',
            'password_confirmation' => $password
        ]);
        $job->handle();
    }

    public function test_validate_create_new_user_job_invalid_password()
    {
        $password = $this->faker->password(3, 6);
        $this->expectException(ValidationException::class);

        $job = new ValidateCreateNewUserJob([
            'name'                  => $this->faker->userName,
            'email'                 => $this->faker->companyEmail,
            'password'              => $password,
            'password_confirmation' => $password
        ]);
        $job->handle();
    }

    public function test_validate_create_new_user_job_invalid_password_confirmation()
    {
        $this->expectException(ValidationException::class);

        $job = new ValidateCreateNewUserJob([
            'name'                  => $this->faker->userName,
            'email'                 => $this->faker->companyEmail,
            'password'              => $this->faker->password(25, 100),
            'password_confirmation' => $this->faker->password(25, 100)
        ]);
        $job->handle();
    }

    public function test_validate_create_new_user_job()
    {
        $password = $this->faker->password(25, 100);
        $this->expectNotToPerformAssertions();

        $job = new ValidateCreateNewUserJob([
            'name'                  => $this->faker->userName,
            'email'                 => $this->faker->companyEmail,
            'password'              => $password,
            'password_confirmation' => $password
        ]);
        $job->handle();
    }
}
