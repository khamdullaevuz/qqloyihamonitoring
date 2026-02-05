<?php

namespace App\Enums\System;

use App\Enums\BaseEnum;

/**
 * @psalm-api
 */
enum MenuType: string
{
    use BaseEnum;

    case User = 'user';
    case Role = 'role';
}
