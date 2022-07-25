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
            $table->foreignIdFor(Lancamento::class)->constrained()
                ->onDelete('cascade');
            $table->nullableMorphs('forma_pagamento');
            $table->double('valor',null,null,true);
            $table->enum('tipo', ['receita', 'despesa'])
                ->comment('Tem que estar vinculado a parcela 
                    pois alguns lançamentos possuem uma entrada 
                    e uma saída, como transferências e empréstimos');
            $table->date('data_pagamento')->nullable()
                ->comment('Data em que efetivamente foi pago 
                    ou recebido o valor');
            $table->date('data_vencimento')->nullable()
                ->comment('Data em está programado o recebimento 
                    ou o pagamento');
            $table->integer('numero')->default(1);
            $table->integer('total')->default(1);
            $table->enum('periodo', ['diario', 'mensal', 'anual'])
                ->nullable();
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
