<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use Uuids, Filterable;

    public $timestamps = false;

    public function districts()
    {
        return $this->hasMany(District::class);
    }
}
