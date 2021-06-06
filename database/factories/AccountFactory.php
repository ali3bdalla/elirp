<?php

namespace Database\Factories;

use App\Data\CanBeEnabled;
use App\Data\HasCompany;
use App\Enums\AccountGroupEnum;
use App\Enums\AccountingTypeEnum;
use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountFactory extends Factory
{
    use HasCompany,CanBeEnabled;
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Account::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_id'  => null,
            'name'        => $this->faker->text(15),
            'number'      => (string)$this->faker->iban(),
            'type'        => $this->faker->randomElement(AccountingTypeEnum::toValues()),
            'group'       => $this->faker->randomElement(AccountGroupEnum::toValues()),
            'attribute_1' => $this->faker->text(15),
            'attribute_2' => $this->faker->phoneNumber,
            'attribute_3' => $this->faker->address,
            'enabled'     => $this->faker->boolean ? 1 : 0,
        ];
    }
}
