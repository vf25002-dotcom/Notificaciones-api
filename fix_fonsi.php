<?php

use App\Models\Usuario;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Buscando usuario Fonsi@gmail.com...\n";

// Borrar si existe para asegurarnos de que quede limpio
$existing = Usuario::where('USUARIO', 'Fonsi@gmail.com')->first();
if ($existing) {
    echo "Usuario existente encontrado. Eliminando...\n";
    $existing->forceDelete();
}

echo "Creando usuario Fonsi@gmail.com en la tabla 'usuarios'...\n";

$user = new Usuario();
$user->USUARIO = 'Fonsi@gmail.com';
$user->PASSWORD = Hash::make('Fonsi');
$user->SUCURSAL = 'Central';
$user->save();

// Asignar rol de usuario
$role = Role::where('ROLE_CODE', 'user')->first();
if ($role) {
    $user->roles()->attach($role->ROLE_ID);
    echo "Rol asignado correctamente.\n";
}

echo "Usuario creado exitosamente.\n";
echo "ID: " . $user->ID . "\n";
echo "Usuario: " . $user->USUARIO . "\n";
echo "Password Hash: " . $user->PASSWORD . "\n";
