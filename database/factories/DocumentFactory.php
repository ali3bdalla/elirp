<?php

namespace Database\Factories;

use App\Data\CanBeEnabled;
use App\Data\HasCompany;
use App\Enums\DocumentTypeEnum;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Document;
use App\Models\Item;
use App\Models\Tax;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class DocumentFactory extends Factory
{
    use HasCompany,CanBeEnabled;
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Document::class;
    
    
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $issued_at = $this->faker->dateTimeBetween(now()->startOfYear(), now()->endOfYear())->format('Y-m-d H:i:s');
        $due_at = Carbon::parse($issued_at)->addDays($this->faker->randomNumber(3))->format('Y-m-d H:i:s');
        
        return [
            'company_id' => null,
            'issued_at' => $issued_at,
            'due_at' => $due_at,
            'type' => $this->faker->randomElement(DocumentTypeEnum::toValues()),
            'currency_code' => 'usd',
            'currency_rate' => '1',
            'notes' => $this->faker->text(5),
            'amount' => '0',
        ];
    }
    
    /**
     * Indicate that the model type is invoice.
     */
    public function invoice(): Factory
    {
        return $this->state(function (array $attributes): array{
            $contact = Contact::factory()->customer()->create([
                'company_id' => $attributes['company_id'],
            ]);
            $statuses = ['draft', 'sent', 'viewed', 'partial', 'paid', 'cancelled'];
            return [
                'type' => DocumentTypeEnum::invoice(),
                'document_number' => 'next',
                'contact_id' => $contact->id,
                'contact_name' => $contact->name,
                'contact_email' => $contact->email,
                'contact_tax_number' => $contact->tax_number,
                'contact_phone' => $contact->phone,
                'contact_address' => $contact->address,
                'status' => $this->faker->randomElement($statuses),
            ];
        });
    }
    
    /**
     * Indicate that the model type is bill.
     */
    public function bill(): Factory
    {
        return $this->state(function (array $attributes): array{
            $contact = Contact::factory()->vendor()->create([
                'company_id' => $attributes['company_id'],
            ]);
            $statuses = ['draft', 'received', 'partial', 'paid', 'cancelled'];
            
            return [
                'type' => DocumentTypeEnum::bill(),
                'document_number' =>  $this->faker->randomNumber(),
                'contact_id' => $contact->id,
                'contact_name' => $contact->name,
                'contact_email' => $contact->email,
                'contact_tax_number' => $contact->tax_number,
                'contact_phone' => $contact->phone,
                'contact_address' => $contact->address,
                'status' => $this->faker->randomElement($statuses),
            ];
        });
    }
    
    /**
     * Indicate that the model status is draft.
     *
     * @return Factory
     */
    public function draft(): Factory
    {
        return $this->state([
            'status' => 'draft',
        ]);
    }
    
    /**
     * Indicate that the model status is received.
     *
     * @return Factory
     */
    public function received(): Factory
    {
        return $this->state([
            'status' => 'received',
        ]);
    }
    
    /**
     * Indicate that the model status is sent.
     *
     * @return Factory
     */
    public function sent(): Factory
    {
        return $this->state([
            'status' => 'sent',
        ]);
    }
    
    /**
     * Indicate that the model status is viewed.
     *
     * @return Factory
     */
    public function viewed(): Factory
    {
        return $this->state([
            'status' => 'viewed',
        ]);
    }
    
    /**
     * Indicate that the model status is partial.
     *
     * @return Factory
     */
    public function partial(): Factory
    {
        return $this->state([
            'status' => 'partial',
        ]);
    }
    
    /**
     * Indicate that the model status is paid.
     *
     * @return Factory
     */
    public function paid(): Factory
    {
        return $this->state([
            'status' => 'paid',
        ]);
    }
    
    /**
     * Indicate that the model status is cancelled.
     *
     * @return Factory
     */
    public function cancelled(): Factory
    {
        return $this->state([
            'status' => 'cancelled',
        ]);
    }
    
    /**
     * Indicate that the model is recurring.
     *
     * @return Factory
     */
    public function recurring(): Factory
    {
        return $this->state([
            'recurring_frequency' => 'yes',
            'recurring_interval' => '1',
            'recurring_custom_frequency' => $this->faker->randomElement(['monthly', 'weekly']),
            'recurring_count' => '1',
        ]);
    }
    
    /**
     * Indicate that the model has items.
     *
     * @return Factory
     */
    public function items(): Factory
    {
        return $this->state(function (array $attributes) {
            $amount = $this->faker->randomFloat(2, 1, 1000);
            
            $taxes = Tax::enabled()->get();
            
            if ($taxes->count()) {
                $tax = $taxes->random(1)->first();
            } else {
                $tax = Tax::factory()->enabledFactoryState()->create();
            }
            
            $items = Item::enabled()->get();
            
            if ($items->count()) {
                $item = $items->random(1)->first();
            } else {
                $item = Item::factory()->enabledFactoryState()->create();
            }
            
            $items = [
                [
                    'type' => $attributes['type'],
                    'name' => $item->name,
                    'description' => $this->faker->text,
                    'item_id' => $item->id,
                    'tax_ids' => [$tax->id],
                    'quantity' => '1',
                    'price' => $amount,
                    'currency' => 'usd',
                ],
            ];
            
            return [
                'items' => $items,
                'recurring_frequency' => 'no',
            ];
        });
    }
    
    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure(): DocumentFactory
    {
        return $this->afterMaking(function (Document $document) {
            if (!$document->company_id) {
                $document->company_id = Company::factory()->create()->id;
            }
            
            return $document;
        })->afterCreating(function (Document $document) {
        
        });
    }
    
}
