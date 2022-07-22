<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lancamento extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'descricao',
        'data',
        'obs'
    ];

    public function parcelas()
    {
        return $this->hasMany(Parcela::class);
    }

    public function transferencia()
    {
        return $this->hasOne(Transferencia::class);
    }
}
