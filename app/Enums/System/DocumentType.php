<?php

namespace App\Enums\System;

use App\Enums\BaseEnum;

enum DocumentType: string
{
    use BaseEnum;

    case User = 'users';
    case Role = 'roles';
    case Projects = 'projects';
    case Regions = 'regions';
    case Districts = 'districts';
    case Currencies = 'currencies';
}
