<?php


namespace App\Data;


use App\Models\Company;

trait HasCompany
{
    public function company()
    {
        return $this->belongTo(Company::class,'company_id');
    }
}
