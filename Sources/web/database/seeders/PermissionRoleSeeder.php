<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Seed the permission_role pivot table.
     *
     * @return void
     */
    public function run()
    {
        // Define the permissions slugs for each role
        $rolePermissions = [
            'admin' => [
                'user-manage', 'user-create', 'user-delete', 'user-update', 'user-view',
                'user-activate', 'user-deactivate', 'user-reset-password',
                'role-create', 'role-delete', 'role-update', 'role-view', 'role-assign', 'role-revoke',
                'permission-create', 'permission-delete', 'permission-update', 'permission-view', 'permission-assign', 'permission-revoke',
                'api-key-manage', 'api-key-create', 'api-key-delete', 'api-key-view',
                'post-create', 'post-delete', 'post-update', 'post-read', 'post-publish', 'post-sync', 'post-archive', 'post-restore',
            ],
            'manager' => [
                'user-delete', 'user-view', 'user-update',
                'role-update', 'role-view', 'role-assign',
                'permission-update', 'permission-view', 'permission-assign',
                'api-key-manage', 'api-key-create', 'api-key-delete', 'post-read', 'post-update', 'post-archive',
            ],
            'editor' => [
                'user-view', 'user-update',
                'role-view',
                'permission-view', 'permission-assign',
                'post-create', 'post-update', 'post-read', 'post-publish', 'post-sync',
            ],
            'guest' => [
                'post-read',
            ],
        ];

        // Iterate over each role and assign corresponding permissions
        foreach ($rolePermissions as $roleSlug => $permissions) {
            // Get role ID by slug
            $role = DB::table('roles')->where('slug', $roleSlug)->first();

            if ($role) {
                $roleId = $role->id;

                // Remove old permissions for this role
                DB::table('permission_role')->where('role_id', $roleId)->delete();

                // Fetch permission IDs based on slugs
                $permissionIds = DB::table('permissions')
                    ->whereIn('slug', $permissions)
                    ->pluck('id');

                // Attach new permissions to this role
                $permissionsToAttach = $permissionIds->map(function ($permissionId) use ($roleId) {
                    return ['role_id' => $roleId, 'permission_id' => $permissionId];
                })->toArray();

                // Insert new permissions for the role
                DB::table('permission_role')->insert($permissionsToAttach);
            }
        }
    }
}