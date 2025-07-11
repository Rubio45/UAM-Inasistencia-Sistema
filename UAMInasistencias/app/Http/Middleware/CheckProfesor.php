<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckProfesor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('profesor.login');
        }

        $user = Auth::user();
        
        if (!$user->profesor) {
            Auth::logout();
            return redirect()->route('profesor.login')->withErrors([
                'email' => 'Este acceso es solo para profesores.',
            ]);
        }

        return $next($request);
    }
} 