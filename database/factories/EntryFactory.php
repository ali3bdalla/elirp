<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Entry;
use Illuminate\Database\Eloquent\Factories\Factory;

class EntryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Entry::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'amount' => 0,
            'company_id' => null,
            'document_id' => null,
            'reference' => $this->faker->uuid,
            'description' => $this->faker->sentence,
            'enabled' => true,
            'is_pending' => false
        ];
    }
    public function configure(): EntryFactory
    {
        return $this->afterMaking(function (Entry $entry) {
            if (!$entry->company_id) {
                $entry->company_id = Company::factory()->create()->id;
            }
            return $entry;
        });
    }
    
}
