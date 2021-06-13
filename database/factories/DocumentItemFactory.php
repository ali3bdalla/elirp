<?php

namespace Database\Factories;

use App\Data\CanBeEnabled;
use App\Data\HasCompany;
use App\Models\Document;
use App\Models\DocumentItem;
use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentItemFactory extends Factory
{
    use HasCompany, CanBeEnabled;

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DocumentItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() : array
    {
        $price        = $this->faker->randomFloat(2, 1, 1000);
        $discountRate = $this->faker->randomFloat(2, 1, 100);
        $quantity     = $this->faker->numberBetween(10);
        $total        = $price * $quantity;
        $subtotal     = $total - ($total * ($discountRate / 100));
        return [
            'document_id'   => null,
            'company_id'    => null,
            'type'          => null,
            'name'          => $this->faker->sentence,
            'description'   => $this->faker->sentence,
            'sku'           => $this->faker->sentence,
            'item_id'       => null,
            'quantity'      => $quantity,
            'price'         => $price,
            'discount_rate' => $discountRate,
            'subtotal'      => $subtotal,
            'total'         => $total,
            'tax'           => 0,
        ];
    }

    public function configure()
    {
        return $this->afterMaking(function (DocumentItem $documentItem) {
            if (! $documentItem->company_id) {
                $documentItem->company_id = User::factory()->create()->company_id;
            }

            if (! $documentItem->document_id) {
                $documentItem->document_id = Document::factory()->create(
                    [
                        'company_id' => $documentItem->company_id
                    ]
                )->id;
            }

            if (! $documentItem->item_id) {
                $documentItem->item_id = Item::factory()->create(
                    [
                        'company_id' => $documentItem->company_id
                    ]
                )->id;
            }

            if (! $documentItem->type) {
                $document = Document::find($documentItem->document_id);
                $documentItem->type = $document->type;
            }
            return $documentItem;
        });
    }
}
