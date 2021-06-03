<?php

namespace App\Models;

use App\Data\CanBeEnabled;
use App\Data\HasCompany;
use App\Data\HasUserActions;
use App\Frame\ModelFrame;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property \Illuminate\Support\HigherOrderCollectionProxy|mixed company_id
 */
class Tax extends ModelFrame
{
    use HasFactory;
    use SoftDeletes;
    use HasCompany;
    use HasUserActions;
    use CanBeEnabled;
}
