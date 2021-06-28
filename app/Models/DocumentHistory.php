<?php

namespace App\Models;

use App\Data\HasCompany;
use App\Data\HasUserActions;
use App\Frame\ModelFrame;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentHistory extends ModelFrame
{
    use HasFactory;
    use SoftDeletes;
    use HasCompany;
    use HasUserActions;
    protected $casts = [
        'created_at' => 'datetime:Y-m-d'
    ];

    protected $fillable = [
        'document_id',
        'company_id',
        'status',
        'notified',
        'views',
        'description',
    ];
}
