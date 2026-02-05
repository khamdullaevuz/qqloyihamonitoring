<?php

namespace Database\Seeders;

use App\Enums\System\CRUD;
use App\Enums\System\DocumentType;
use App\Enums\System\MenuType;
use App\Enums\System\PermissionType;
use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->documentPermissions();
        $this->menuPermissions();
    }

    public function documentPermissions(): void
    {
        foreach (DocumentType::cases() as $document) {
            foreach (CRUD::getValues() as $crud) {
                Permission::updateOrCreate(
                    [
                        'id' => uuid(),
                        'type' => PermissionType::Documents,
                        'name' => $document->value . '.' . $crud,
                    ]
                );
            }
        }
    }

    public function menuPermissions(): void
    {
        foreach (MenuType::cases() as $menu) {
            Permission::updateOrCreate(
                [
                    'id' => uuid(),
                    'type' => PermissionType::Menus,
                    'name' => $menu->value . '.' . CRUD::Read->value,
                ]
            );
        }
    }
}
