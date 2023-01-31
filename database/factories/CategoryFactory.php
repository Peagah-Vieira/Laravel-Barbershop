<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id' => '985a924f-3709-47d2-9bcf-e7d0be091f45',
            'name' => 'Corte Teste',
            'amount' => 55,
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
