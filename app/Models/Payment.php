<?php

namespace App\Models;

use App\Data\CanBeEnabled;
use App\Data\HasCompany;
use App\Data\HasUserActions;
use App\Enums\PaymentTypeEnum;
use App\Frame\ModelFrame;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends ModelFrame
{
    use HasFactory;
    use SoftDeletes;
    use HasCompany;
    use HasUserActions;
    use CanBeEnabled;

    protected $guarded = [];

    protected $casts = [
        'type' => PaymentTypeEnum::class
    ];

    public function paymentMethod() : BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function document() : BelongsTo
    {
        return $this->belongsTo(Document::class);
    }
}
