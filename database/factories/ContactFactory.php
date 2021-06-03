<?php

namespace Database\Factories;

use App\Data\CanBeEnabled;
use App\Data\HasCompany;
use App\Models\Company;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    use HasCompany,CanBeEnabled;
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contact::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_id' => null,
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'tax_number' => $this->faker->randomNumber(9),
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'website' => $this->faker->freeEmailDomain,
            'currency_code' => $this->faker->currencyCode,
            'reference' => $this->faker->text(5),
            'enabled' => $this->faker->boolean ? 1 : 0,
            'is_vendor' => $this->faker->boolean,
            'is_customer' => $this->faker->boolean,
        ];
    }
    
    /**
     * Indicate that the model type is customer.
     *
     * @return Factory
     */
    public function customer(): Factory
    {
        return $this->state([
            'is_customer' => true,
        ]);
    }
    
    /**
     * Indicate that the model type is vendor.
     *
     * @return Factory
     */
    public function vendor(): Factory
    {
        return $this->state([
            'is_vendor' => true,
        ]);
    }
    
    public function configure(): ContactFactory
    {
        return $this->afterMaking(function (Contact $contact) {
            if (!$contact->company_id) {
                $contact->company_id = Company::factory()->create()->id;
            }
            return $contact;
        })->afterCreating(function (Contact $contact) {
        });
    }
    
}
