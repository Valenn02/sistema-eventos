<?php

namespace App\Http\Controllers;

use App\Models\AsignacionEvento;
use Illuminate\Http\Request;

class AsignacionEventoController extends Controller
{
    public function index()
    {
        $asignaciones = AsignacionEvento::all();
        return response()->json(['data' => $asignaciones], 200);
    }

    public function show($id)
    {
        $asignacion = AsignacionEvento::find($id);

        if (!$asignacion) {
            return response()->json(['message' => 'Asignación de evento no encontrada'], 404);
        }

        return response()->json(['data' => $asignacion], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'evento_id' => 'required|exists:eventos,id',
            'estudiante_id' => 'required|exists:estudiantes,id',
            'rol' => 'required|string|max:255',
        ]);

        $asignacion = new AsignacionEvento([
            'evento_id' => $request->input('evento_id'),
            'estudiante_id' => $request->input('estudiante_id'),
            'rol' => $request->input('rol'),
            'aceptado' => false,
        ]);

        $asignacion->save();

        return response()->json(['message' => 'Asignación de evento creada exitosamente'], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'rol' => 'required|string|max:255',
            'aceptado' => 'required|boolean',
        ]);

        $asignacion = AsignacionEvento::find($id);

        if (!$asignacion) {
            return response()->json(['message' => 'Asignación de evento no encontrada'], 404);
        }

        $asignacion->rol = $request->input('rol');
        $asignacion->aceptado = $request->input('aceptado');

        $asignacion->save();

        return response()->json(['message' => 'Asignación de evento actualizada exitosamente'], 200);
    }

    public function destroy($id)
    {
        $asignacion = AsignacionEvento::find($id);

        if (!$asignacion) {
            return response()->json(['message' => 'Asignación de evento no encontrada'], 404);
        }

        $asignacion->delete();

        return response()->json(['message' => 'Asignación de evento eliminada exitosamente'], 200);
    }
}
