<?php

namespace App\Models;

use App\Data\CanBeEnabled;
use App\Data\HasCompany;
use App\Data\HasFullSearch;
use App\Data\HasUserActions;
use App\Frame\ModelFrame;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

/**
 * @property mixed company_id
 */
class Contact extends ModelFrame
{
    use HasFullSearch;
    use HasFactory;
    use SoftDeletes;
    use HasCompany;
    use HasUserActions;
    use CanBeEnabled;
    use Notifiable;
    protected $guarded = [];

    public function preferredNotificationChannel() : string
    {
        return 'mail';
    }

    /**
     * Route notifications for the mail channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return array|string
     */
    public function routeNotificationForMail($notification)
    {
        // Return email address only...
//        return "ali.dev.sd@gmail.com";
//        return $this->email_address;

        // Return email address and name...
        return [$this->email => $this->name];
    }
}
