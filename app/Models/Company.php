<?php

namespace App\Models;

use App\Data\CanBeEnabled;
use App\Data\HasFullSearch;
use App\Data\HasUserActions;
use App\Frame\ModelFrame;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed id
 */
class Company extends ModelFrame
{
    use HasFactory;
    use HasUserActions;
    use SoftDeletes;
    use CanBeEnabled;
    use HasFullSearch;
    protected $fillable = [
        'domain',
        'enabled',
        'locale'
    ];

    public function items() : HasMany
    {
        return $this->hasMany(Item::class, 'company_id');
    }

    public function contacts() : HasMany
    {
        return $this->hasMany(Contact::class, 'company_id');
    }

    public function users() : HasMany
    {
        return $this->hasMany(User::class, 'company_id');
    }

    public function accounts() : HasMany
    {
        return $this->hasMany(Account::class, 'company_id');
    }

    public function transactions() : HasMany
    {
        return $this->hasMany(Transaction::class, 'company_id');
    }

    public function entries() : HasMany
    {
        return $this->hasMany(Entry::class, 'company_id');
    }

    public function taxes() : HasMany
    {
        return $this->hasMany(Tax::class, 'company_id');
    }

    public function currencies() : HasMany
    {
        return $this->hasMany(Currency::class, 'company_id');
    }

    public function userActions() : HasMany
    {
        return $this->hasMany(UserAction::class, 'company_id');
    }

    public function documents() : HasMany
    {
        return $this->hasMany(Document::class, 'company_id');
    }

    public function inventories() : HasMany
    {
        return $this->hasMany(Inventory::class, 'company_id');
    }

    public function inventoryTransactions() : HasMany
    {
        return $this->hasMany(InventoryTransaction::class, 'company_id');
    }
}
