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
    public function index(Request $request)
    {
        // Mostrar solicitudes según el rol
        $user = Auth::user();
        
        if ($user->isEstudiante()) {
            $query = $user->estudiante->solicitudes();
        } elseif ($user->isProfesor()) {
            $query = Solicitud::where('profesor_id', $user->profesor->id);
        } elseif ($user->isSecretariaAcademica()) {
            $query = Solicitud::where('secretaria_id', $user->secretariaAcademica->id);
        } else {
            $query = Solicitud::query();
        }

        // Aplicar filtros
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('fecha_desde')) {
            $query->where('fechaAusencia', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->where('fechaAusencia', '<=', $request->fecha_hasta);
        }

        if ($request->filled('tipo_ausencia')) {
            $query->where('tipoAusencia', $request->tipo_ausencia);
        }

        // Ordenar por fecha de ausencia (más reciente primero)
        $solicitudes = $query->with(['asignatura', 'profesor.user', 'estudiante'])
                            ->orderBy('fechaAusencia', 'desc')
                            ->get();

        // Obtener opciones para los filtros
        $estados = ['Pendiente', 'Aprobada', 'Rechazada'];
        $tiposAusencia = ['Enfermedad', 'Emergencia Familiar', 'Problemas de Transporte', 'Otro'];

        return view('solicitudes.index', compact('solicitudes', 'estados', 'tiposAusencia'));
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
            'evidencias.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif,webp|max:10240', // Máximo 10MB por archivo
            'fechaAusencia' => 'required|date',
            'tipoAusencia' => 'required|string',
            'profesor_id' => 'required|exists:profesores,id',
            'asignatura_id' => 'required|exists:asignaturas,id',
        ]);
        $data['user_id'] = $user->id;
        $data['fechaSolicitud'] = now()->toDateString();
        
        // Guardar archivos de evidencia
        $evidencias = [];
        if ($request->hasFile('evidencias')) {
            foreach ($request->file('evidencias') as $archivo) {
                if ($archivo->isValid()) {
                    $evidencias[] = $archivo->store('evidencias', 'public');
                }
            }
        }
        $data['evidencia'] = $evidencias;
        
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
        // Verificar que el usuario autenticado sea el propietario de la solicitud
        if (Auth::id() !== $solicitud->user_id) {
            abort(403, 'No tienes permisos para editar esta solicitud.');
        }
        if (strtolower($solicitud->estado) !== 'pendiente') {
            return redirect()->route('solicitudes.index')->with('error', 'Solo puedes editar solicitudes pendientes.');
        }
        return view('solicitudes.edit', compact('solicitud'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Solicitud $solicitud)
    {
        if (Auth::id() !== $solicitud->user_id) {
            abort(403, 'No tienes permisos para editar esta solicitud.');
        }
        if (strtolower($solicitud->estado) !== 'pendiente') {
            return redirect()->route('solicitudes.index')->with('error', 'Solo puedes editar solicitudes pendientes.');
        }
        
        $user = Auth::user();
        $data = [];
        
        // Si es estudiante, puede editar campos simples incluyendo profesor y asignatura
        if ($user->isEstudiante()) {
            $data = $request->validate([
                'comentario' => 'required|string',
                'evidencias.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif,webp|max:10240',
                'fechaAusencia' => 'required|date',
                'tipoAusencia' => 'required|string',
                'profesor_id' => 'required|exists:profesores,id',
                'asignatura_id' => 'required|exists:asignaturas,id',
            ]);
            
            // Manejar archivos de evidencia
            if ($request->hasFile('evidencias')) {
                $evidencias = $solicitud->evidencias;
                foreach ($request->file('evidencias') as $archivo) {
                    if ($archivo->isValid()) {
                        $evidencias[] = $archivo->store('evidencias', 'public');
                    }
                }
                $data['evidencia'] = $evidencias;
            }
        } else {
            // Para otros roles (profesor, secretaria) permitir edición completa
            $data = $request->validate([
                'comentario' => 'required|string',
                'evidencias.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif,webp|max:10240',
                'fechaSolicitud' => 'required|date',
                'fechaAusencia' => 'required|date',
                'tipoAusencia' => 'required|string',
                'estado' => 'required|string',
                'resolucion' => 'nullable|string',
                'profesor_id' => 'required|exists:profesores,id',
                'asignatura_id' => 'required|exists:asignaturas,id',
            ]);
            
            // Manejar archivos de evidencia
            if ($request->hasFile('evidencias')) {
                $evidencias = $solicitud->evidencias;
                foreach ($request->file('evidencias') as $archivo) {
                    if ($archivo->isValid()) {
                        $evidencias[] = $archivo->store('evidencias', 'public');
                    }
                }
                $data['evidencia'] = $evidencias;
            }
        }
        
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

    /**
     * Eliminar una evidencia específica de la solicitud
     */
    public function eliminarEvidencia(Request $request, Solicitud $solicitud)
    {
        if (Auth::id() !== $solicitud->user_id) {
            abort(403, 'No tienes permisos para editar esta solicitud.');
        }
        
        $indice = $request->input('indice');
        $solicitud->eliminarEvidencia($indice);
        
        return response()->json(['success' => true, 'message' => 'Evidencia eliminada correctamente']);
    }
}
