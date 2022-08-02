<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LancamentoResource extends JsonResource
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
            'descricao' => $this->descricao,
            'data' => $this->data,
            'valorTotal' => $this->valorTotal,
            'obs' => $this->obs,
            'parcela' => ParcelaResource::collection($this->parcelas)
        ];
    }
}
