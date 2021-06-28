<?php

namespace App\Domains\User\Jobs;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Lucid\Units\Job;

class UpdateUserPasswordJob extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public User $user, public $password = '')
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->password) {
            $this->user->update([
                'password' => Hash::make($this->password)
            ]);
        }
    }
}
