<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSecretaria
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('secretaria.login');
        }

        $user = Auth::user();
        
        // Verificar solo el rol, sin importar la relación
        if ($user->rol !== 'secretaria_academica') {
            Auth::logout();
            return redirect()->route('secretaria.login')->withErrors([
                'email' => 'Este acceso es solo para secretaría académica.',
            ]);
        }

        return $next($request);
    }
} 