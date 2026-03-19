<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\Proyecto;
use App\Models\Trabajador;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TrabajadorController extends Controller
{
    private array $rules = [
        'nombre'        => 'required|string|max:100',
        'apellido'      => 'required|string|max:100',
        'email'         => 'required|email|max:150|unique:trabajadores,email',
        'telefono'      => 'nullable|string|max:20',
        'dni'           => 'required|string|max:20|unique:trabajadores,dni',
        'cargo_id'      => 'required|exists:cargos,id',
        'proyecto_id'   => 'required|exists:proyectos,id',
        'estado'        => 'in:activo,inactivo',
        'fecha_ingreso' => 'required|date',
    ];

    private array $messages = [
        'nombre.required'        => 'El nombre es obligatorio.',
        'apellido.required'      => 'El apellido es obligatorio.',
        'email.required'         => 'El email es obligatorio.',
        'email.email'            => 'El email no tiene un formato válido.',
        'email.unique'           => 'El email ya está registrado.',
        'dni.required'           => 'El DNI es obligatorio.',
        'dni.unique'             => 'El DNI ya está registrado.',
        'cargo_id.required'      => 'El cargo es obligatorio.',
        'cargo_id.exists'        => 'El cargo seleccionado no existe.',
        'proyecto_id.required'   => 'El proyecto es obligatorio.',
        'proyecto_id.exists'     => 'El proyecto seleccionado no existe.',
        'fecha_ingreso.required' => 'La fecha de ingreso es obligatoria.',
        'fecha_ingreso.date'     => 'La fecha de ingreso no es válida.',
    ];

    public function index(): JsonResponse
    {
        $trabajadores = Trabajador::with(['cargo', 'proyecto'])
            ->orderBy('nombre')
            ->get()
            ->map(fn($t) => $this->formatTrabajador($t));

        return response()->json(['success' => true, 'data' => $trabajadores]);
    }

    public function show(int $id): JsonResponse
    {
        $trabajador = Trabajador::with(['cargo', 'proyecto'])->find($id);

        if (!$trabajador) {
            return response()->json(['success' => false, 'message' => 'Trabajador no encontrado'], 404);
        }

        return response()->json(['success' => true, 'data' => $this->formatTrabajador($trabajador)]);
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $trabajador = Trabajador::create($request->validate($this->rules, $this->messages));
            $trabajador->load(['cargo', 'proyecto']);

            return response()->json([
                'success' => true,
                'message' => 'Trabajador registrado correctamente.',
                'data'    => $trabajador,
            ], 201);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'message' => 'Error de validación.', 'errors' => $e->errors()], 422);
        }
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $trabajador = Trabajador::find($id);

        if (!$trabajador) {
            return response()->json(['success' => false, 'message' => 'Trabajador no encontrado'], 404);
        }

        try {
            $rules = array_merge($this->rules, [
                'email' => "required|email|max:150|unique:trabajadores,email,{$id}",
                'dni'   => "required|string|max:20|unique:trabajadores,dni,{$id}",
            ]);

            $trabajador->update($request->validate($rules, $this->messages));
            $trabajador->load(['cargo', 'proyecto']);

            return response()->json([
                'success' => true,
                'message' => 'Trabajador actualizado correctamente.',
                'data'    => $trabajador,
            ]);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'message' => 'Error de validación.', 'errors' => $e->errors()], 422);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        $trabajador = Trabajador::find($id);

        if (!$trabajador) {
            return response()->json(['success' => false, 'message' => 'Trabajador no encontrado'], 404);
        }

        $trabajador->estado = $trabajador->estado === 'activo' ? 'inactivo' : 'activo';
        $trabajador->save();

        $accion = $trabajador->estado === 'activo' ? 'activado' : 'desactivado';

        return response()->json(['success' => true, 'message' => "Trabajador {$accion} correctamente."]);
    }

    public function catalogos(): JsonResponse
    {
        return response()->json([
            'success'   => true,
            'cargos'    => Cargo::orderBy('nombre')->get(['id', 'nombre']),
            'proyectos' => Proyecto::orderBy('nombre')->get(['id', 'nombre']),
        ]);
    }

    private function formatTrabajador(Trabajador $t): array
    {
        return [
            'id'               => $t->id,
            'nombre'           => $t->nombre,
            'apellido'         => $t->apellido,
            'nombre_completo'  => "{$t->nombre} {$t->apellido}",
            'email'            => $t->email,
            'telefono'         => $t->telefono,
            'dni'              => $t->dni,
            'cargo_id'         => $t->cargo_id,
            'cargo'            => $t->cargo?->nombre,
            'proyecto_id'      => $t->proyecto_id,
            'proyecto'         => $t->proyecto?->nombre,
            'estado'           => $t->estado,
            'fecha_ingreso'    => $t->fecha_ingreso?->format('Y-m-d'),
        ];
    }
}
