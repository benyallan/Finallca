<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Beny',
            'email' => 'benyallan@gmail.com',
            'password' => Hash::make('123456'),
        ]);
        $this->call([
            CarteiraSeeder::class,
            ContaCorrenteSeeder::class,
            CartaoCreditoSeeder::class,
        ]);
    }
}
