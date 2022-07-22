<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transferencia extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'entrada',
        'saida'
    ];

    public function entrada()
    {
        return $this->belongsTo(Lancamento::class, 'entrada');
    }

    public function saida()
    {
        return $this->belongsTo(Lancamento::class, 'saida');
    }
}
