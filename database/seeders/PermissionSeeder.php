<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
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
        ];
        
        foreach ($permissions as $permission) :
            Permission::create(['name' => $permission]);
        endforeach;
    }
}
