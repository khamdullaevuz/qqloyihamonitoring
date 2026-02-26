<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes, Uuids;

    protected $guarded = false;

    protected function casts(): array
    {
        return [
                'contract_date' => 'date',
                'walbill_date'  => 'date',
                'start_date'    => 'date',
                'end_date'      => 'date',
        ];
    }
}
