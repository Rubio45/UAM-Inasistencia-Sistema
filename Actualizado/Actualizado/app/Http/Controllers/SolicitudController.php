<?php

namespace App\Http\Controllers;

use App\Models\Solicitud;
use Illuminate\Http\Request;

class SolicitudController extends Controller
{
    public function index()
    {
        // Bandeja: mostrar solicitudes pendientes
        $solicitudes = Solicitud::whereNull('estado')->with('user')->get();
        return view('secretaria.solicitudes.index', compact('solicitudes'));
    }

    public function update(Request $request, Solicitud $solicitud)
    {
        $request->validate([
            'estado' => 'required|in:aprobado,rechazado',
        ]);

        $solicitud->update([
            'estado' => $request->estado,
        ]);

        return redirect()->route('solicitudes.index')
                         ->with('success', 'Solicitud ' . $request->estado . ' correctamente.');
    }
}
