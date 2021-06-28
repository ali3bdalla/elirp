<?php

namespace App\Data;

use Illuminate\Support\Str;
use Laravel\Scout\Searchable;

trait HasFullSearch
{
    use Searchable;

    public function searchableAs()
    {
        return Str::plural(Str::lower(Str::snake(class_basename($this)))).'_index';
    }
}
