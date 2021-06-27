<?php

namespace Tests\Unit\Services\User\Operations;

use App\Models\User;
use Tests\TestCase;
use App\Services\User\Operations\UpdateUserOperation;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;

class UpdateUserOperationTest extends TestCase
{
    use WithFaker;
    public function test_update_user_operation()
    {
        $user = User::factory()->create();
        $password = $this->faker->password(25,100);
        $email = $this->faker->email;
        $name = $this->faker->userName;

        $job = new UpdateUserOperation($user,[
            'name' => $name,
            'email' => $email,
            'password' => $password
        ]);
        $updatedUser = $job->handle();
        $this->assertTrue(Hash::check($password,$updatedUser->password));
         $this->assertEquals($updatedUser->email,$email);
         $this->assertEquals($updatedUser->name,$name);

    }
}
