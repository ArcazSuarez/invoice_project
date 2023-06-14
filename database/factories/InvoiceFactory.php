<?php

namespace Database\Factories;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Invoice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => 'INV-' . $this->faker->unique()->numerify('###')  . strtoupper($this->faker->lexify('???')),
            'user_id' => 1,
            'customer_name' => $this->faker->name(),
            'due_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'total' => $this->faker->randomFloat(2, 1, 1000),
        ];
    }
}
