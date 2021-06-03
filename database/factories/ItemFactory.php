<?php

namespace Database\Factories;

use App\Data\CanBeEnabled;
use App\Data\HasCompany;
use App\Models\Company;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    use HasCompany,CanBeEnabled;
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Item::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'company_id' => null,
            'name' => $this->faker->text(85),
            'description' => $this->faker->text(100),
            'purchase_price' => $this->faker->randomFloat(2, 10, 20),
            'sale_price' => $this->faker->randomFloat(2, 10, 20),
            'enabled' => $this->faker->boolean ? 1 : 0,
            'fixed_price' => $this->faker->boolean,
            'is_service' => $this->faker->boolean,
            'has_detail' => $this->faker->boolean,
        ];
    }
    
    public function configure()
    {
        return $this->afterMaking(function (Item $item) {
            if (!$item->company_id) {
                $item->company_id = Company::factory()->create()->id;
            }
            return $item;
        })->afterCreating(function (Item $item) {
        });
    }
}
