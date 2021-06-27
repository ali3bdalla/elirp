<?php

namespace App\Data;

use App\Models\Company;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


trait HasCompany
{


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
