<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use Illuminate\Http\Request;

class EstudianteController extends Controller
{
    public function getAllEstudiantes()
    {
        $estudiantes = Estudiante::all();
        return response()->json(['data' => $estudiantes], 200);
    }

    public function getEstudianteById($id)
    {
        $estudiante = Estudiante::find($id);

        if (!$estudiante) {
            return response()->json(['message' => 'Estudiante no encontrado'], 404);
        }

        return response()->json(['data' => $estudiante], 200);
    }

    public function crearEstudiante(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'correo_electronico' => 'required|email|unique:estudiantes',
        ]);

        $estudiante = new Estudiante([
            'nombre' => $request->input('nombre'),
            'apellidos' => $request->input('apellidos'),
            'correo_electronico' => $request->input('correo_electronico'),
        ]);

        $estudiante->save();

        return response()->json(['message' => 'Estudiante creado exitosamente'], 201);
    }

    public function updateEstudiante(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'correo_electronico' => 'required|email|unique:estudiantes,correo_electronico,' . $id,
        ]);

        $estudiante = Estudiante::find($id);

        if (!$estudiante) {
            return response()->json(['message' => 'Estudiante no encontrado'], 404);
        }

        $estudiante->nombre = $request->input('nombre');
        $estudiante->apellidos = $request->input('apellidos');
        $estudiante->correo_electronico = $request->input('correo_electronico');

        $estudiante->save();

        return response()->json(['message' => 'Estudiante actualizado exitosamente'], 200);
    }

    public function deleteEstudiante($id)
    {
        $estudiante = Estudiante::find($id);

        if (!$estudiante) {
            return response()->json(['message' => 'Estudiante no encontrado'], 404);
        }

        $estudiante->delete();

        return response()->json(['message' => 'Estudiante eliminado exitosamente'], 200);
    }
}
