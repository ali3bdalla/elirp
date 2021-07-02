<?php

namespace App\Enums;

use Illuminate\Support\Str;
use Spatie\Enum\Laravel\Enum;

/**
 * Trait ResolvesAsOptions.
 *
 * @package App\Support\Enums
 *
 * @mixin Enum
 */
trait ResolvesAsOptions
{
    public static function toOptions($values = [])
    {
        $array = [];

        if (count($values) === 0) {
            $values = static::toArray();
        }

        foreach ($values as $value => $label) {
            $array[] = ['value' => $value, 'label' => Str::studly($label)
            ];
        }

        return $array;
    }
}
