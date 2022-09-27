<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'username' => 'Sarvar',
            'first_name' => 'Sarvar',
            'email' => 'sarvar94@test.com',
            'password' => Hash::make('admin123')
        ]);

        $adminRole = Role::where('slug', 'admin')->first();
        $user->roles()->attach($adminRole->id);
    }
}
