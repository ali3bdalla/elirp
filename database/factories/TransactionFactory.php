<?php

namespace Database\Factories;

use App\Data\HasCompany;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    use HasCompany;
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_id'    => null,
            'type'          => null,
            'account_id'    => null,
            'paid_at'       => $this->faker->dateTimeBetween(now()->startOfYear(), now()->endOfYear())->format('Y-m-d H:i:s'),
            'amount'        => $this->faker->randomFloat(2, 1, 1000),
            'currency_code' => 'usd',
            'currency_rate' => '1.0',
            'description'   => $this->faker->text(5),
        ];
    }
}
