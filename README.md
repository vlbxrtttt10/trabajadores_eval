# Módulo de Trabajadores

Sistema de gestión de trabajadores desarrollado con Laravel 12, Bootstrap 5, jQuery y MySQL.

---

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
| Frontend | Bootstrap 5.3, jQuery 3.7, Notiflix 3.2 |
| Base de datos | MySQL |
| Servidor | Apache (XAMPP) |

---

## Instalación

### 1. Clonar / copiar el proyecto

Colocar la carpeta del proyecto en:

```
C:\xampp\htdocs\trabajadores\
```

### 2. Instalar dependencias PHP

```bash
composer install
```

### 3. Configurar variables de entorno

Copiar el archivo de ejemplo y editarlo:

```bash
cp .env.example .env
```

Ajustar las credenciales de base de datos en `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=trabajadores_db
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generar la clave de la aplicación

```bash
php artisan key:generate
```

### 5. Crear la base de datos

Desde phpMyAdmin o MySQL CLI, crear la base de datos:

```sql
CREATE DATABASE trabajadores_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 6. Ejecutar migraciones y seeders

```bash
php artisan migrate --seed
```

Esto crea todas las tablas y carga los datos de ejemplo (6 cargos, 5 proyectos, 10 trabajadores).

---

## Acceso a la aplicación

Con XAMPP corriendo (Apache + MySQL):

```
http://localhost/trabajadores/public/
```

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

## Script SQL alternativo

Si se prefiere importar la base de datos directamente sin Artisan, usar el script incluido:

```
database/trabajadores_db.sql
```

Importar desde phpMyAdmin o por CLI:

```bash
mysql -u root trabajadores_db < database/trabajadores_db.sql
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
