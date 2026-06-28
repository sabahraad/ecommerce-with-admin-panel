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
            'view admin dashboard',
            'manage products',
            'manage categories',
            'manage orders',
            'manage users',
            'manage roles',
            'manage permissions',
            'view orders',
            'update order status',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());

        $manager = Role::create(['name' => 'manager']);
        $manager->givePermissionTo([
            'view admin dashboard',
            'manage products',
            'manage categories',
            'manage orders',
        ]);

        $support = Role::create(['name' => 'support']);
        $support->givePermissionTo([
            'view admin dashboard',
            'view orders',
            'update order status',
        ]);

        Role::create(['name' => 'customer']);
    }
}
