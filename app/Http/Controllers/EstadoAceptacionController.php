<?php

namespace App\Http\Controllers;

use App\Models\EstadoAceptacion;
use Illuminate\Http\Request;

class EstadoAceptacionController extends Controller
{
    public function index()
    {
        $estados = EstadoAceptacion::all();
        return response()->json(['data' => $estados], 200);
    }

    public function show($id)
    {
        $estado = EstadoAceptacion::find($id);

        if (!$estado) {
            return response()->json(['message' => 'Estado de aceptación no encontrado'], 404);
        }

        return response()->json(['data' => $estado], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $estado = new EstadoAceptacion([
            'nombre' => $request->input('nombre'),
        ]);

        $estado->save();

        return response()->json(['message' => 'Estado de aceptación creado exitosamente'], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $estado = EstadoAceptacion::find($id);

        if (!$estado) {
            return response()->json(['message' => 'Estado de aceptación no encontrado'], 404);
        }

        $estado->nombre = $request->input('nombre');

        $estado->save();

        return response()->json(['message' => 'Estado de aceptación actualizado exitosamente'], 200);
    }

    public function destroy($id)
    {
        $estado = EstadoAceptacion::find($id);

        if (!$estado) {
            return response()->json(['message' => 'Estado de aceptación no encontrado'], 404);
        }

        $estado->delete();

        return response()->json(['message' => 'Estado de aceptación eliminado exitosamente'], 200);
    }
}
