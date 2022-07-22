<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartaoCredito extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'cartoes_credito';
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
}
