<?php

namespace App\Data;

use Laravel\Scout\Searchable;
use Illuminate\Support\Str;

trait HasFullSearch
{
	use Searchable;

	public function searchableAs()
	{
		return Str::plural(Str::lower(Str::snake(class_basename($this)))) . '_index';
	}
}
