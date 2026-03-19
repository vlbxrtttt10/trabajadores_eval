# Módulo de Trabajadores

## Requisitos

- PHP 8.2+
- Composer 2+
- MySQL 5.7+
- XAMPP (o servidor Apache equivalente)

---

## Stack tecnológico

| Capa | Tecnología |
|------|-----------|
| Backend | Laravel 12, PHP 8.2 |
| Frontend | Bootstrap 5.3, jQuery 3.7 |
| Base de datos | MySQL |
| Servidor | Apache (XAMPP) |

---

## Endpoints API

Base URL: `http://localhost/trabajadores/public/api`

| Método | Endpoint | Descripción |
|--------|----------|-------------|
| GET | `/trabajadores` | Listar todos los trabajadores |
| POST | `/trabajadores` | Registrar un trabajador |
| GET | `/trabajadores/{id}` | Ver detalle de un trabajador |
| PUT | `/trabajadores/{id}` | Editar un trabajador |
| DELETE | `/trabajadores/{id}` | Activar / desactivar un trabajador |
| GET | `/trabajadores/catalogos` | Obtener cargos y proyectos disponibles |

### Ejemplo de body para POST / PUT

```json
{
    "nombre": "Juan",
    "apellido": "Pérez",
    "dni": "12345678",
    "email": "juan.perez@empresa.com",
    "telefono": "999888777",
    "cargo_id": 1,
    "proyecto_id": 2,
    "estado": "activo",
    "fecha_ingreso": "2024-01-15"
}
```

---

## Estructura del proyecto

```
app/
├── Http/Controllers/TrabajadorController.php
└── Models/
    ├── Cargo.php
    ├── Proyecto.php
    └── Trabajador.php

database/
├── migrations/
│   ├── create_cargos_table.php
│   ├── create_proyectos_table.php
│   └── create_trabajadores_table.php
├── seeders/
│   ├── CargoSeeder.php
│   ├── ProyectoSeeder.php
│   └── TrabajadorSeeder.php
└── trabajadores_db.sql

public/
├── css/trabajadores.css
└── js/
    ├── trabajadores.js
    └── notiflix-aio.min.js

resources/views/
└── trabajadores.blade.php

routes/
├── api.php
└── web.php
```


---

## Funcionalidades

- Listar trabajadores con paginación visual
- Registrar nuevo trabajador con validaciones frontend y backend
- Editar trabajador existente
- Ver detalle en modal
- Activar / desactivar trabajador (toggle de estado)
- Notificaciones con Notiflix
- Confirmaciones antes de cambios de estado
