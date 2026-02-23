<?php

namespace App\DTO;

class UserDto
{
    public function __construct(
        public string $name,
        public string $phone,
        public ?string $password = null,
        public array $roles = [],
        public array $regions = [],
    ) { }

    public function toArray(): array
    {
        return [
            'name'     => $this->name,
            'phone'    => $this->phone,
            'password' => $this->password,
        ];
    }
}
