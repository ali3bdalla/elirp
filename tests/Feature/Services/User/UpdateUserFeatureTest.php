<?php

namespace Tests\Feature\Services\User;

use App\Models\User;
use Tests\TestCase;
use App\Services\User\Features\UpdateUserFeature;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UpdateUserFeatureTest extends TestCase
{
    use WithFaker;
    public function test_update_user_feature()
    {

       $user = User::factory()->create();
        $password = $this->faker->password(25,100);
        $email = $this->faker->email;
        $name = $this->faker->userName;
        $job = new UpdateUserFeature($user);
        $updatedUser = $job->handle(
            new Request([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password])
        );
        $this->assertTrue(Hash::check($password,$updatedUser->password));
         $this->assertEquals($updatedUser->email,$email);
         $this->assertEquals($updatedUser->name,$name);

    }
}
