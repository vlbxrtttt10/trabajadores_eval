<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Cargo;
use App\Models\Proyecto;

class TrabajadorSeeder extends Seeder
{
    public function run(): void
    {
        $cargos    = Cargo::orderBy('id')->pluck('id')->values();
        $proyectos = Proyecto::orderBy('id')->pluck('id')->values();

        DB::table('trabajadores')->insert([
            ['nombre' => 'Carlos',   'apellido' => 'Ramírez',  'email' => 'carlos.ramirez@empresa.com',   'telefono' => '999001001', 'dni' => '12345678', 'cargo_id' => $cargos[0], 'proyecto_id' => $proyectos[0], 'estado' => 'activo',   'fecha_ingreso' => '2023-01-15', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'María',    'apellido' => 'López',    'email' => 'maria.lopez@empresa.com',      'telefono' => '999001002', 'dni' => '23456789', 'cargo_id' => $cargos[1], 'proyecto_id' => $proyectos[1], 'estado' => 'activo',   'fecha_ingreso' => '2023-03-01', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'José',     'apellido' => 'García',   'email' => 'jose.garcia@empresa.com',      'telefono' => '999001003', 'dni' => '34567890', 'cargo_id' => $cargos[2], 'proyecto_id' => $proyectos[2], 'estado' => 'activo',   'fecha_ingreso' => '2022-08-20', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Ana',      'apellido' => 'Torres',   'email' => 'ana.torres@empresa.com',       'telefono' => '999001004', 'dni' => '45678901', 'cargo_id' => $cargos[3], 'proyecto_id' => $proyectos[0], 'estado' => 'activo',   'fecha_ingreso' => '2021-11-05', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Luis',     'apellido' => 'Martínez', 'email' => 'luis.martinez@empresa.com',    'telefono' => '999001005', 'dni' => '56789012', 'cargo_id' => $cargos[4], 'proyecto_id' => $proyectos[3], 'estado' => 'activo',   'fecha_ingreso' => '2024-02-10', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Sofía',    'apellido' => 'Herrera',  'email' => 'sofia.herrera@empresa.com',    'telefono' => '999001006', 'dni' => '67890123', 'cargo_id' => $cargos[5], 'proyecto_id' => $proyectos[4], 'estado' => 'activo',   'fecha_ingreso' => '2023-06-18', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Miguel',   'apellido' => 'Flores',   'email' => 'miguel.flores@empresa.com',    'telefono' => '999001007', 'dni' => '78901234', 'cargo_id' => $cargos[0], 'proyecto_id' => $proyectos[1], 'estado' => 'activo',   'fecha_ingreso' => '2024-01-08', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Valeria',  'apellido' => 'Castro',   'email' => 'valeria.castro@empresa.com',   'telefono' => '999001008', 'dni' => '89012345', 'cargo_id' => $cargos[1], 'proyecto_id' => $proyectos[2], 'estado' => 'inactivo', 'fecha_ingreso' => '2022-05-30', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Roberto',  'apellido' => 'Díaz',     'email' => 'roberto.diaz@empresa.com',     'telefono' => '999001009', 'dni' => '90123456', 'cargo_id' => $cargos[2], 'proyecto_id' => $proyectos[3], 'estado' => 'activo',   'fecha_ingreso' => '2023-09-12', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Patricia', 'apellido' => 'Sánchez',  'email' => 'patricia.sanchez@empresa.com', 'telefono' => '999001010', 'dni' => '01234567', 'cargo_id' => $cargos[3], 'proyecto_id' => $proyectos[4], 'estado' => 'activo',   'fecha_ingreso' => '2024-04-22', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
