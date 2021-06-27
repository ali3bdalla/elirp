<?php

namespace App\Models;

use App\Data\CanBeEnabled;
use App\Data\HasCompany;
use App\Data\HasFullSearch;
use App\Data\HasUserActions;
use App\Enums\AccountSlugsEnum;
use App\Frame\ModelFrame;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\HigherOrderCollectionProxy;

/**
 * @property mixed parent_id
 * @property AccountGroupEnum|mixed group
 * @property bool|mixed auto_generated
 * @property mixed name
 * @property HigherOrderCollectionProxy|mixed company_id
 * @property mixed type
 * @property mixed id
 * @method static find($account_id)
 */
class Account extends ModelFrame
{
    use HasFullSearch;
    use HasFactory;
    use SoftDeletes;
    use HasCompany;
    use HasUserActions;
    use CanBeEnabled;

    protected $fillable = ['company_id', 'name', 'number', 'enabled', 'attribute_1', 'attribute_2', 'attribute_3', 'group', 'type', 'auto_generated', 'slug', 'parent_id'];

    public static function default(AccountSlugsEnum $enum)
    {
        return (new static)->where('slug', $enum)->first();
    }

    public function tax(): HasOne
    {
        return $this->hasOne(Tax::class, 'account_id');
    }
    public function snapshots(): HasMany
    {
        return $this->hasMany(AccountSnapshot::class);
    }
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Account::class, 'parent_id');
    }
}
