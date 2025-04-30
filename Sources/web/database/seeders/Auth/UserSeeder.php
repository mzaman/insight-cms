<?php

namespace Database\Seeders\Auth;

namespace Database\Seeders\Auth;

use App\Domains\Auth\Models\User;
use App\Domains\Auth\Models\Role;
use Database\Seeders\Traits\DisableForeignKeys;
use Illuminate\Database\Seeder;

/**
 * Class UserSeeder.
 */
class UserSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seed.
     */
    public function run()
    {
        $this->disableForeignKeys();

        // Ensure that the roles are created before assigning them to users
        $adminRole = Role::firstOrCreate(['name' => config('boilerplate.access.role.admin'), 'type' => User::TYPE_ADMIN]);
        $managerRole = Role::firstOrCreate(['name' => 'Manager', 'type' => User::TYPE_ADMIN]);
        $editorRole = Role::firstOrCreate(['name' => 'Editor', 'type' => User::TYPE_ADMIN]);
        $cliRole = Role::firstOrCreate(['name' => 'CLI', 'type' => User::TYPE_ADMIN]);
        $guestRole = Role::firstOrCreate(['name' => 'Guest', 'type' => User::TYPE_USER]);

        // Add the master administrator, user id of 1
        $admin = User::firstOrCreate([
            'email' => 'admin@mail.com',
        ], [
            'type' => User::TYPE_ADMIN,
            'name' => 'Super Admin',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'active' => true,
        ]);

        // Add Manager user
        $manager = User::firstOrCreate([
            'email' => 'manager@mail.com',
        ], [
            'type' => User::TYPE_ADMIN,
            'name' => 'Manager',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'active' => true,
        ]);

        // Add Editor user
        $editor = User::firstOrCreate([
            'email' => 'editor@mail.com',
        ], [
            'type' => User::TYPE_ADMIN,
            'name' => 'Editor',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'active' => true,
        ]);

        
        // Add CLI user
        $cli = User::firstOrCreate([
            'email' => 'cliuser@mail.com',
        ], [
            'type' => User::TYPE_ADMIN,
            'name' => 'CLI User',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'active' => true,
        ]);

        // Add Guest user
        $guest = User::firstOrCreate([
            'email' => 'guest@mail.com',
        ], [
            'type' => User::TYPE_USER,
            'name' => 'Test User',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'active' => true,
        ]);

        // Assign roles to users
        $admin->assignRole($adminRole); // Master Admin role
        $manager->assignRole($managerRole); // Manager role
        $editor->assignRole($editorRole); // Editor role
        $cli->assignRole($cliRole); // cli role
        $guest->assignRole($guestRole); // guest role

        $this->enableForeignKeys();
    }
}