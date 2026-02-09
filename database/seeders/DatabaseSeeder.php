<?php

namespace Database\Seeders;

use App\Models\User;
use Artisan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Super Admin',
            'phone' => '998000000000',
        ]);

        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
    }
}
