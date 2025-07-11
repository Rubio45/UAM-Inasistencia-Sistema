<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SecretariaClaseController;
use App\Http\Controllers\SecretariaProfesorController;
use App\Http\Controllers\SecretariaSolicitudController;

// Rutas de Secretaria - Solo accesibles para usuarios autenticados con rol de secretaria
Route::middleware(['auth', 'secretaria'])->prefix('secretaria')->name('secretaria.')->group(function () {
    // Gestión de profesores
    Route::resource('profesores', SecretariaProfesorController::class);

    // Gestión de clases
    Route::resource('clases', SecretariaClaseController::class);

    // Bandeja de solicitudes pendientes
    Route::get('/solicitudes/pendientes', [SecretariaSolicitudController::class, 'index'])->name('solicitudes.index');
    Route::get('/solicitudes/{solicitud}', [SecretariaSolicitudController::class, 'show'])->name('solicitudes.show');
    Route::put('/solicitudes/{solicitud}/aprobar-rechazar', [SecretariaSolicitudController::class, 'update'])->name('solicitudes.aprobar-rechazar');
}); 