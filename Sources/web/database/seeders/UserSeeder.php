<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Seed the users table.
     *
     * @return void
     */
    public function run()
    {
        // Create users with specific roles using the UserFactory from Domains/V1/Auth/Models

        // Admin User
        User::firstOrCreate([
            'email' => 'admin@mail.com'
        ], [
            'name' => 'Admin',
            'role_id' => 1, // Admin role
            'password' => bcrypt('password')
        ]);

        // Manager User
        User::firstOrCreate([
            'email' => 'manager@mail.com'
        ], [
            'name' => 'Manager',
            'role_id' => 2, // Manager role
            'password' => bcrypt('password')
        ]);

        // Guest User
        User::firstOrCreate([
            'email' => 'guest@mail.com'
        ], [
            'name' => 'Guest',
            'role_id' => 3, // Guest role
            'password' => bcrypt('password')
        ]);

        // Editor User
        User::firstOrCreate([
            'email' => 'editor@mail.com'
        ], [
            'name' => 'Editor',
            'role_id' => 4, // Editor role
            'password' => bcrypt('password')
        ]);

        // Create random users (factory-generated data) without overriding specific fields
        User::factory()->count(7)->create();
    }
}