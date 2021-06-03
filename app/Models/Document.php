<?php

namespace App\Models;

use App\Data\CanBeEnabled;
use App\Data\HasCompany;
use App\Data\HasUserActions;
use App\Frame\ModelFrame;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property \Illuminate\Support\HigherOrderCollectionProxy|mixed company_id
 * @property mixed contact_address
 * @property mixed contact_phone
 * @property mixed contact_email
 * @property mixed contact_name
 * @property mixed document_number
 * @property mixed contact_id
 * @property DocumentTypeEnum|mixed type
 * @property mixed footer
 * @property mixed notes
 * @property null|integer|mixed parent_id
 * @property mixed amount
 * @property mixed issued_at
 * @property mixed due_at
 * @property mixed status
 * @property mixed currency_code
 * @property mixed currency_rate
 * @property integer id
 */
class Document extends ModelFrame
{
    use HasFactory;
    use SoftDeletes;
    use HasCompany;
    use HasUserActions;
    use CanBeEnabled;
    protected $fillable = [
        'company_id',
        'type',
        'document_number',
        'order_number',
        'status',
        'issued_at',
        'due_at',
        'amount',
        'currency_code',
        'currency_rate',
        'contact_id',
        'contact_name',
        'contact_email',
        'contact_tax_number',
        'contact_phone',
        'contact_address',
        'notes',
        'category_id',
        'parent_id',
        'footer',
    ];
    public function itemsTaxes(): HasMany
    {
        return $this->hasMany(DocumentItemTax::class, 'document_id');
    }
    public function items(): HasMany
    {
        return $this->hasMany(DocumentItem::class, 'document_id');
    }
    
    
}
