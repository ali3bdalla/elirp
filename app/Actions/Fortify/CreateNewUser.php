<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Services\Company\Features\CreateCompanyFeature;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Lucid\Bus\ServesFeatures;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules,ServesFeatures;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms'    => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();
        return $this->serve(CreateCompanyFeature::class, [
            'request' => $input
        ]);
    }
}
