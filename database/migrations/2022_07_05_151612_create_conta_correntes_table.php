<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContaCorrentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contas_corrente', function (Blueprint $table) {
            $table->id();
            $table->string('banco');
            $table->string('agencia');
            $table->string('numero');
            $table->string('nome');
            $table->string('obs');
            $table->double('saldo_inicial', 8, 2);
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
        Schema::dropIfExists('contas_corrente');
    }
}
