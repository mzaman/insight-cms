<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Domains\V1\Auth\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Seed the roles table.
     *
     * @return void
     */
    public function run()
    {
        // Define the roles
        $roles = [
            ['name' => 'Admin', 'slug' => 'admin'],
            ['name' => 'Manager', 'slug' => 'manager'],
            ['name' => 'Guest', 'slug' => 'guest'],
            ['name' => 'Editor', 'slug' => 'editor']
        ];

        // Loop through each role and insert it
        foreach ($roles as $role) {
            Role::firstOrCreate([
                'name' => $role['name'],
                'slug' => $role['slug'],
            ]);
        }
    }
}