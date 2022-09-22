<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $adminRole = Role::firstOrCreate([
            'name' => 'Admin',
            'slug' => 'admin',
            'details' => 'This is an admin role'
        ]);

        $user = User::create([
            'username' => 'Sarvar',
            'first_name' => 'Sarvar',
            'email' => 'sarvar94@test.com',
            'password' => Hash::make('admin123')
        ]);

        $user->roles()->attach($adminRole->id);
    }
}
