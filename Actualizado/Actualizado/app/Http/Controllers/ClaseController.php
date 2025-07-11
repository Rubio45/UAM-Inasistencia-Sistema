<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use App\Models\Profesor;
use Illuminate\Http\Request;

class ClaseController extends Controller
{
    public function index()
    {
        $clases = Clase::with('profesor')->get();
        return view('secretaria.clases.index', compact('clases'));
    }

    public function create()
    {
        $profesores = Profesor::all();
        return view('secretaria.clases.create', compact('profesores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|max:50|unique:clases',
            'profesor_id' => 'required|exists:profesores,id',
            'horario' => 'nullable|string|max:100',
        ]);

        Clase::create($request->all());

        return redirect()->route('clases.index')->with('success', 'Clase creada correctamente.');
    }

    public function edit(Clase $clase)
    {
        $profesores = Profesor::all();
        return view('secretaria.clases.edit', compact('clase', 'profesores'));
    }

    public function update(Request $request, Clase $clase)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|max:50|unique:clases,codigo,' . $clase->id,
            'profesor_id' => 'required|exists:profesores,id',
            'horario' => 'nullable|string|max:100',
        ]);

        $clase->update($request->all());

        return redirect()->route('clases.index')->with('success', 'Clase actualizada.');
    }

    public function destroy(Clase $clase)
    {
        $clase->delete();
        return redirect()->route('clases.index')->with('success', 'Clase eliminada.');
    }
}
