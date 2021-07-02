<?php

namespace App\Http\Controllers;

use App\Services\User\Features\LoginUserFeature;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
//use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
//    public function auth()
//    {
//        $driver = 'keycloak';
//        $user = Socialite::driver($driver)->user();
//        if ($user) {
//            return $this->serve(
//                LoginUserFeature::class,
//                [
//                'user'   => $user,
//                'driver' => $driver
//                ]
//            );
//        }
//        return Socialite::driver($driver)->redirect();
//    }
    
    public function logout()
    {
        Auth::logout();
        return Inertia::location('/');
    }
}
