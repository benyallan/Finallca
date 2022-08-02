<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ParcelaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'situacao' => $this->situacao,
            'forma_pagamento' => $this->formaPagamento,
            'tipo' => $this->tipo,
            'valor' => $this->valor,
            'data_pagamento' => $this->data_pagamento,
            'data_vencimento' => $this->data_vencimento,
            'numero' => $this->numero,
            'total' => $this->total,
            'periodo' => $this->periodo,
            'obs' => $this->obs
        ];
    }
}
