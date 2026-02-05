<?php

namespace App\Enums\System;

/**
 * @psalm-api
 */
enum PermissionType: string
{
    case Menus = 'menus';
    case Documents = 'documents';
}
