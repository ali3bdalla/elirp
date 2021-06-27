<?php

namespace App\Services\User\Features;

use App\Domains\User\Jobs\ValidateUpdateJob;
use App\Models\User;
use App\Services\User\Operations\UpdateUserOperation;
use Illuminate\Http\Request;
use Lucid\Units\Feature;

class UpdateUserFeature extends Feature
{
    public function __construct(public User $user){}
    public function handle($request)
    {
        $request = parse_request_instance($request);
        $this->run(ValidateUpdateJob::class,[
            'user' => $this->user,
            'request' => $request->all()
        ]);
        return $this->run(UpdateUserOperation::class,[
            'user' => $this->user,
            'request' => $request->all()
        ]);
    }
}
