<?php

    namespace App\Services\User\Features;

    use App\Domains\User\Jobs\CreateUserClientTokenJob;
    use App\Domains\User\Jobs\GetUserByEmailJob;
    use App\Services\Company\Features\CreateCompanyFeature;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Str;
    use Lucid\Units\Feature;

class LoginUserFeature extends Feature
{
    private $keycloakId;
    private $keycloakProfile;

    public function __construct($keycloakId, $keycloakProfile = [])
    {
        $this->keycloakId     =$keycloakId;
        $this->keycloakProfile=collect($keycloakProfile);
    }

    public function handle(Request $request)
    {
        $authUser=$this->run(GetUserByEmailJob::class, ['keycloakId'=>$this->keycloakId]);
        if (! $authUser) {
            $authUser=$this->run(CreateCompanyFeature::class, ['request'=> [
                'keycloakId' => $this->keycloakId,
                'name'       => $this->keycloakProfile->get('name'), 'email'=>$this->keycloakProfile->get('password'), 'password'=>Str::random(20)]]);
        }
        $authUser->update(
            [
                'keycloak_id'       => $this->keycloakId,
                'name'              => $this->keycloakProfile->get('name'),
                'email'             => $this->keycloakProfile->get('email'),
                'email_verified_at' => now()
            ]
        );
        Auth::guard('web')->login($authUser);
//        $this->run(CreateUserClientTokenJob::class, ['user'=>$authUser, 'expiresIn'=>$this->user->expiresIn, 'token'=>$this->user->token, 'name'=>$this->user->getName(), 'email'=>$this->user->getEmail(), 'id'=>$this->user->getId(), 'avatar'=>$this->user->getAvatar(), 'nickname'=>$this->user->getNickname(), ]);
        return redirect(route('dashboard'));
    }
}
