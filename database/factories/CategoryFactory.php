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
            'value' => 'Primeira Categoria',
            'icon' => 'heroicon-o-clipboard',
            'color' => 'primary',
        ];
    }
}
