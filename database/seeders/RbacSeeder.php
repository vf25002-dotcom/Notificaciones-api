<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RbacSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Crear Permisos
        $permissions = [
            [
                'PERM_CODE' => 'view_notifications',
                'PERM_NAME' => 'Ver Notificaciones',
                'PERM_DESCRIPTION' => 'Permite ver la lista y detalle de notificaciones',
            ],
            [
                'PERM_CODE' => 'create_notifications',
                'PERM_NAME' => 'Crear Notificaciones',
                'PERM_DESCRIPTION' => 'Permite crear nuevas notificaciones',
            ],
            [
                'PERM_CODE' => 'mark_notifications_read',
                'PERM_NAME' => 'Marcar Leído',
                'PERM_DESCRIPTION' => 'Permite marcar notificaciones como leídas',
            ],
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['PERM_CODE' => $perm['PERM_CODE']], $perm);
        }

        // 2. Crear Roles
        $adminRole = Role::firstOrCreate(['ROLE_CODE' => 'admin'], [
            'ROLE_NAME' => 'Administrador',
            'ROLE_DESCRIPTION' => 'Acceso total',
        ]);

        $userRole = Role::firstOrCreate(['ROLE_CODE' => 'user'], [
            'ROLE_NAME' => 'Usuario',
            'ROLE_DESCRIPTION' => 'Acceso limitado',
        ]);

        // 3. Asignar Permisos a Roles
        // Admin tiene todo
        $allPermissions = Permission::all();
        $adminRole->permissions()->sync($allPermissions->pluck('ID'));

        // Usuario solo puede ver
        $viewPerm = Permission::where('PERM_CODE', 'view_notifications')->first();
        $userRole->permissions()->sync([$viewPerm->ID]);

        // 4. Crear Usuarios de prueba
        $adminUser = Usuario::firstOrCreate(['USUARIO' => 'admin@admin.com'], [
            'PASSWORD' => Hash::make('password'),
            'SUCURSAL' => 'Central',
        ]);
        $adminUser->roles()->syncWithoutDetaching([$adminRole->ROLE_ID]);

        $normalUser = Usuario::firstOrCreate(['USUARIO' => 'user@user.com'], [
            'PASSWORD' => Hash::make('password'),
            'SUCURSAL' => 'Sucursal 1',
        ]);
        $normalUser->roles()->syncWithoutDetaching([$userRole->ROLE_ID]);
    }
}
