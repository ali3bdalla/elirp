<?php

namespace App\Data;

use App\Models\Company;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Scout\Searchable;
use Illuminate\Support\Str;

trait HasCompany
{
    use Searchable;

    public function searchableAs()
    {
        return Str::plural(Str::lower(class_basename($this))) . '_index';
    }

    public function company(): BelongsTo
    {
        return $this->BelongsTo(Company::class, 'company_id');
    }

    public function withCompanyFactoryState()
    {
        return $this->state(function (array $attributes) {
            $company =  Company::factory()->create();
            return [
                'company_id' => $company->id,
            ];
        });
    }
}
