<?php

namespace App\Library;

use App\Models\CartaoCredito;
use App\Models\Carteira;
use App\Models\ContaCorrente;

class FormaPagamento {
    
    static function formaPagamento(string $classe)
    {
        switch ($classe) {
            case 'carteira':
                return 'App\\Models\\Carteira';
                break;
            
            case 'conta corrente':
                return 'App\\Models\\ContaCorrente';
                break;
            
            case 'cartao credito':
                return 'App\\Models\\CartaoCredito';
                break;
            
            default:
            throw new \ErrorException('Forma de pagamento não existe');
        }
    }
}
