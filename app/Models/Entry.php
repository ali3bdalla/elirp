<?php

namespace App\Models;

use App\Data\CanBeEnabled;
use App\Data\HasCompany;
use App\Data\HasUserActions;
use App\Frame\ModelFrame;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\HigherOrderCollectionProxy;

/**
 * @property HigherOrderCollectionProxy|integer company_id
 * @property boolean is_pending
 * @property integer id
 * @property float amount
 */
class Entry extends ModelFrame
{
    use HasFactory;
    use SoftDeletes;
    use HasCompany;
    use HasUserActions;
    use CanBeEnabled;

    protected $fillable = ['company_id', 'amount', 'document_id', 'description', 'is_pending'];

    public function transactions() : HasMany
    {
        return $this->hasMany(Transaction::class, 'entry_id');
    }
}
