<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Parcela extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $appends = ['situacao'];
    protected $fillable = [
        'lancamento_id',
        'forma_pagamento_type',
        'forma_pagamento_id',
        'tipo',
        'valor',
        'data_pagamento',
        'data_vencimento',
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

    public function getSituacaoAttribute()
    {
        if ($this->data_pagamento) {
            return "Pago";
        } if (Carbon::now()->lessThanOrEqualTo(Carbon::parse($this->data_vencimento))) {
            return "Em Aberto";
        } else {
            return "Em Atraso";
        }
    }
}
