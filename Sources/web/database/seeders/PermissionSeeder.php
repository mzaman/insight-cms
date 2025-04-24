<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Domains\V1\Auth\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Seed the permissions table.
     *
     * @return void
     */
    public function run()
    {
        // Define the permissions
        $permissions = [
            ['name' => 'Create', 'slug' => 'create'],
            ['name' => 'Delete', 'slug' => 'delete'],
            ['name' => 'Read', 'slug' => 'read'],
            ['name' => 'Update', 'slug' => 'update'],
            ['name' => 'Approve', 'slug' => 'approve'],
            ['name' => 'Publish', 'slug' => 'publish'],
            ['name' => 'Manage Users', 'slug' => 'manage_users'],
            ['name' => 'Manage Roles', 'slug' => 'manage_roles'],
            ['name' => 'Manage Permissions', 'slug' => 'manage_permissions'],
            ['name' => 'Manage API Keys', 'slug' => 'manage_api_keys'],
        ];

        // Loop through each permission and insert it
        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission['name'],
                'slug' => $permission['slug'],
            ]);
        }
    }
}