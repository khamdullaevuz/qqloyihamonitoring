<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use Uuids, Filterable;

    public $timestamps = false;

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}
