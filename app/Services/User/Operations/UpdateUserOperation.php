<?php

namespace App\Services\User\Operations;

use App\Domains\User\Jobs\UpdateUserPasswordJob;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Lucid\Units\Operation;

class UpdateUserOperation extends Operation
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
     * Execute the operation.
     *
     * @return User
     */
    public function handle() : User
    {
        $this->user->update([
            'email' => $this->request->input('email'),
            'name'  => $this->request->input('name'),
        ]);
        $this->run(UpdateUserPasswordJob::class, [
            'user'     => $this->user,
            'password' => $this->request->input('password')
        ]);
        return $this->user->fresh();
    }
}
