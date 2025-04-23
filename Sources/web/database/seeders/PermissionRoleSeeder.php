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
        // Sync permissions to roles
        $adminPermissions = [
            1,  // Create
            2,  // Delete
            3,  // Read
            4,  // Update
            5,  // Approve
            6,  // Publish
            7,  // Manage Users
            8,  // Manage Roles
            9,  // Manage Permissions
        ];

        $managerPermissions = [
            2,  // Delete
            3,  // Read
            4,  // Update
            5,  // Approve
        ];

        $editorPermissions = [
            1,  // Create
            3,  // Read
            4,  // Update
            5,  // Approve
        ];

        $guestPermissions = [
            3,  // Read
        ];

        // Admin Role
        DB::table('permission_role')->where('role_id', 1)->delete(); // Remove old permissions for Admin
        DB::table('permission_role')->insert(
            array_map(function ($permissionId) {
                return ['role_id' => 1, 'permission_id' => $permissionId];
            }, $adminPermissions)
        );

        // Manager Role
        DB::table('permission_role')->where('role_id', 2)->delete(); // Remove old permissions for Manager
        DB::table('permission_role')->insert(
            array_map(function ($permissionId) {
                return ['role_id' => 2, 'permission_id' => $permissionId];
            }, $managerPermissions)
        );

        // Editor Role
        DB::table('permission_role')->where('role_id', 4)->delete(); // Remove old permissions for Editor
        DB::table('permission_role')->insert(
            array_map(function ($permissionId) {
                return ['role_id' => 4, 'permission_id' => $permissionId];
            }, $editorPermissions)
        );

        // Guest Role
        DB::table('permission_role')->where('role_id', 3)->delete(); // Remove old permissions for Guest
        DB::table('permission_role')->insert(
            array_map(function ($permissionId) {
                return ['role_id' => 3, 'permission_id' => $permissionId];
            }, $guestPermissions)
        );
    }
}