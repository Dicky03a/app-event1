<?php

namespace Database\Seeders;

use App\Models\Organization;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Organization::create([
            'name' => 'Organisasi Contoh 1',
            'slug' => 'organisasi-contoh-1',
            'description' => 'Ini adalah organisasi contoh pertama untuk demo',
            'address' => 'Jl. Contoh No. 123, Jakarta',
            'phone' => '021-12345678',
            'email' => 'org1@example.com',
            'status' => 'active',
        ]);

        Organization::create([
            'name' => 'Organisasi Contoh 2',
            'slug' => 'organisasi-contoh-2',
            'description' => 'Ini adalah organisasi contoh kedua untuk demo',
            'address' => 'Jl. Demo No. 456, Bandung',
            'phone' => '022-87654321',
            'email' => 'org2@example.com',
            'status' => 'active',
        ]);
    }
}
