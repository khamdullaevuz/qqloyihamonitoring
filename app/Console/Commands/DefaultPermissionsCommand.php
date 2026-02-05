<?php

namespace App\Console\Commands;

use App\Enums\System\CRUD;
use App\Enums\System\DocumentType;
use App\Enums\System\MenuType;
use App\Enums\System\PermissionType;
use App\Models\Permission;
use Illuminate\Console\Command;

class DefaultPermissionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:default-permissions-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
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
                    'type' => PermissionType::Menus,
                    'name' => $menu->value . '.' . CRUD::Read->value,
                ]
            );
        }
    }
}
