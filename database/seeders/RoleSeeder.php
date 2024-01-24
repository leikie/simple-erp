<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        #role yg bisa mengakses aplikasi
        $visitor = Role::create(['name' => 'visitor']);
        $visitor->syncPermissions(['menu-order', 'order-create', 'order-print']);

        $super_admin = Role::create(['name' => 'super admin']);
        $super_admin->syncPermissions([
            'role-create',
            'role-edit',
            'role-delete',

            'product-create',
            'product-edit',
            'product-delete',

            'order-create',
            'order-edit',
            'order-delete',
            'order-print',

            'menu-role',
            'menu-permission',
            'menu-product',
            'menu-user',
            'menu-order',

            'user-create',
            'user-edit',
            'user-delete'
        ]);

        $admin = Role::create(['name' => 'admin']);
        $admin->syncPermissions(['menu-user', 'menu-order', 'order-create', 'order-edit', 'order-print']);
    }
}
