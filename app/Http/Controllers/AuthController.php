<?php

namespace App\Http\Controllers;

use App\Services\User\Features\LoginUserFeature;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
 
    public function page()
    {
    
    }
    public function auth(string $driver)
    {
        $user = Socialite::driver($driver)->user();
        if($user) {
            return $this->serve(LoginUserFeature::class,[
                'user' => $user,
                'driver' => $driver
            ]);
        }
        return Socialite::driver($driver)->redirect();
    }
}
