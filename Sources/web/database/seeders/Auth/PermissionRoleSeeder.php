<?php

namespace Database\Seeders\Auth;

use App\Domains\Auth\Models\Permission;
use App\Domains\Auth\Models\Role;
use App\Domains\Auth\Models\User;
use Database\Seeders\Traits\DisableForeignKeys;
use Illuminate\Database\Seeder;

/**
 * Class PermissionRoleTableSeeder.
 */
class PermissionRoleSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seed.
     */
    public function run()
    {
        $this->disableForeignKeys();

        // Create Roles (Ensure roles exist first)
        $adminRole = Role::firstOrCreate(['name' => config('boilerplate.access.role.admin'), 'type' => User::TYPE_ADMIN]);
        $managerRole = Role::firstOrCreate(['name' => 'Manager', 'type' => User::TYPE_ADMIN]);
        $editorRole = Role::firstOrCreate(['name' => 'Editor', 'type' => User::TYPE_ADMIN]);
        $cliRole = Role::firstOrCreate(['name' => 'CLI', 'type' => User::TYPE_ADMIN]);
        $guestRole = Role::firstOrCreate(['name' => 'Guest', 'type' => User::TYPE_USER]);

        // Non Grouped Permissions
        //

        // Grouped permissions for Users category
        $users = Permission::create([
            'type' => User::TYPE_ADMIN,
            'name' => 'admin.access.user',
            'description' => 'All User Permissions',
            'sort' => 1,
        ]);

        $users->children()->saveMany([
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.user.list',
                'description' => 'View Users',
                'sort' => 2,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.user.deactivate',
                'description' => 'Deactivate Users',
                'sort' => 3,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.user.reactivate',
                'description' => 'Reactivate Users',
                'sort' => 4,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.user.clear-session',
                'description' => 'Clear User Sessions',
                'sort' => 5,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.user.impersonate',
                'description' => 'Impersonate Users',
                'sort' => 6,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.user.change-password',
                'description' => 'Change User Passwords',
                'sort' => 7,
            ]),
        ]);

        // Grouped permissions for Role Permissions
        $rolePermissions = Permission::create([
            'name' => 'admin.access.role',
            'description' => 'All Role Management Permissions',
            'sort' => 8,
        ]);

        $rolePermissions->children()->saveMany([
            new Permission([
                'name' => 'admin.access.role.create',
                'description' => 'Create Role',
                'sort' => 9,
            ]),
            new Permission([
                'name' => 'admin.access.role.delete',
                'description' => 'Delete Role',
                'sort' => 10,
            ]),
            new Permission([
                'name' => 'admin.access.role.update',
                'description' => 'Update Role',
                'sort' => 11,
            ]),
            new Permission([
                'name' => 'admin.access.role.view',
                'description' => 'View Role',
                'sort' => 12,
            ]),
            new Permission([
                'name' => 'admin.access.role.assign',
                'description' => 'Assign Role',
                'sort' => 13,
            ]),
            new Permission([
                'name' => 'admin.access.role.revoke',
                'description' => 'Revoke Role',
                'sort' => 14,
            ]),
        ]);

        // Grouped permissions for Permission Permissions
        $permissionPermissions = Permission::create([
            'name' => 'admin.access.permission',
            'description' => 'All Permission Management Permissions',
            'sort' => 15,
        ]);

        $permissionPermissions->children()->saveMany([
            new Permission([
                'name' => 'admin.access.permission.create',
                'description' => 'Create Permission',
                'sort' => 16,
            ]),
            new Permission([
                'name' => 'admin.access.permission.delete',
                'description' => 'Delete Permission',
                'sort' => 17,
            ]),
            new Permission([
                'name' => 'admin.access.permission.update',
                'description' => 'Update Permission',
                'sort' => 18,
            ]),
            new Permission([
                'name' => 'admin.access.permission.view',
                'description' => 'View Permission',
                'sort' => 19,
            ]),
            new Permission([
                'name' => 'admin.access.permission.assign',
                'description' => 'Assign Permission',
                'sort' => 20,
            ]),
            new Permission([
                'name' => 'admin.access.permission.revoke',
                'description' => 'Revoke Permission',
                'sort' => 21,
            ]),
        ]);

        // Grouped permissions for API Key Permissions
        $apiKeyPermissions = Permission::create([
            'name' => 'admin.access.api.key',
            'description' => 'All API Key Management Permissions',
            'sort' => 22,
        ]);

        $apiKeyPermissions->children()->saveMany([
            new Permission([
                'name' => 'admin.access.api.key.manage',
                'description' => 'Manage API Keys',
                'sort' => 23,
            ]),
            new Permission([
                'name' => 'admin.access.api.key.create',
                'description' => 'Create API Key',
                'sort' => 24,
            ]),
            new Permission([
                'name' => 'admin.access.api.key.delete',
                'description' => 'Delete API Key',
                'sort' => 25,
            ]),
            new Permission([
                'name' => 'admin.access.api.key.view',
                'description' => 'View API Keys',
                'sort' => 26,
            ]),
        ]);

        // Grouped permissions for Post Permissions
        $postPermissions = Permission::create([
            'name' => 'admin.access.post',
            'description' => 'All Post Management Permissions',
            'sort' => 27,
        ]);

        $postPermissions->children()->saveMany([
            new Permission([
                'name' => 'admin.access.post.create',
                'description' => 'Create Post',
                'sort' => 28,
            ]),
            new Permission([
                'name' => 'admin.access.post.delete',
                'description' => 'Delete Post',
                'sort' => 29,
            ]),
            new Permission([
                'name' => 'admin.access.post.update',
                'description' => 'Update Post',
                'sort' => 30,
            ]),
            new Permission([
                'name' => 'admin.access.post.read',
                'description' => 'Read Post',
                'sort' => 31,
            ]),
            new Permission([
                'name' => 'admin.access.post.publish',
                'description' => 'Publish Post',
                'sort' => 32,
            ]),
            new Permission([
                'name' => 'admin.access.post.sync',
                'description' => 'Sync News',
                'sort' => 33,
            ]),
            new Permission([
                'name' => 'admin.access.post.archive',
                'description' => 'Archive Post',
                'sort' => 34,
            ]),
            new Permission([
                'name' => 'admin.access.post.restore',
                'description' => 'Restore Post',
                'sort' => 35,
            ]),
        ]);

        // Specific permissions for Health Check and API Logs
        new Permission([
            'name' => 'admin.access.health.check',
            'description' => 'Access Health Check',
            'sort' => 36,
        ]);
        
        new Permission([
            'name' => 'admin.access.api.log.view',
            'description' => 'View API Logs',
            'sort' => 37,
        ]);
        
        new Permission([
            'name' => 'admin.access.api.log.delete',
            'description' => 'Delete API Logs',
            'sort' => 38,
        ]);

        // Assign all permissions to the Admin role
        $adminRole->permissions()->saveMany(Permission::all());

        // Assign specific permissions to Manager
        $managerRole->permissions()->saveMany([
            $postPermissions->children->where('name', 'admin.access.post.sync')->first(),
            $apiKeyPermissions->children->where('name', 'admin.access.api.key.manage')->first(),
            $postPermissions->children->where('name', 'admin.access.post.create')->first(),
            $postPermissions->children->where('name', 'admin.access.post.update')->first(),
            $postPermissions->children->where('name', 'admin.access.post.read')->first(),
            $postPermissions->children->where('name', 'admin.access.post.delete')->first(),
        ]);

        // Assign specific permissions to Editor
        $editorRole->permissions()->saveMany([
            $postPermissions->children->where('name', 'admin.access.post.sync')->first(),
            $postPermissions->children->where('name', 'admin.access.post.create')->first(),
            $postPermissions->children->where('name', 'admin.access.post.update')->first(),
            $postPermissions->children->where('name', 'admin.access.post.read')->first(),
            $postPermissions->children->where('name', 'admin.access.post.delete')->first(),
        ]);

        // Assign CLI permissions to CLI Role
        $cliRole->permissions()->saveMany([
            $postPermissions->children->where('name', 'admin.access.post.sync')->first(),
            $apiKeyPermissions->children->where('name', 'admin.access.api.key.manage')->first(),
        ]);

        $this->enableForeignKeys();
    }
}