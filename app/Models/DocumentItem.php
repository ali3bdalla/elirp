<?php

namespace App\Models;

use App\Data\HasCompany;
use App\Data\HasUserActions;
use App\Frame\ModelFrame;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property \Illuminate\Support\HigherOrderCollectionProxy|mixed company_id
 * @property \Illuminate\Support\HigherOrderCollectionProxy|mixed document_id
 */
class DocumentItem extends ModelFrame
{
    use HasFactory;
    use SoftDeletes;
    use HasCompany;
    use HasUserActions;
}
