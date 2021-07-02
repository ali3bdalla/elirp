<?php

namespace App\Models;

use App\Data\CanBeEnabled;
use App\Data\HasCompany;
use App\Data\HasUserActions;
use App\Events\PaymentMethod\PaymentMethodCreatedEvent;
use App\Frame\ModelFrame;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentMethod extends ModelFrame
{
    use HasFactory;
    use SoftDeletes;
    use HasCompany;
    use HasUserActions;
    use CanBeEnabled;
    protected $dispatchesEvents = [
        'created' => PaymentMethodCreatedEvent::class,
    ];

    protected $guarded = [];

    public function account() : BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
