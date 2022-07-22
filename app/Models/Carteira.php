<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Carteira extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['nome','saldo_inicial'];

    public function lancamentos()
    {
        return $this->morphMany(Parcela::class, 'formaPagamento');
    }
}
