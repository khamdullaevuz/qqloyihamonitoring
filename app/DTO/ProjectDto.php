<?php

namespace App\DTO;

class ProjectDto
{
    public function __construct(
        public ?string $name,
        public ?string $region_id,
        public ?string $act,
        public ?string $object_count,
        public ?string $responsible_name,
        public ?string $responsible_phone,
        public ?string $customer,
        public ?string $contract_number,
        public ?string $contract_date,
        public ?string $total_sum,
        public ?string $paid_amount,
        public ?string $remaining_amount,
        public ?string $wallbill_number,
        public ?string $walbill_date,
        public ?string $invoice_amount,
        public ?string $invoice_paid_amount,
        public ?string $invoice_debit,
        public ?string $invoice_credit,
        public ?string $start_date,
        public ?string $end_date,
        public ?string $currency_id,
        public ?string $comment,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'region_id' => $this->region_id,
            'act' => $this->act,
            'object_count' => $this->object_count,
            'responsible_name' => $this->responsible_name,
            'responsible_phone' => $this->responsible_phone,
            'customer' => $this->customer,
            'contract_number' => $this->contract_number,
            'contract_date' => $this->contract_date,
            'total_sum' => $this->total_sum,
            'paid_amount' => $this->paid_amount,
            'remaining_amount' => $this->remaining_amount,
            'wallbill_number' => $this->wallbill_number,
            'walbill_date' => $this->walbill_date,
            'invoice_amount' => $this->invoice_amount,
            'invoice_paid_amount' => $this->invoice_paid_amount,
            'invoice_debit' => $this->invoice_debit,
            'invoice_credit' => $this->invoice_credit,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'currency_id' => $this->currency_id,
            'comment' => $this->comment,
        ];
    }
}
