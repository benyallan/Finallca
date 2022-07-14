<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContaCorrente extends Model
{
    use HasFactory;

    protected $fillable = [
        'banco',
        'agencia',
        'numero',
        'nome',
        'obs',
        'saldo_inicial',
    ];
}
