<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use Illuminate\Http\Request;

class EstudianteController extends Controller
{
    // ============================
    //  LISTAR, EDITAR y BUSCAR
    // ============================
    public function index(Request $request)
    {
        $editar = null;

        // Si viene ?id=xx → editar
        if ($request->id) {
            $editar = Estudiante::where('idEstudiante', $request->id)->first();
        }

        // Si viene ?buscar=xxx → filtrar
        if ($request->buscar) {
            $estudiantes = Estudiante::where('nomEstudiante', 'like', "%$request->buscar%")
                ->orWhere('dirEstudiante', 'like', "%$request->buscar%")
                ->orWhere('ciuEstudiante', 'like', "%$request->buscar%")
                ->get();
        } else {
            $estudiantes = Estudiante::all();
        }

        return view('crud', compact('estudiantes', 'editar'));
    }

    // ============================
    //  REGISTRAR
    // ============================
    public function store(Request $request)
    {
        Estudiante::create([
            'nomEstudiante' => $request->nombre,
            'dirEstudiante' => $request->direccion,
            'ciuEstudiante' => $request->ciudad,
        ]);

        return back()->with('mensaje', 'Estudiante registrado');
    }

    // ============================
    //  ACTUALIZAR
    // ============================
    public function update(Request $request, $id)
    {
        $e = Estudiante::where('idEstudiante', $id)->firstOrFail();

        $e->update([
            'nomEstudiante' => $request->nombre,
            'dirEstudiante' => $request->direccion,
            'ciuEstudiante' => $request->ciudad,
        ]);

        return redirect('/')->with('mensaje', 'Estudiante actualizado');

    }

    // ============================
    //  ELIMINAR
    // ============================
    public function destroy($id)
    {
        Estudiante::where('idEstudiante', $id)->delete();
        return back()->with('mensaje', 'Estudiante eliminado');
    }
}
