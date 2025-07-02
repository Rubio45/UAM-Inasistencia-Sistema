<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Estudiante;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    
    public function store(Request $request): RedirectResponse
    {
        \Log::info('Iniciando proceso de registro');
        
        $request->validate([
            'name' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'cif' => 'required|string|max:50|unique:estudiantes,cif',
            'carrera' => 'required|string|max:100',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);

        \Log::info('Validación pasada, creando usuario');

        // Crear el usuario básico
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        \Log::info('Usuario creado con ID: ' . $user->id);

        // Crear automáticamente el perfil de estudiante
        $estudiante = $user->estudiante()->create([
            'apellido' => $request->apellido,
            'cif' => $request->cif,
            'carrera' => $request->carrera,
        ]);

        \Log::info('Estudiante creado con ID: ' . $estudiante->id);

        event(new Registered($user));

        \Log::info('Evento Registered disparado');

        Auth::login($user);

        \Log::info('Usuario autenticado, redirigiendo a: ' . RouteServiceProvider::HOME);

        return redirect(RouteServiceProvider::HOME);
    }
}
