<?php

namespace App\Enums\System;

use App\Enums\BaseEnum;

enum CRUD: string
{
    use BaseEnum;

    case Create = 'create';
    case Read = 'read';
    case Update = 'update';
    case Delete = 'delete';
    case Confirm = 'confirm';
    case Admin = 'admin';
    case ReadAll = 'read_all';

    public static function getValues(): array
    {
        return ['create', 'read', 'update', 'delete', 'admin'];
    }
}
