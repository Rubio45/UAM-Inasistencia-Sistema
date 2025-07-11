<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\PerfilProfesorController;
use App\Http\Controllers\Auth\ProfesorLoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Rutas de login para profesores
Route::get('/profesor/login', [ProfesorLoginController::class, 'create'])->name('profesor.login');
Route::post('/profesor/login', [ProfesorLoginController::class, 'store'])->name('profesor.login');
Route::post('/profesor/logout', [ProfesorLoginController::class, 'destroy'])->name('profesor.logout');

// Rutas de login para secretaría (ocultas, no públicas)
Route::get('/secretaria/login', [\App\Http\Controllers\Auth\SecretariaLoginController::class, 'create'])->name('secretaria.login');
Route::post('/secretaria/login', [\App\Http\Controllers\Auth\SecretariaLoginController::class, 'store'])->name('secretaria.login');
Route::post('/secretaria/logout', [\App\Http\Controllers\Auth\SecretariaLoginController::class, 'destroy'])->name('secretaria.logout');

// Rutas públicas para estudiantes y profesores
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Dashboard específico para profesores
Route::get('/profesor/dashboard', function () {
    return view('profesor.dashboard');
})->middleware(['auth', 'verified', 'profesor'])->name('profesor.dashboard');

// Dashboard exclusivo para secretaría - SIMPLIFICADO
Route::get('/secretaria/dashboard', function () {
    return view('secretaria.dashboard');
})->middleware(['auth', 'secretaria'])->name('secretaria.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Rutas para solicitudes de estudiantes
    Route::resource('solicitudes', SolicitudController::class)->parameters([
        'solicitudes' => 'solicitud'
    ]);
    
    // Ruta para eliminar evidencias individuales
    Route::delete('/solicitudes/{solicitud}/evidencia', [SolicitudController::class, 'eliminarEvidencia'])->name('solicitudes.eliminar-evidencia');
});

// Incluir rutas de autenticación
require __DIR__.'/auth.php';

// Incluir rutas de secretaria (protegidas)
require __DIR__.'/web_secretaria_routes.php';
