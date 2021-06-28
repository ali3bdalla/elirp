<?php

namespace Tests\Unit\Domains\User\Jobs;

use App\Domains\User\Jobs\UpdateUserPasswordJob;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UpdateUserPasswordJobTest extends TestCase
{
    use WithFaker;

    public function test_update_user_password_job()
    {
        $user     = User::factory()->create();
        $password = $this->faker->password(25, 100);
        $job      = new UpdateUserPasswordJob($user, $password);
        $job->handle();
        $this->assertTrue(Hash::check($password, $user->fresh()->password));
    }
}
