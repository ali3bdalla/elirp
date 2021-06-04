<?php

namespace Tests\Unit\Domains\Accounting\Jobs;

use App\Models\Entry;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Domains\Accounting\Jobs\CreateBaseEntryJob;

class CreateBaseEntryJobTest extends TestCase
{
    use WithFaker;
    public function test_create_base_entry_job()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $job = new CreateBaseEntryJob();
        $result = $job->handle();
        $this->assertInstanceOf(Entry::class, $result);
    }
}
