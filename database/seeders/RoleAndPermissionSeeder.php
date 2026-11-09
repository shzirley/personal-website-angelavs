<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'lihat-proyek', 'tambah-proyek', 'edit-proyek', 'hapus-proyek',
            'lihat-prestasi', 'tambah-prestasi', 'edit-prestasi', 'hapus-prestasi',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        Role::firstOrCreate(['name' => 'Admin'])->syncPermissions($permissions);
        Role::firstOrCreate(['name' => 'Staf'])->syncPermissions(array_diff($permissions, ['hapus-proyek', 'hapus-prestasi']));
    }
}
