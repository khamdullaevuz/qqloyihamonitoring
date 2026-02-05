<?php

namespace App\Enums\System;

use App\Enums\BaseEnum;

enum DocumentType: string
{
    use BaseEnum;

    case User = 'user';
    case Role = 'role';
}
