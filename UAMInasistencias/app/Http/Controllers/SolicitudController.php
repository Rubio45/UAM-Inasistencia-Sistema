<?php

namespace App\Http\Controllers;

use App\Models\Solicitud;
use App\Models\Estudiante;
use App\Models\Profesor;
use App\Models\SecretariaAcademica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SolicitudController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mostrar solicitudes según el rol
        $user = Auth::user();
        if ($user->isEstudiante()) {
            $solicitudes = $user->estudiante->solicitudes()->latest()->get();
        } elseif ($user->isProfesor()) {
            $solicitudes = Solicitud::where('profesor_id', $user->profesor->id)->latest()->get();
        } elseif ($user->isSecretariaAcademica()) {
            $solicitudes = Solicitud::where('secretaria_id', $user->secretariaAcademica->id)->latest()->get();
        } else {
            $solicitudes = collect();
        }
        return view('solicitudes.index', compact('solicitudes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $profesores = \App\Models\Profesor::with('asignaturas')->get();
        $asignaturas = \App\Models\Asignatura::all();
        return view('solicitudes.create', compact('profesores', 'asignaturas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        // Solo estudiantes pueden crear solicitudes
        if (!$user->isEstudiante()) {
            return redirect()->route('solicitudes.index')->with('error', 'Solo los estudiantes pueden crear solicitudes.');
        }
        $estudiante = $user->estudiante;
        $data = $request->validate([
            'comentario' => 'required|string',
            'evidencia' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif,webp',
            'fechaAusencia' => 'required|date',
            'tipoAusencia' => 'required|string',
            'profesor_id' => 'required|exists:profesores,id',
            'asignatura_id' => 'required|exists:asignaturas,id',
        ]);
        $data['user_id'] = $user->id;
        $data['fechaSolicitud'] = now()->toDateString();
        // Guardar archivo si se subió
        if ($request->hasFile('evidencia')) {
            $data['evidencia'] = $request->file('evidencia')->store('evidencias', 'public');
        }
        $solicitud = $estudiante->solicitudes()->create($data);
        return redirect()->route('solicitudes.index')->with('success', 'Solicitud creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Solicitud $solicitud)
    {
        return view('solicitudes.show', compact('solicitud'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Solicitud $solicitud)
    {
        return view('solicitudes.edit', compact('solicitud'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Solicitud $solicitud)
    {
        $data = $request->validate([
            'comentario' => 'required|string',
            'evidencia' => 'nullable|string',
            'fechaSolicitud' => 'required|date',
            'fechaAusencia' => 'required|date',
            'tipoAusencia' => 'required|string',
            'estado' => 'required|string',
            'resolucion' => 'nullable|string',
        ]);
        $solicitud->update($data);
        return redirect()->route('solicitudes.index')->with('success', 'Solicitud actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Solicitud $solicitud)
    {
        $solicitud->delete();
        return redirect()->route('solicitudes.index')->with('success', 'Solicitud eliminada correctamente.');
    }
}
