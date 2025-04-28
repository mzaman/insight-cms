<?php

namespace Database\Seeders\Auth;

use App\Domains\Auth\Models\User;
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

        // Add the master administrator, user id of 1
        User::firstOrCreate([
            'email' => 'admin@mail.com',
        ], [
            'type' => User::TYPE_ADMIN,
            'name' => 'Super Admin',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'active' => true,
        ]);

        if (app()->environment(['local', 'testing'])) {
            // Add Manager user
            User::firstOrCreate([
                'email' => 'manager@mail.com',
            ], [
                'type' => User::TYPE_ADMIN,
                'name' => 'Manager',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'active' => true,
            ]);

            // Add Editor user
            User::firstOrCreate([
                'email' => 'editor@mail.com',
            ], [
                'type' => User::TYPE_ADMIN,
                'name' => 'Editor',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'active' => true,
            ]);

            // Add CLI user
            User::firstOrCreate([
                'email' => 'cliuser@mail.com',
            ], [
                'type' => User::TYPE_ADMIN,
                'name' => 'CLI User',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'active' => true,
            ]);

            // Add Guest user
            User::firstOrCreate([
                'email' => 'guest@mail.com',
            ], [
                'type' => User::TYPE_USER,
                'name' => 'Test User',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'active' => true,
            ]);
        }

        $this->enableForeignKeys();
    }
}