<?php

namespace App\Http\Resources;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Status */
class StatusResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
                'id'         => $this->id,
                'name'       => $this->name,
                'is_active'  => $this->is_active,
                's_code'     => $this->s_code,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
        ];
    }
}
