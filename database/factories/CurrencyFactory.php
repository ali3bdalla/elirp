<?php

namespace Database\Factories;

use App\Data\CanBeEnabled;
use App\Data\HasCompany;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;

class CurrencyFactory extends Factory
{
    use CanBeEnabled,HasCompany
        ;
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Currency::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_id' => null,
            'name' => $this->faker->currencyCode,
            'code' => '',
            'rate' => 1,
            'precision' =>  2,
            'symbol' => "$",
            'symbol_first' => 1,
            'decimal_mark' =>  '.',
            'thousands_separator' => '.',
            'enabled' => $this->faker->boolean,
        ];
    }
    public function configure()
    {
        return $this->afterMaking(function (Currency $currency) {
            if (!$currency->company_id) {
                $currency->company_id = Company::factory()->create()->id;
            }
            return $currency;
        })->afterCreating(function (Currency $currency) {
        });
    }
}
