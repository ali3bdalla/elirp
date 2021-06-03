<?php

namespace App\Models;

use App\Data\CanBeEnabled;
use App\Data\HasCompany;
use App\Data\HasUserActions;
use App\Events\Tax\TaxCreatedEvent;
use App\Frame\ModelFrame;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\HigherOrderCollectionProxy;

/**
 * @property HigherOrderCollectionProxy|mixed company_id
 * @property mixed name
 * @method static find(int|string $taxId)
 */
class Tax extends ModelFrame
{
    use HasFactory;
    use SoftDeletes;
    use HasCompany;
    use HasUserActions;
    use CanBeEnabled;
    
    protected $dispatchesEvents = [
        'created' => TaxCreatedEvent::class,
    ];
    
    protected $fillable = ['company_id', 'name', 'rate', 'type', 'enabled', 'account_id'];
    
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
    
    public function items(): HasMany
    {
        return $this->hasMany(ItemTax::class, 'tax_id');
    }
}
