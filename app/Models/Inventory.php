<?php

namespace App\Models;

use App\Data\CanBeEnabled;
use App\Data\HasCompany;
use App\Data\HasUserActions;
use App\Events\Inventory\InventoryCreatedEvent;
use App\Frame\ModelFrame;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends ModelFrame
{
    protected $dispatchesEvents = [
        'created' => InventoryCreatedEvent::class,
    ];

    use HasCompany;
    use HasFactory;
    use SoftDeletes;
    use HasCompany;
    use HasUserActions;
    use CanBeEnabled;

    protected $fillable = [
        'company_id',
        'account_id',
        'name',
        'description',
        'address',
        'enabled'
    ];

    public function account() : BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
