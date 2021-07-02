<?php

namespace App\Data;

use App\Models\Company;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

trait HasCompany
{
    public static function bootHasCompany()
    {
        if (Auth::user()) {
            // static::addGlobalScope(function(Builder $builder){
            //     if(Schema::hasColumn($builder->getModel()->getTable(),'company_id'))
            //         return $builder->where($builder->qualifyColumn('company_id'),company_id());

            //     return $builder;
            // });
        }
    }

    public function company() : BelongsTo
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
