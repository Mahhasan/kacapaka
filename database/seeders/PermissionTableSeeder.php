<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
           'role-list',
           'role-create',
           'role-edit',
           'role-delete',
           'product-list',
           'product-create',
           'product-edit',
           'product-delete',
           'user-list',
           'user-create',
           'user-edit',
           'user-delete',
           'category-list',
           'category-create',
           'category-edit',
           'category-delete',
           'sub-category-list',
           'sub-category-create',
           'sub-category-edit',
           'sub-category-delete'
        ];

        // Use first time project
        // foreach ($permissions as $permission) {
        //      Permission::create(['name' => $permission]);
        // }
        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'web'); // This prevents duplicates (use in running project to add some role)
        }
    }
}
