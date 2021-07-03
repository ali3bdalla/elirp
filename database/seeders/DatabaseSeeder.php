<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Contact;
use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $companies = Company::get();
        foreach($companies as $company) {
            User::factory(['company_id' =>   $company->id])->count(10)->create();
            Item::factory(['company_id' => $company->id])->count(10)->create();
            Contact::factory(['company_id' => $company->id])->count(10)->create();
            // dd(Company::factory()->disabledFactoryState()->create());
            // \App\Models\User::factory(10)->create();
        }
      
    }
}
