<?php

namespace App\Http\Controllers;

use App\Models\CategoriaEvento;
use Illuminate\Http\Request;

class CategoriaEventoController extends Controller
{
    public function index()
    {
        $categorias = CategoriaEvento::all();
        return response()->json(['data' => $categorias], 200);
    }

    public function show($id)
    {
        $categoria = CategoriaEvento::find($id);

        if (!$categoria) {
            return response()->json(['message' => 'Categoría de evento no encontrada'], 404);
        }

        return response()->json(['data' => $categoria], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $categoria = new CategoriaEvento([
            'nombre' => $request->input('nombre'),
        ]);

        $categoria->save();

        return response()->json(['message' => 'Categoría de evento creada exitosamente'], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $categoria = CategoriaEvento::find($id);

        if (!$categoria) {
            return response()->json(['message' => 'Categoría de evento no encontrada'], 404);
        }

        $categoria->nombre = $request->input('nombre');

        $categoria->save();

        return response()->json(['message' => 'Categoría de evento actualizada exitosamente'], 200);
    }

    public function destroy($id)
    {
        $categoria = CategoriaEvento::find($id);

        if (!$categoria) {
            return response()->json(['message' => 'Categoría de evento no encontrada'], 404);
        }

        $categoria->delete();

        return response()->json(['message' => 'Categoría de evento eliminada exitosamente'], 200);
    }
}
