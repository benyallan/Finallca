<?php

namespace Database\Seeders;

use App\Models\Lancamento;
use App\Models\Parcela;
use Illuminate\Database\Seeder;

class LancamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Lancamento::factory(100)
            ->has(Parcela::factory()->count(1))
            ->create();
    }
}
