<?php

namespace Database\Seeders;

use App\Models\ContaCorrente;
use Illuminate\Database\Seeder;

class ContaCorrenteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ContaCorrente::factory()
            ->count(5)
            ->create();
    }
}
