<?php

namespace Database\Seeders;

use App\Models\CartaoCredito;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CartaoCreditoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CartaoCredito::factory()
            ->count(5)
            ->create();
    }
}
