<?php

namespace App\Models;

use App\Data\HasCompany;
use App\Data\HasUserActions;
use App\Frame\ModelFrame;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed tax_id
 * @property mixed tax
 */
class DocumentItemTax extends ModelFrame
{
    use HasFactory;
    use SoftDeletes;
    use HasCompany;
    use HasUserActions;

    protected $fillable = ['company_id',  'document_id', 'document_item_id', 'tax_id', 'name', 'amount'];

    public function document() : BelongsTo
    {
        return $this->belongsTo(Document::class);
    }

    public function item()
    {
        return $this->hasOneThrough(Item::class, DocumentItem::class, 'document_item_id');
    }

    public function tax() : BelongsTo
    {
        return $this->belongsTo(Tax::class);
    }
}
