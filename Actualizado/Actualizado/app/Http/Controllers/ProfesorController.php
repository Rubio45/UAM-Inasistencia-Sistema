<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profesor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProfesorController extends Controller
{
    public function index()
    {
        $profesores = Profesor::with('user')->get();
        return view('secretaria.profesores.index', compact('profesores'));
    }

    public function create()
    {
        return view('secretaria.profesores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'    => 'required|string|max:255',
            'apellido'  => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'cif'       => 'required|string|max:50|unique:users,cif',
            'facultad'  => 'required|string|max:100',
        ]);

        $password = Str::random(10); // Contraseña aleatoria segura

        $user = User::create([
            'name'      => $request->nombre,
            'apellido'  => $request->apellido,
            'email'     => $request->email,
            'password'  => Hash::make($password),
            'cif'       => $request->cif,
            'carrera'   => $request->facultad,
            'role'      => 'profesor'
        ]);

        Profesor::create([
            'user_id'   => $user->id,
            'apellido'  => $request->apellido,
            'cif'       => $request->cif,
            'facultad'  => $request->facultad,
        ]);

        return redirect()->route('profesores.index')->with('success', 'Profesor registrado exitosamente.');
    }

    public function edit(Profesor $profesor)
    {
        return view('secretaria.profesores.edit', compact('profesor'));
    }

    public function update(Request $request, Profesor $profesor)
    {
        $request->validate([
            'apellido' => 'required|string|max:255',
        ]);

        $profesor->update([
            'apellido' => $request->apellido,
        ]);

        return redirect()->route('profesores.index')->with('success', 'Profesor actualizado correctamente.');
    }

    public function destroy(Profesor $profesor)
    {
        $profesor->delete();
        return redirect()->route('profesores.index')->with('success', 'Profesor eliminado.');
    }
}
