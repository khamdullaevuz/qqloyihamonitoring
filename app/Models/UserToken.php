<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserToken extends Model
{
    use Uuids;

    protected $guarded = false;

    protected $casts = [
        'expired_at'         => 'datetime:Y.m.d H:i:s',
        'refresh_expired_at' => 'datetime:Y.m.d H:i:s',
        'created_at'         => 'datetime:Y-m-d H:i:s',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
