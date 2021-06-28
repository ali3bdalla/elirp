<?php

namespace App\Domains\User\Jobs;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Unique;
use Lucid\Units\Job;

class ValidateUpdateJob extends Job
{
    private FormRequest  $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public User $user, $request)
    {
        $this->request = parse_request_instance($request);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->request->validate([
            'email' => ['required', 'email:rfc,dns,spoof,filter,strict',
                (new Unique('users', 'email'))->whereNot('id', $this->user->id)
            ],
            'password'              => 'nullable|min:8|string|max:200|confirmed',
            'password_confirmation' => 'nullable|min:8|string|max:200',
            'name'                  => 'required|string|max:30'
        ]);
    }
}
