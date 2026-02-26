<?php

namespace App\Http\Resources;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Project */
class ProjectResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
                'id'                  => $this->id,
                'name'                => $this->name,
                'region_id'           => $this->region_id,
                'act'                 => $this->act,
                'object_count'        => $this->object_count,
                'responsible_name'    => $this->responsible_name,
                'responsible_phone'   => $this->responsible_phone,
                'customer'            => $this->customer,
                'contract_number'     => $this->contract_number,
                'contract_date'       => $this->contract_date,
                'total_sum'           => $this->total_sum,
                'paid_amount'         => $this->paid_amount,
                'remaining_amount'    => $this->remaining_amount,
                'wallbill_number'     => $this->wallbill_number,
                'walbill_date'        => $this->walbill_date,
                'invoice_amount'      => $this->invoice_amount,
                'invoice_paid_amount' => $this->invoice_paid_amount,
                'invoice_debit'       => $this->invoice_debit,
                'invoice_credit'      => $this->invoice_credit,
                'start_date'          => $this->start_date,
                'end_date'            => $this->end_date,
                'status'              => $this->status,
                'comment'             => $this->comment,
                'created_at'          => $this->created_at,
                'updated_at'          => $this->updated_at,
        ];
    }
}
