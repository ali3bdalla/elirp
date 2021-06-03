<?php

namespace Database\Factories;

use App\Data\CanBeEnabled;
use App\Data\HasCompany;
use App\Models\ItemTax;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemTaxFactory extends Factory
{
    use HasCompany,CanBeEnabled;
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ItemTax::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
        ];
    }
}
