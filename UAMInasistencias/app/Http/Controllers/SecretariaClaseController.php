<?php

namespace App\Http\Controllers;

use App\Models\Asignatura;
use App\Models\Profesor;
use Illuminate\Http\Request;

class SecretariaClaseController extends Controller
{
    public function index()
    {
        $asignaturas = Asignatura::with('profesor.user')->get();
        return view('secretaria.clases.index', compact('asignaturas'));
    }

    public function create()
    {
        $profesores = Profesor::with('user')->get();
        return view('secretaria.clases.create', compact('profesores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'profesor_id' => 'nullable|exists:profesores,id',
        ]);

        Asignatura::create($request->only('codigo', 'nombre', 'profesor_id'));

        return redirect()->route('secretaria.clases.index')->with('success', 'Asignatura registrada correctamente.');
    }

    public function edit(Asignatura $asignatura)
    {
        $profesores = Profesor::with('user')->get();
        return view('secretaria.clases.edit', compact('asignatura', 'profesores'));
    }

    public function update(Request $request, Asignatura $asignatura)
    {
        $request->validate([
            'codigo' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'profesor_id' => 'nullable|exists:profesores,id',
        ]);

        $asignatura->update($request->only('codigo', 'nombre', 'profesor_id'));

        return redirect()->route('secretaria.clases.index')->with('success', 'Asignatura actualizada correctamente.');
    }

    public function destroy(Asignatura $asignatura)
    {
        $asignatura->delete();

        return redirect()->route('secretaria.clases.index')->with('success', 'Asignatura eliminada correctamente.');
    }
} 