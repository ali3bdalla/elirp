<?php

namespace App\Models;

use App\Data\HasCompany;
use App\Data\HasUserActions;
use App\Frame\ModelFrame;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\HigherOrderCollectionProxy;

/**
 * @property HigherOrderCollectionProxy|mixed company_id
 * @property HigherOrderCollectionProxy|mixed document_id
 * @property string type
 * @property float discount_rate
 * @property float total
 * @property mixed taxes()
 * @property mixed id
 * @property mixed quantity
 * @property mixed tax
 */
class DocumentItem extends ModelFrame
{
    use HasFactory;
    use SoftDeletes;
    use HasCompany;
    use HasUserActions;
    
    protected $fillable = [
        'company_id',
        'type',
        'document_id',
        'item_id',
        'name',
        'description',
        'quantity',
        'price',
        'total',
        'subtotal',
        'tax',
        'discount_rate',
        'discount_type',
    ];
    
    public function taxes(): HasMany
    {
        return $this->hasMany(DocumentItemTax::class, 'document_item_id');
    }
}
