<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // 1. Crear Roles
        $roles = [
            ['name' => 'Administrador',
            'slug' => 'Admin'],
             ['name' => 'Ciudadano',
            'slug' => 'Ciud'],
            ['name' => 'Director',
            'slug' => 'Dir'],
             ['name' => 'Ventanilla',
            'slug' => 'Vent'],
           
        ];

        foreach ($roles as $role) {
            DB::table('roles')->updateOrInsert(['name' => $role['name']], $role);
        }

        // 2. Crear Áreas (Servicios Municipales)
        $areas = [
            ['name' => 'Alumbrado Público'],
            
            ['name' => 'Agua Potable'],
            ['name' => 'Aseo Público'],
            ['name' => 'Parques y Jardines'],
        ];

        foreach ($areas as $area) {
            DB::table('areas')->updateOrInsert(['name' => $area['name']], $area);
        }

        // 3. Crear Usuarios de prueba
        // Obtenemos los IDs para asegurar la relación
        $adminRoleId = DB::table('roles')->where('name', 'Administrador')->value('id');
        $ciudadanoRoleId = DB::table('roles')->where('name', 'Ciudadano')->value('id');

        DB::table('users')->insert([
            [
                'name' => 'Usuario Admin',
                'email' => 'admin@ejemplo.com',
                'password' => Hash::make('password'),
                'role_id' => $adminRoleId,
            ],
            [
                'name' => 'Juan Pérez',
                'email' => 'juan@ejemplo.com',
                'password' => Hash::make('password'),
                'role_id' => $ciudadanoRoleId,
            ]
        ]);
    }
}
