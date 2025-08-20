<?php

namespace App\Http\Resources;

use App\Models\Transacao;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Transacao */
class TransacaoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'valor' => $this->valor,
            'cpf' => $this->cpf,
            'documento_path' => $this->documento_path,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user_id' => $this->user_id,
        ];
    }
}
