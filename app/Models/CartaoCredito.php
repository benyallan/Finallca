<?php

namespace App\Models;

use App\Library\formaPagamentoAbstract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartaoCredito extends formaPagamentoAbstract
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'cartoes_credito';
    protected $appends = ['identificador'];
    protected $fillable = [
        'conta_corrente_id',
        'nome',
        'dia_fechamento',
        'dia_vencimento',
    ];

    public function contaCorrente()
    {
        return $this->belongsTo(ContaCorrente::class);
    }

    public function lancamentos()
    {
        return $this->morphMany(Parcela::class, 'forma_pagamento');
    }

    public function getIdentificadorAttribute()
    {
        return $this->nome . " | Cartão de Crédito";
    }
}
