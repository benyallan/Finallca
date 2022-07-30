<?php

namespace App\Models;

use App\Library\formaPagamentoAbstract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContaCorrente extends formaPagamentoAbstract
{
    use HasFactory;
    use SoftDeletes;

    protected $appends = ['identificador'];
    protected $table = 'contas_corrente';
    protected $fillable = [
        'banco',
        'agencia',
        'numero',
        'nome',
        'obs',
        'saldo_inicial',
    ];

    public function cartoesCredito()
    {
        return $this->hasMany(CartaoCredito::class);
    }

    public function lancamentos()
    {
        return $this->morphMany(Parcela::class, 'forma_pagamento');
    }

    public function getIdentificadorAttribute()
    {
        return $this->nome . " | " . $this->banco;
    }
}
