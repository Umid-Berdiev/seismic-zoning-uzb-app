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
        $user1 = User::create([
            'username' => 'Sarvar',
            'first_name' => 'Sarvar',
            'email' => 'sarvar94@test.com',
            'password' => Hash::make('admin123')
        ]);

        $adminRole = Role::where('slug', 'admin')->first();
        $user1->roles()->attach($adminRole->id);

        $user2 = User::create([
            'username' => 'Visitor',
            'first_name' => 'Eshmat',
            'email' => 'eshamt33@test.com',
            'password' => Hash::make('visitor123')
        ]);

        $visitorRole = Role::where('slug', 'visitor')->first();
        $user2->roles()->attach($visitorRole->id);
    }
}
