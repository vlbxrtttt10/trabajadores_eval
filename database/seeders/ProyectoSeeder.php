<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProyectoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('proyectos')->insert([
            ['nombre' => 'Sistema ERP Corporativo',  'descripcion' => 'Módulo de gestión empresarial',    'fecha_inicio' => '2025-01-15', 'fecha_fin' => '2025-12-31', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'App Móvil de Pagos',       'descripcion' => 'Aplicación para pagos móviles',    'fecha_inicio' => '2025-03-01', 'fecha_fin' => '2025-09-30', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Portal Web Institucional', 'descripcion' => 'Rediseño del portal público',      'fecha_inicio' => '2025-02-01', 'fecha_fin' => '2025-07-31', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Plataforma E-learning',    'descripcion' => 'Sistema de formación en línea',    'fecha_inicio' => '2025-04-01', 'fecha_fin' => '2026-03-31', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'API Gateway Microserv.',   'descripcion' => 'Integración de microservicios',    'fecha_inicio' => '2025-05-01', 'fecha_fin' => '2025-11-30', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
