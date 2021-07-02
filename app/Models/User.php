<?php

namespace App\Models;

use App\Data\CanBeEnabled;
use App\Data\HasCompany;
use App\Data\HasFullSearch;
use App\Data\HasProfilePhoto;
use App\Data\HasUserActions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

/**
 * @property mixed profile_photo_path
 */
class User extends Authenticatable
{
    use HasFullSearch;
    use HasFactory;
    use SoftDeletes;
    use HasCompany;
    use HasUserActions;
    use Notifiable;
    use CanBeEnabled;
    use HasProfilePhoto;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'enabled', 'company_id', 'locale'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token', 'two_factor_recovery_codes', 'two_factor_secret', ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['email_verified_at' => 'datetime', ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['profile_photo_url', ];

    /**
     * Get the user's preferred locale.
     *
     * @return string
     */
    public function preferredLocale() : string
    {
        return $this->locale;
    }

    public function userClientToken() : HasMany
    {
        return $this->hasMany(UserClientToken::class, 'user_id');
    }

    public function actions() : HasMany
    {
        return $this->hasMany(UserAction::class, 'user_id');
    }
    public function getProfilePhotoUrlAttribute()
    {
        
        $path = $this->profile_photo_path;
        
        if (Storage::exists($path)){
            return Storage::url($this->profile_photo_path);
        }
        elseif (!empty($path)){
            // Use Photo URL from Social sites link...
            return $path;
        }
        else {
            //empty path. Use defaultProfilePhotoUrl
            return $this->defaultProfilePhotoUrl();
        }
    }
}
