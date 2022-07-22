<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parcela extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'lancamento_id',
        'forma_pagamento_type',
        'forma_pagamento_id',
        'tipo',
        'valor',
        'data_pagamento',
        'dia_vencimento',
        'numero',
        'total',
        'periodo',
        'obs'
    ];

    public function lancamento()
    {
        return $this->belongsTo(Lancamento::class);
    }

    public function formaPagamento()
    {
        return $this->morphTo();
    }
}
