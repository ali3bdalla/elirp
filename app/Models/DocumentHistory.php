<?php

namespace App\Models;

use App\Data\HasCompany;
use App\Enums\DocumentStatusEnum;
use App\Enums\DocumentTypeEnum;
use App\Frame\ModelFrame;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentHistory extends ModelFrame
{
    use HasFactory;
    use SoftDeletes;
    use HasCompany;

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
        'type'       => DocumentTypeEnum::class.':nullable',
        'status'     => DocumentStatusEnum::class.':nullable',
    ];

    protected $fillable = [
        'document_id',
        'company_id',
        'status',
        'notified',
        'views',
        'description',
        'created_by_id'
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class);
    }
}
