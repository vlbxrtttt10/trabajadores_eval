<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CargoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('cargos')->insert([
            ['nombre' => 'Desarrollador Backend',  'descripcion' => 'Desarrollo de APIs y servicios',        'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Desarrollador Frontend', 'descripcion' => 'Desarrollo de interfaces de usuario',   'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Diseñador UX/UI',        'descripcion' => 'Diseño de experiencia de usuario',      'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Project Manager',        'descripcion' => 'Gestión y planificación de proyectos',  'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Analista de QA',         'descripcion' => 'Control de calidad y pruebas',          'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'DevOps Engineer',        'descripcion' => 'Infraestructura y despliegue continuo', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
