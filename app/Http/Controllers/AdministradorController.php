<?php

namespace App\Http\Controllers;

use App\Models\Administrador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdministradorController extends Controller
{
    public function index()
    {
        $administradores = Administrador::all();
        return response()->json(['data' => $administradores], 200);
    }

    public function show($id)
    {
        $administrador = Administrador::find($id);

        if (!$administrador) {
            return response()->json(['message' => 'Administrador no encontrado'], 404);
        }

        return response()->json(['data' => $administrador], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo_electronico' => 'required|email|unique:administradores',
            'contrasena' => 'required|string|min:8'
        ]);

        $administrador = new Administrador([
            'nombre' => $request->input('nombre'),
            'correo_electronico' => $request->input('correo_electronico'),
            'contrasena' => Hash::make($request->input('contrasena'))
        ]);

        $administrador->save();

        return response()->json(['message' => 'Administrador creado exitosamente'], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo_electronico' => 'required|email|unique:administradores,correo_electronico,' . $id,
        ]);

        $administrador = Administrador::find($id);

        if (!$administrador) {
            return response()->json(['message' => 'Administrador no encontrado'], 404);
        }

        $administrador->nombre = $request->input('nombre');
        $administrador->correo_electronico = $request->input('correo_electronico');

        $administrador->save();

        return response()->json(['message' => 'Administrador actualizado exitosamente'], 200);
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'contrasena' => 'required|string|min:8',
        ]);

        $administrador = Administrador::find($id);

        if (!$administrador) {
            return response()->json(['message' => 'Administrador no encontrado'], 404);
        }

        $administrador->contrasena = Hash::make($request->input('contrasena'));
        $administrador->save();

        return response()->json(['message' => 'Contraseña actualizada exitosamente'], 200);
    }

    public function destroy($id)
    {
        $administrador = Administrador::find($id);

        if (!$administrador) {
            return response()->json(['message' => 'Administrador no encontrado'], 404);
        }

        $administrador->delete();

        return response()->json(['message' => 'Administrador eliminado exitosamente'], 200);
    }
}
