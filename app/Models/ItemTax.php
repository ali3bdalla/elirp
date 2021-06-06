<?php

namespace App\Models;

use App\Data\CanBeEnabled;
use App\Data\HasCompany;
use App\Data\HasUserActions;
use App\Frame\ModelFrame;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemTax extends ModelFrame
{
    use HasFactory;
    use SoftDeletes;
    use HasCompany;
    use HasUserActions;
    use CanBeEnabled;

    protected $fillable = ['company_id', 'item_id', 'tax_id'];

    public function item() : BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function tax() : BelongsTo
    {
        return $this->belongsTo(Tax::class);
    }
}
