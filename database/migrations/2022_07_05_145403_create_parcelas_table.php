<?php

use App\Models\Lancamento;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParcelasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parcelas', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Lancamento::class)->constrained();
            $table->nullableMorphs('forma_pagamento');
            $table->enum('tipo', ['receita', 'despesa']);
            $table->double('valor');
            $table->date('data_pagamento')->nullable();
            $table->date('data_vencimento')->nullable();
            $table->integer('numero')->default(1);
            $table->integer('total')->default(1);
            $table->enum('periodo', ['diario', 'mensal', 'anual'])
                ->default('mensal')->nullable();
            $table->string('obs');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parcelas');
    }
}
