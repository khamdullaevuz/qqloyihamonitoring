<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use Uuids;
    protected $guarded = false;
}
