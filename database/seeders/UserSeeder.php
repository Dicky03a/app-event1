<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Super Admin - no organization
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password'),
            'organization_id' => null,
        ]);
        $superAdmin->assignRole('super-admin');

        // Admin for Organization 1
        $admin1 = User::create([
            'name' => 'Admin Organisasi 1',
            'email' => 'admin1@example.com',
            'password' => Hash::make('password'),
            'organization_id' => 1,
        ]);
        $admin1->assignRole('admin');

        // Admin for Organization 2
        $admin2 = User::create([
            'name' => 'Admin Organisasi 2',
            'email' => 'admin2@example.com',
            'password' => Hash::make('password'),
            'organization_id' => 2,
        ]);
        $admin2->assignRole('admin');

        // Regular user for Organization 1
        $user1 = User::create([
            'name' => 'User Organisasi 1',
            'email' => 'user1@example.com',
            'password' => Hash::make('password'),
            'organization_id' => 1,
        ]);
        $user1->assignRole('user');

        // Regular user for Organization 2
        $user2 = User::create([
            'name' => 'User Organisasi 2',
            'email' => 'user2@example.com',
            'password' => Hash::make('password'),
            'organization_id' => 2,
        ]);
        $user2->assignRole('user');
    }
}
