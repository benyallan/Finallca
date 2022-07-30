<?php

namespace App\Models;

use App\Library\formaPagamentoAbstract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Carteira extends formaPagamentoAbstract
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['nome','saldo_inicial'];
    protected $appends = ['identificador'];

    public function lancamentos()
    {
        return $this->morphMany(Parcela::class, 'forma_pagamento');
    }

    public function getIdentificadorAttribute()
    {
        return $this->nome . " | Carteira";
    }
}
