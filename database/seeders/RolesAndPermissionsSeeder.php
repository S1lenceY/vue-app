<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear permisos
        Permission::create(['name' => 'CREATE_LLAMADA']);
        Permission::create(['name' => 'EDIT_LLAMADA']);
        Permission::create(['name' => 'DELETE_LLAMADA']);
        Permission::create(['name' => 'VIEW_LLAMADA']);

        // Crear roles y asignar permisos
        $admin = Role::create(['name' => 'Admin']);
        $admin->givePermissionTo(Permission::all()); // Admin tiene todos los permisos

        $user = Role::create(['name' => 'User']);
        $user->givePermissionTo(['CREATE_LLAMADA', 'VIEW_LLAMADA', 'DELETE_LLAMADA']); // User solo puede crear, ver y eliminar

        // Asignar roles a usuarios
        $adminUser = \App\Models\User::find(1); // Suponiendo que el usuario con ID 1 es admin
        $adminUser->assignRole('Admin');

        //$normalUser = \App\Models\User::find(3); // Suponiendo que el usuario con ID 2 es un usuario normal
        //$normalUser->assignRole('User');
    }
}
