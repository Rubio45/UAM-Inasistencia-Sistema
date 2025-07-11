<?php

namespace App\Http\Controllers;

use App\Models\Solicitud;
use Illuminate\Http\Request;

class SecretariaSolicitudController extends Controller
{
    public function index()
    {
        $solicitudes = Solicitud::with('user')->where('estado', 'pendiente')->get();
        return view('secretaria.solicitudes.index', compact('solicitudes'));
    }
}
