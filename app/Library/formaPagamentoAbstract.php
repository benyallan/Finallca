<?php

    namespace App\Library;

use Illuminate\Database\Eloquent\Model;

    abstract class formaPagamentoAbstract extends Model
    {
        abstract protected function getIdentificadorAttribute();
        abstract protected function getTipoAttribute();
    }