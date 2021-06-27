<?php

namespace App\Services\User\Features;

use App\Domains\User\Jobs\CreateNewUserJob;
use App\Domains\User\Jobs\ValidateCreateNewUserJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Lucid\Units\Feature;

class StoreUserFeature extends Feature
{
    public function handle(Request $request)
    {

        $this->run(ValidateCreateNewUserJob::class,[
            'request'=> $request->all()
        ]);
        $user = $this->run(CreateNewUserJob::class, [
            'name'      => $request->input('name'),
            'email'     => $request->input('email'),
            'password'  => Hash::make($request->input('password')),
            'companyId' => company_id(),
            'locale'    => 'en-GB',
            'enabled'   => '1',
        ]);
        return $user;
    }
}
