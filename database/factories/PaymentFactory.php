<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'fullname' => fake()->name('male'),
            'category_id' => '985a924f-3709-47d2-9bcf-e7d0be091f45',
            'paid' => 1,
            'payment_time' => now(),
            'payment_date' => now()
        ];
    }
}
