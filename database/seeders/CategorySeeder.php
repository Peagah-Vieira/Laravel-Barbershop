<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::factory()->create([
            'id' => '985a924f-3709-47d2-9bcf-e7d0be091f45',
            'name' => 'Corte Degradê Máquina/Tesoura ou Máquina',
            'amount' => 30,
        ]);

        Category::factory()->create([
            'name' => 'Corte Tesoura',
            'amount' => 60,
        ]);

        Category::factory()->create([
            'name' => 'Máquina e Tesoura',
            'amount' => 30,
        ]);

        Category::factory()->create([
            'name' => 'Máquina 1 Pente',
            'amount' => 20,
        ]);

        Category::factory()->create([
            'name' => 'Máquina 2 a 3 Pente',
            'amount' => 25,
        ]);

        Category::factory()->create([
            'name' => 'Corte Infantil 0 a 5 anos Tempo de atendimento 1 hora',
            'amount' => 45,
        ]);

        Category::factory()->create([
            'name' => 'Barba Longa com ou sem Degradê',
            'amount' => 30,
        ]);

        Category::factory()->create([
            'name' => 'Barba Lisa ou Modelada Baixa',
            'amount' => 25,
        ]);

        Category::factory()->create([
            'name' => 'Corte Degradê Máquina/Tesoura ou Tesoura com Barba Modelada Longa',
            'amount' => 60,
        ]);

        Category::factory()->create([
            'name' => 'Corte Degradê Máquina/Tesoura com Barba Lisa ou Modelada Baixa',
            'amount' => 55,
        ]);

        Category::factory()->create([
            'name' => 'Navalha e Barba',
            'amount' => 50,
        ]);
    }
}
