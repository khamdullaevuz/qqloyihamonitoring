<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use Uuids;

    public $timestamps = false;

    public function districts()
    {
        return $this->hasMany(District::class);
    }
}
