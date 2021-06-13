<?php

namespace App\Data;

use App\Models\UserAction;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Trait HasUserActions.
 * @package App\Data
 */
trait HasUserActions
{
    public function userActions() : MorphMany
    {
        return $this->morphMany(UserAction::class, 'actionable');
    }
}
