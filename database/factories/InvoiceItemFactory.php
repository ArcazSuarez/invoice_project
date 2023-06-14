<?php

namespace Database\Factories;

use App\Models\InvoiceItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = InvoiceItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $qty = $this->faker->numberBetween(1, 10);
        $price = $this->faker->randomFloat(2, 1, 100);
        $invoice_code = '';

        return [
            'invoice_code' => $invoice_code,
            'name' => $this->faker->word(),
            'qty' => $qty,
            'price' => $price,
            'subtotal' => $qty * $price,
        ];
    }
}
