<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;
use Illuminate\Support\Str;
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

        if(count($values) === 0) {
            $values = static::toArray();
        }

        foreach ($values as $value => $label) {
            $array[] = ['value' => $value, 'label' => Str::studly($label)
        ];
        }

        return $array;
    }
}
