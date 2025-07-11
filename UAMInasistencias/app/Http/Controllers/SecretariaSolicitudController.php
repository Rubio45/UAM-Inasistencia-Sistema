<?php

namespace App\Http\Controllers;

use App\Models\Solicitud;
use Illuminate\Http\Request;

class SecretariaSolicitudController extends Controller
{
    public function index(Request $request)
    {
        $query = Solicitud::with('user');
        
        // Filtrar por estado si se especifica
        if ($request->has('estado') && $request->estado !== 'todos') {
            $query->where('estado', $request->estado);
        }
        
        // Filtrar por tipo de ausencia si se especifica
        if ($request->has('tipo_ausencia') && $request->tipo_ausencia !== 'todos') {
            $query->where('tipoAusencia', $request->tipo_ausencia);
        }
        
        // Filtrar por rango de fechas si se especifica
        if ($request->filled('fecha_inicio')) {
            $query->whereDate('fechaAusencia', '>=', $request->fecha_inicio);
        }
        
        if ($request->filled('fecha_fin')) {
            $query->whereDate('fechaAusencia', '<=', $request->fecha_fin);
        }
        
        $solicitudes = $query->orderBy('created_at', 'desc')->get();
        
        // Obtener estadísticas
        $estadisticas = [
            'pendientes' => Solicitud::where('estado', 'pendiente')->count(),
            'aprobadas' => Solicitud::where('estado', 'aprobado')->count(),
            'rechazadas' => Solicitud::where('estado', 'rechazado')->count(),
            'total' => Solicitud::count(),
        ];
        
        return view('secretaria.solicitudes.index', compact('solicitudes', 'estadisticas'));
    }

    public function show(Solicitud $solicitud)
    {
        // Cargar las relaciones necesarias
        $solicitud->load(['user.estudiante', 'profesor.user', 'asignatura']);
        
        return view('secretaria.solicitudes.show', compact('solicitud'));
    }

    public function update(Request $request, Solicitud $solicitud)
    {
        $request->validate([
            'estado' => 'required|in:aprobado,rechazado',
            'comentario_secretaria' => 'required|string|max:500',
        ], [
            'comentario_secretaria.required' => 'El comentario es obligatorio para aprobar o rechazar una solicitud.',
        ]);

        $solicitud->update([
            'estado' => $request->estado,
            'comentario_secretaria' => $request->comentario_secretaria,
        ]);

        $mensaje = $request->estado === 'aprobado' ? 'Solicitud aprobada exitosamente.' : 'Solicitud rechazada.';
        
        return redirect()->route('secretaria.solicitudes.index')->with('success', $mensaje);
    }
} 