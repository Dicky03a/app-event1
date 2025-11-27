<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Event permissions (as per requirements)
            'event.create',
            'event.view',
            'event.update',
            'event.delete',
            'event.approve',

            // Organization permissions
            'organization.view',
            'organization.create',
            'organization.update',
            'organization.delete',

            // Other permissions
            'manage_organizations',
            'manage_users',
            'manage_roles',
            'manage_events',
            'approve_events',
            'view_events',
            'manage_certificates',
            'view_certificates',
            'manage_registrations',
            'view_registrations',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions

        // Super Admin - has all permissions
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);
        $superAdmin->givePermissionTo(Permission::all());

        // Admin - organization admin
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->givePermissionTo([
            'event.create',
            'event.view',
            'event.update',
            'event.delete',
            'manage_organizations',
            'organization.view',
            'organization.update',
            'manage_events',
            'approve_events',
            'view_events',
            'manage_certificates',
            'view_certificates',
            'manage_registrations',
            'view_registrations',
        ]);

        // User - regular user
        $user = Role::firstOrCreate(['name' => 'user']);
        $user->givePermissionTo([
            'event.view',
            'view_events',
            'view_certificates',
            'manage_registrations',
            'view_registrations',
        ]);
    }
}
