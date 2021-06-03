<?php

namespace Database\Factories;

use App\Data\CanBeEnabled;
use App\Data\HasCompany;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    use CanBeEnabled;
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'locale' => $this->faker->locale,
            'domain' => $this->faker->freeEmailDomain,
            'enabled' => $this->faker->boolean
        ];
    }
}
