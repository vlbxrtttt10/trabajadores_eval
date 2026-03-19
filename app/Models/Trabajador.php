<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trabajador extends Model
{
    protected $table = 'trabajadores';

    protected $fillable = [
        'nombre', 'apellido', 'email', 'telefono', 'dni',
        'cargo_id', 'proyecto_id', 'estado', 'fecha_ingreso'
    ];

    protected $casts = [
        'fecha_ingreso' => 'date',
    ];

    public function cargo()
    {
        return $this->belongsTo(Cargo::class);
    }

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
    }
}
