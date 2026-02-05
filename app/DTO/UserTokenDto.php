<?php

namespace App\DTO;

use Carbon\CarbonImmutable;

class UserTokenDto
{
    public function __construct(
        public ?string $user_id,
        public ?string $token,
        public ?string $refresh_token,
        public CarbonImmutable $expired_at,
        public CarbonImmutable $refresh_expired_at,
    ) { }

    public function toArray(): array
    {
        return [
            'user_id'            => $this->user_id,
            'token'              => $this->token,
            'refresh_token'      => $this->refresh_token,
            'expired_at'         => $this->expired_at,
            'refresh_expired_at' => $this->refresh_expired_at,
        ];
    }
}
