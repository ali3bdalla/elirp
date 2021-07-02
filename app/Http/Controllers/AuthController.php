<?php

namespace App\Http\Controllers;

use App\Services\User\Features\LoginUserFeature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Lucid\Bus\ServesFeatures;
use Vizir\KeycloakWebGuard\Controllers\AuthController as BasKeycloakAuthController;
use Vizir\KeycloakWebGuard\Exceptions\KeycloakCallbackException;
//use Laravel\Socialite\Facades\Socialite;
use Vizir\KeycloakWebGuard\Facades\KeycloakWeb;

class AuthController extends BasKeycloakAuthController
{
    use ServesFeatures;

    /**
     * Keycloak callback page.
     *
     * @throws KeycloakCallbackException
     *
     */
    public function callback(Request $request)
    {
        // Check for errors from Keycloak
        if (! empty($request->input('error'))) {
            $error = $request->input('error_description');
            $error = ($error) ?: $request->input('error');

            throw new KeycloakCallbackException($error);
        }
        $state = $request->input('state');
        if (empty($state) || ! KeycloakWeb::validateState($state)) {
            KeycloakWeb::forgetState();

            throw new KeycloakCallbackException('Invalid state');
        }

        // Change code for token
        $code = $request->input('code');
        if (! empty($code)) {
            $token = KeycloakWeb::getAccessToken($code);
            if (Auth::validate($token)) {
                $profileInfo = KeycloakWeb::getUserProfile($token);
                $this->serve(LoginUserFeature::class, [
                    'keycloakId'      => $profileInfo['sub'],
                    'keycloakProfile' => $profileInfo
                ]);
                $url = config('keycloak-web.redirect_url', '/admin');
                return redirect()->intended($url);
            }
        }

        return redirect(route('keycloak.login'));
    }
}
