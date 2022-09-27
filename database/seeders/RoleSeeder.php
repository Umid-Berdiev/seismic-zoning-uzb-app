<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::insert([
            [
                'name' => 'Admin',
                'slug' => 'admin',
                'details' => 'This is an admin role'
            ],
            [
                'name' => 'Operator',
                'slug' => 'operator',
                'details' => 'This is an operator role'
            ],
            [
                'name' => 'Visitor',
                'slug' => 'visitor',
                'details' => 'This is a visitor role'
            ]
        ]);
    }
}
