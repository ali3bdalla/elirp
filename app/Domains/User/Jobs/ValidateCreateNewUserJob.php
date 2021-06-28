<?php

namespace App\Domains\User\Jobs;

use Illuminate\Foundation\Http\FormRequest;
use Lucid\Units\Job;

class ValidateCreateNewUserJob extends Job
{
    private FormRequest  $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request)
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
            'email'                 => 'required|email:rfc,dns,spoof,filter,strict|unique:users,email',
            'password'              => 'required|min:8|string|max:200|confirmed',
            'password_confirmation' => 'required|min:8|string|max:200',
            'name'                  => 'required|string|max:30'
        ]);
    }
}
