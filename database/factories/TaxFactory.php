<?php

namespace Database\Factories;

use App\Data\CanBeEnabled;
use App\Data\HasCompany;
use App\Enums\TaxTypeEnum;
use App\Models\Company;
use App\Models\Tax;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaxFactory extends Factory
{
    use HasCompany,CanBeEnabled;
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tax::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_id' => null,
            'name'       => $this->faker->text(15),
            'rate'       => $this->faker->randomFloat(2, 10, 20),
            'type'       => $this->faker->randomElement(TaxTypeEnum::toValues()),
            'enabled'    => $this->faker->boolean ? 1 : 0,
        ];
    }

    public function configure() : TaxFactory
    {
        return $this->afterMaking(function (Tax $tax) {
            if (! $tax->company_id) {
                $tax->company_id = Company::factory()->create()->id;
            }
            return $tax;
        })->afterCreating(function (Tax $tax) {
        });
    }

    public function fixed()
    {
        return $this->state(function (array $attributes) {
            return [];
        });
    }
}
