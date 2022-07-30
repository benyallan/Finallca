<?php

    namespace App\Library;

use Illuminate\Database\Eloquent\Model;

    abstract class formaPagamentoAbstract extends Model
    {
        abstract protected function getIdentificadorAttribute();

        public function getClass()
        {
            return (string) get_class($this);
        }
    }