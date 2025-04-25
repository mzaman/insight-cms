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
            // User Permissions
            ['name' => 'Manage Users', 'slug' => 'user-manage'],
            ['name' => 'Create User', 'slug' => 'user-create'],
            ['name' => 'Delete User', 'slug' => 'user-delete'],
            ['name' => 'Update User', 'slug' => 'user-update'],
            ['name' => 'View User', 'slug' => 'user-view'],
            ['name' => 'Activate User', 'slug' => 'user-activate'],
            ['name' => 'Deactivate User', 'slug' => 'user-deactivate'],
            ['name' => 'Reset User Password', 'slug' => 'user-reset-password'],
            
            // Role Permissions
            ['name' => 'Create Role', 'slug' => 'role-create'],
            ['name' => 'Delete Role', 'slug' => 'role-delete'],
            ['name' => 'Update Role', 'slug' => 'role-update'],
            ['name' => 'View Role', 'slug' => 'role-view'],
            ['name' => 'Assign Role', 'slug' => 'role-assign'],
            ['name' => 'Revoke Role', 'slug' => 'role-revoke'],
            
            // Permission Permissions
            ['name' => 'Create Permission', 'slug' => 'permission-create'],
            ['name' => 'Delete Permission', 'slug' => 'permission-delete'],
            ['name' => 'Update Permission', 'slug' => 'permission-update'],
            ['name' => 'View Permission', 'slug' => 'permission-view'],
            ['name' => 'Assign Permission', 'slug' => 'permission-assign'],
            ['name' => 'Revoke Permission', 'slug' => 'permission-revoke'],
            
            // API Key Permissions
            ['name' => 'Manage API Keys', 'slug' => 'api-key-manage'],
            ['name' => 'Create API Key', 'slug' => 'api-key-create'],
            ['name' => 'Delete API Key', 'slug' => 'api-key-delete'],
            ['name' => 'View API Keys', 'slug' => 'api-key-view'],
            
            // Post Permissions
            ['name' => 'Create Post', 'slug' => 'post-create'],
            ['name' => 'Delete Post', 'slug' => 'post-delete'],
            ['name' => 'Update Post', 'slug' => 'post-update'],
            ['name' => 'Read Post', 'slug' => 'post-read'],
            ['name' => 'Publish Post', 'slug' => 'post-publish'],
            ['name' => 'Sync News', 'slug' => 'post-sync'],
            ['name' => 'Archive Post', 'slug' => 'post-archive'],
            ['name' => 'Restore Post', 'slug' => 'post-restore'],
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