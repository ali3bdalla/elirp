<?php

namespace App\Frame;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class ModelFrame extends Model
{
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->toDayDateTimeString();
    }
}
