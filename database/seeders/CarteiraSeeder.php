<?php

namespace Database\Seeders;

use App\Models\Carteira;
use Illuminate\Database\Seeder;

class CarteiraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Carteira::factory()
            ->count(5)
            ->create();
    }
}
