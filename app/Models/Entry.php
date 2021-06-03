<?php

namespace App\Models;

use App\Data\CanBeEnabled;
use App\Data\HasCompany;
use App\Data\HasUserActions;
use App\Frame\ModelFrame;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\HigherOrderCollectionProxy;

/**
 * @property HigherOrderCollectionProxy|mixed company_id
 */
class Entry extends ModelFrame
{
    use HasFactory;
    use SoftDeletes;
    use HasCompany;
    use HasUserActions;
    use CanBeEnabled;
}
