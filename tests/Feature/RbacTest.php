<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\Role;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class RbacTest extends TestCase
{
    use RefreshDatabase;

    public function test_rbac_structure_and_middleware()
    {
        // 1. Crear Permiso
        $permission = Permission::create([
            'PERM_CODE' => 'view_dashboard',
            'PERM_NAME' => 'View Dashboard',
            'PERM_DESCRIPTION' => 'Can view dashboard',
        ]);

        // 2. Crear Rol
        $role = Role::create([
            'ROLE_CODE' => 'admin',
            'ROLE_NAME' => 'Administrator',
        ]);

        // 3. Asignar Permiso al Rol
        $role->permissions()->attach($permission->ID);

        // 4. Crear Usuario
        $user = Usuario::create([
            'USUARIO' => 'admin',
            'PASSWORD' => Hash::make('password'),
            'SUCURSAL' => 'Main',
        ]);

        // 5. Asignar Rol al Usuario
        $user->roles()->attach($role->ROLE_ID);

        // Verificar relaciones
        $this->assertTrue($user->roles->contains($role));
        $this->assertTrue($role->permissions->contains($permission));
        $this->assertTrue($user->hasPermission('view_dashboard'));
        $this->assertFalse($user->hasPermission('delete_users'));

        // 6. Probar Middleware
        Route::get('/test-rbac', function () {
            return 'OK';
        })->middleware('permission:view_dashboard');

        // Intento sin autenticación
        $this->getJson('/test-rbac')
            ->assertStatus(401);

        // Intento con usuario autenticado
        $this->actingAs($user)
            ->getJson('/test-rbac')
            ->assertStatus(200)
            ->assertSee('OK');

        // Intento con usuario sin permiso
        $userNoPerm = Usuario::create([
            'USUARIO' => 'guest',
            'PASSWORD' => Hash::make('password'),
        ]);

        $this->actingAs($userNoPerm)
            ->getJson('/test-rbac')
            ->assertStatus(403);
    }
}
