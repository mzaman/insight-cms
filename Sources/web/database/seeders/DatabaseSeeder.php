<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Permission::insert([
            [
                'name' => 'Create',
                'slug' => 'create'
            ],
            [
                'name' => 'Delete',
                'slug' => 'delete'
            ],
            [
                'name' => 'Read',
                'slug' => 'read'
            ]
        ]);

        Role::insert([
            [
                'name' => 'Admin', //create, read, delete
                'slug' => 'admin'
            ],
            [
                'name' => 'Manager', //read, delete
                'slug' => 'manager'
            ],
            [
                'name' => 'Guest', //read only
                'slug' => 'guest'
            ]
        ]);

        DB::table('permission_role')->insert([
            //Admin
            [
                'permission_id' => 1,
                'role_id' => 1,
            ],
            [
                'permission_id' => 2,
                'role_id' => 1,
            ],
            [
                'permission_id' => 3,
                'role_id' => 1,
            ],
            // Manager
            [
                'permission_id' => 2,
                'role_id' => 2,
            ],
            [
                'permission_id' => 3,
                'role_id' => 2,
            ],
            // Guest
            [
                'permission_id' => 3,
                'role_id' => 3,
            ]
        ]);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'role_id' => 1,
        ]);
        User::factory()->create([
            'name' => 'Manager',
            'email' => 'manager@mail.com',
            'role_id' => 2,
        ]);
        User::factory()->create([
            'name' => 'Guest',
            'email' => 'guest@mail.com',
            'role_id' => 3,
        ]);
        User::factory()->count(7)->create();

        Post::factory()->count(30)->create();
    }
}
