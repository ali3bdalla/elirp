<?php

namespace App\Models;

use App\Data\HasUserActions;
use App\Frame\ModelFrame;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
class Company extends ModelFrame
{
    use HasFactory;
    use HasUserActions;
    use SoftDeletes;
}
