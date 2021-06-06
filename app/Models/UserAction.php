<?php

namespace App\Models;

use App\Data\HasCompany;
use App\Frame\ModelFrame;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAction extends ModelFrame
{
    use HasFactory;
    use SoftDeletes;
    use HasCompany;

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function actionable() : MorphTo
    {
        return $this->morphTo('actionable');
    }
}
