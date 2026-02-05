<?php

namespace App\DTO;

class RoleDto
{
    public function __construct(
        public string $name,
        public ?string $s_code = null,
        public array $permissions = []
    ) { }

    public function toArray(): array
    {
        return [
            'name'     => $this->name,
            's_code'    => $this->s_code,
        ];
    }
}
