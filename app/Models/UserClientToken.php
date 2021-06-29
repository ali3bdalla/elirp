<?php

namespace App\Models;

use App\Data\CanBeEnabled;
use App\Data\HasCompany;
use App\Data\HasUserActions;
use App\Frame\ModelFrame;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserClientToken extends ModelFrame
{
    use HasFactory;
    use SoftDeletes;
    use HasUserActions;
    use CanBeEnabled;

    protected $guarded = [];
}
