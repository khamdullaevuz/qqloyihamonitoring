<?php

namespace App\Http\Requests;

use App\DTO\ProjectDto;
use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'                => ['required'],
            'region_id'           => ['required'],
            'act'                 => ['required'],
            'object_count'        => ['required', 'integer'],
            'responsible_name'    => ['required'],
            'responsible_phone'   => ['required'],
            'customer'            => ['required'],
            'contract_number'     => ['required'],
            'contract_date'       => ['required', 'date'],
            'total_sum'           => ['required', 'integer'],
            'paid_amount'         => ['required', 'integer'],
            'remaining_amount'    => ['required', 'integer'],
            'wallbill_number'     => ['required'],
            'walbill_date'        => ['required', 'date'],
            'invoice_amount'      => ['required', 'integer'],
            'invoice_paid_amount' => ['required', 'integer'],
            'invoice_debit'       => ['required', 'integer'],
            'invoice_credit'      => ['required', 'integer'],
            'start_date'          => ['required', 'date'],
            'end_date'            => ['required', 'date'],
            'currency_id'         => ['required', 'uuid'],
            'comment'             => ['nullable'],
        ];
    }

    public function toDto(): ProjectDto
    {
        return new ProjectDto(
            name:                $this->name,
            region_id:           $this->region_id,
            act:                 $this->act,
            object_count:        $this->object_count,
            responsible_name:    $this->responsible_name,
            responsible_phone:   $this->responsible_phone,
            customer:            $this->customer,
            contract_number:     $this->contract_number,
            contract_date:       $this->contract_date,
            total_sum:           $this->total_sum,
            paid_amount:         $this->paid_amount,
            remaining_amount:    $this->remaining_amount,
            wallbill_number:     $this->wallbill_number,
            walbill_date:        $this->walbill_date,
            invoice_amount:      $this->invoice_amount,
            invoice_paid_amount: $this->invoice_paid_amount,
            invoice_debit:       $this->invoice_debit,
            invoice_credit:      $this->invoice_credit,
            start_date:          $this->start_date,
            end_date:            $this->end_date,
            currency_id:         $this->currency_id,
            comment:             $this->comment,
        );
    }
}
