<?php

use App\Models\ContaCorrente;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartaoCreditosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cartoes_credito', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ContaCorrente::class)->nullable();
            $table->string('nome');
            $table->tinyInteger('dia_fechamento')->unsigned();
            $table->tinyInteger('dia_vencimento')->unsigned();
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
        Schema::dropIfExists('cartoes_credito');
    }
}
