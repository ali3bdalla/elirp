<?php

    namespace App\Services\User\Features;

    use App\Domains\User\Jobs\CreateUserClientTokenJob;
    use App\Domains\User\Jobs\GetUserByEmailJob;
    use App\Services\Company\Features\CreateCompanyFeature;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Str;
    use Laravel\Socialite\Two\User as SocialiteUser;
    use Lucid\Units\Feature;

class LoginUserFeature extends Feature
{
    private SocialiteUser $user;
    private string $driver;

    public function __construct(SocialiteUser $user, string $driver)
    {
        $this->user  =$user;
        $this->driver=$driver;
    }

    public function handle(Request $request)
    {
        $keycloakId   =$this->user->getId();
        $authUser=$this->run(GetUserByEmailJob::class, ['keycloakId'=>$keycloakId]);
        if (! $authUser) {
            $authUser=$this->run(CreateCompanyFeature::class, ['request'=>[
                'keycloakId' => $this->user->getId(),
                'name'=>$this->user->getName(), 'email'=>$this->user->getEmail(), 'password'=>Str::random(20)]]);
        }
        $authUser->update(
            [
            'email_verified_at' => now()
                ]
        );
        Auth::login($authUser);
        $this->run(CreateUserClientTokenJob::class, ['user'=>$authUser, 'expiresIn'=>$this->user->expiresIn, 'token'=>$this->user->token, 'name'=>$this->user->getName(), 'email'=>$this->user->getEmail(), 'id'=>$this->user->getId(), 'avatar'=>$this->user->getAvatar(), 'nickname'=>$this->user->getNickname(), ]);
        return redirect(route('dashboard'));
    }
}
