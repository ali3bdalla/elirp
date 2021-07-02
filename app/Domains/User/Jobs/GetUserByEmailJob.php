<?php

namespace App\Domains\User\Jobs;

use App\Models\User;
use Lucid\Units\Job;

class GetUserByEmailJob extends Job
{
    private string|null $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string|null $email = null)
    {
        //
        $this->email=$email;
    }

    /**
     * Execute the job.
     *
     * @return User|null
     */
    public function handle() : ?User
    {
        return User::where('email', $this->email)->first();
    }
}
