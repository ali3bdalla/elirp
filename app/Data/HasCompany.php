<?php

namespace App\Data;

use App\Models\Company;

trait HasCompany
{
    public function company()
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
