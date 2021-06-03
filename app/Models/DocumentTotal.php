<?php

namespace App\Models;

use App\Data\HasCompany;
use App\Data\HasUserActions;
use App\Frame\ModelFrame;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentTotal extends ModelFrame
{
    use HasFactory;
    use SoftDeletes;
    use HasCompany;
    use HasUserActions;
    protected $fillable = ['company_id', 'type', 'document_id', 'code', 'name', 'amount', 'sort_order'];
    
    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }
}
