<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\Area;
use App\Models\Puesto;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed de Roles
        $roles = [
            ['id' => 1, 'nombre' => 'Administrador', 'descripcion' => 'Gestión completa del sistema y usuarios'],
            ['id' => 2, 'nombre' => 'Responsable UCC', 'descripcion' => 'Recepción, clasificación y registro de correspondencia'],
            ['id' => 3, 'nombre' => 'Recursos Materiales', 'descripcion' => 'Control logístico y despacho de correspondencia externa'],
            ['id' => 4, 'nombre' => 'Mensajero', 'descripcion' => 'Entrega externa y registro de acuses'],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(['id' => $role['id']], $role);
        }

        // 2. Seed de Áreas
        $areas = ['Dirección', 'Jurídico', 'Finanzas', 'Recursos Humanos'];
        foreach ($areas as $area) {
            Area::firstOrCreate(['nombre' => $area]);
        }

        // 3. Seed de Puestos
        $puestos = ['Director', 'Secretario', 'Coordinador'];
        foreach ($puestos as $puesto) {
            Puesto::firstOrCreate(['nombre' => $puesto]);
        }

        // 4. Usuario Administrador por defecto para entrar al sistema
        User::firstOrCreate(
            ['email' => 'admin@sistema.com'],
            [
                'role_id' => 1,
                'nombre' => 'Admin',
                'apellido_paterno' => 'Sistema',
                'apellido_materno' => 'UCC',
                'password' => Hash::make('password123'),
                'estado' => 'activo',
            ]
        );
    }
}