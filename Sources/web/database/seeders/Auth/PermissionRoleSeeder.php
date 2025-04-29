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

        // Create Roles
        Role::create([
            'id' => 1,
            'type' => User::TYPE_ADMIN,
            'name' => 'Administrator',
        ]);

        // Non Grouped Permissions
        //

        // Grouped permissions
        // Users category
        $users = Permission::create([
            'type' => User::TYPE_ADMIN,
            'name' => 'admin.access.user',
            'description' => 'All User Permissions',
        ]);

        $users->children()->saveMany([
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.user.list',
                'description' => 'View Users',
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.user.deactivate',
                'description' => 'Deactivate Users',
                'sort' => 2,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.user.reactivate',
                'description' => 'Reactivate Users',
                'sort' => 3,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.user.clear-session',
                'description' => 'Clear User Sessions',
                'sort' => 4,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.user.impersonate',
                'description' => 'Impersonate Users',
                'sort' => 5,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.user.change-password',
                'description' => 'Change User Passwords',
                'sort' => 6,
            ]),
            
            // Role Permissions
            new Permission([
                'name' => 'admin.access.role.create',
                'description' => 'Create Role',
                'sort' => 7,
            ]),
            new Permission([
                'name' => 'admin.access.role.delete',
                'description' => 'Delete Role',
                'sort' => 8,
            ]),
            new Permission([
                'name' => 'admin.access.role.update',
                'description' => 'Update Role',
                'sort' => 9,
            ]),
            new Permission([
                'name' => 'admin.access.role.view',
                'description' => 'View Role',
                'sort' => 10,
            ]),
            new Permission([
                'name' => 'admin.access.role.assign',
                'description' => 'Assign Role',
                'sort' => 11,
            ]),
            new Permission([
                'name' => 'admin.access.role.revoke',
                'description' => 'Revoke Role',
                'sort' => 12,
            ]),

            // Permission Permissions
            new Permission([
                'name' => 'admin.access.permission.create',
                'description' => 'Create Permission',
                'sort' => 13,
            ]),
            new Permission([
                'name' => 'admin.access.permission.delete',
                'description' => 'Delete Permission',
                'sort' => 14,
            ]),
            new Permission([
                'name' => 'admin.access.permission.update',
                'description' => 'Update Permission',
                'sort' => 15,
            ]),
            new Permission([
                'name' => 'admin.access.permission.view',
                'description' => 'View Permission',
                'sort' => 16,
            ]),
            new Permission([
                'name' => 'admin.access.permission.assign',
                'description' => 'Assign Permission',
                'sort' => 17,
            ]),
            new Permission([
                'name' => 'admin.access.permission.revoke',
                'description' => 'Revoke Permission',
                'sort' => 18,
            ]),

            // API Key Permissions
            new Permission([
                'name' => 'admin.access.api.key.manage',
                'description' => 'Manage API Keys',
                'sort' => 19,
            ]),
            new Permission([
                'name' => 'admin.access.api.key.create',
                'description' => 'Create API Key',
                'sort' => 20,
            ]),
            new Permission([
                'name' => 'admin.access.api.key.delete',
                'description' => 'Delete API Key',
                'sort' => 21,
            ]),
            new Permission([
                'name' => 'admin.access.api.key.view',
                'description' => 'View API Keys',
                'sort' => 22,
            ]),

            // Post Permissions
            new Permission([
                'name' => 'admin.access.post.create',
                'description' => 'Create Post',
                'sort' => 23,
            ]),
            new Permission([
                'name' => 'admin.access.post.delete',
                'description' => 'Delete Post',
                'sort' => 24,
            ]),
            new Permission([
                'name' => 'admin.access.post.update',
                'description' => 'Update Post',
                'sort' => 25,
            ]),
            new Permission([
                'name' => 'admin.access.post.read',
                'description' => 'Read Post',
                'sort' => 26,
            ]),
            new Permission([
                'name' => 'admin.access.post.publish',
                'description' => 'Publish Post',
                'sort' => 27,
            ]),
            new Permission([
                'name' => 'admin.access.post.sync',
                'description' => 'Sync News',
                'sort' => 28,
            ]),
            new Permission([
                'name' => 'admin.access.post.archive',
                'description' => 'Archive Post',
                'sort' => 29,
            ]),
            new Permission([
                'name' => 'admin.access.post.restore',
                'description' => 'Restore Post',
                'sort' => 30,
            ]),
            new Permission([
                'name' => 'admin.access.health.check',
                'description' => 'Access Health Check',
                'sort' => 31,
            ]),
            new Permission([
                'name' => 'admin.access.api.log.view',
                'description' => 'View API Logs',
                'sort' => 32,
            ]),
            new Permission([
                'name' => 'admin.access.api.log.delete',
                'description' => 'Delete API Logs',
                'sort' => 33,
            ]),

        ]);

        // Assign Permissions to other Roles
        //

        $this->enableForeignKeys();
    }
}
