<?php

    namespace App\Models;

    use App\Data\CanBeEnabled;
    use App\Data\HasCompany;
    use App\Data\HasUserActions;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Relations\HasMany;
    use Illuminate\Database\Eloquent\SoftDeletes;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;
    use Laravel\Fortify\TwoFactorAuthenticatable;
    use Laravel\Jetstream\HasProfilePhoto;
    use Laravel\Sanctum\HasApiTokens;

    class User extends Authenticatable
    {
        use HasApiTokens;
        use HasFactory;
        use SoftDeletes;
        use HasCompany;
        use HasUserActions;
        use HasProfilePhoto;
        use Notifiable;
        use TwoFactorAuthenticatable;
        use CanBeEnabled;

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable=['name', 'email', 'password', 'enabled', 'company_id', 'locale'];

        /**
         * The attributes that should be hidden for arrays.
         *
         * @var array
         */
        protected $hidden=['password', 'remember_token', 'two_factor_recovery_codes', 'two_factor_secret',];

        /**
         * The attributes that should be cast to native types.
         *
         * @var array
         */
        protected $casts=['email_verified_at'=>'datetime',];

        /**
         * The accessors to append to the model's array form.
         *
         * @var array
         */
        protected $appends=['profile_photo_url',];

        /**
         * Get the user's preferred locale.
         *
         * @return string
         */
        public function preferredLocale(): string
        {
            return $this->locale;
        }

        public function userClientToken(): HasMany
        {
            return $this->hasMany(UserClientToken::class, 'user_id');
        }

         public function actions(): HasMany
        {
            return $this->hasMany(UserAction::class, 'user_id');
        }
    }
