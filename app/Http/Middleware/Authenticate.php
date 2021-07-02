<?php

namespace App\Http\Middleware;

use App\Services\User\Features\LoginUserFeature;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;
use Lucid\Bus\ServesFeatures;
use Vizir\KeycloakWebGuard\Facades\KeycloakWeb;

class Authenticate extends Middleware
{
    use ServesFeatures;
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return '/login';
        }
    }
    
    
    /**
     * Determine if the user is logged in to any of the given guards.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $guards
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function authenticate($request, array $guards)
    {
       
        if (empty($guards)) {
            $guards = [null];
        }
        
        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                return $this->auth->shouldUse($guard);
            }
        }
        
        if(is_array($guards))
        {
            if(in_array('web', $guards) && !in_array('keycloak', $guards) && Auth::guard('keycloak')->check())
            {
    
                $token = KeycloakWeb::retrieveToken();
                $keycloakProfile = KeycloakWeb::getUserProfile($token);
                $this->serve(LoginUserFeature::class, [
                    'keycloakId' => $keycloakProfile['sub'],
                    'keycloakProfile' => $keycloakProfile
                ]);
                return $this->auth->shouldUse('web');
            }
        }
        $this->unauthenticated($request, $guards);
    }
    
}
