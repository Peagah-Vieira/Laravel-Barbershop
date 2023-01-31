<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            PaymentSeeder::class,
            CategorySeeder::class,
        ]);

        for($i = 1; $i <= 10; $i++){
            DB::table(config('timex.tables.event.name'))->insert([
                'id' => uuid_create(),
                'end' => now(),
                'endTime' => now(),
                'body' => 'Mensagem Teste',
                'category' => '985a924f-3709-47d2-9bcf-e7d0be091f45',
                'participants' => '[1]',
                'organizer' => 1,
                'subject' => 'Cliente' . ' ' . $i,
                'start' => now(),
                'startTime' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
