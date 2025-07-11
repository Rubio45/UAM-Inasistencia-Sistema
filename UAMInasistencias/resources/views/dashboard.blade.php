@php
    $rol = Auth::user()->rol;
    $solicitudesPendientes = 0;
    
    if($rol === 'estudiante') {
        $solicitudesPendientes = Auth::user()->estudiante->solicitudes()->where('estado', 'Pendiente')->count();
    } elseif($rol === 'profesor') {
        $solicitudesPendientes = Auth::user()->profesor->solicitudesAprobadas()->where('estado', 'Pendiente')->count();
    } elseif($rol === 'secretaria_academica') {
        $solicitudesPendientes = Solicitud::where('estado', 'Pendiente')->count();
    }
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel Principal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-2 text-gray-900">Bienvenido, {{ Auth::user()->name }}</h3>
                    <p class="mb-4 text-gray-700">Tu rol: <span class="font-semibold text-cyan-700">{{ ucfirst($rol) }}</span></p>

                    @if($rol === 'estudiante')
                        <div class="bg-gray-50 rounded-lg p-4 mb-4 border border-cyan-100">
                            <h4 class="text-lg font-semibold mb-3 text-cyan-800">Panel de Estudiante</h4>
                            <p class="text-gray-700 mb-4">Desde aquí puedes gestionar tus solicitudes de inasistencia.</p>
                            
                            @if($solicitudesPendientes > 0)
                                <div class="mb-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                                    <p class="text-yellow-800 text-sm">
                                        <strong>{{ $solicitudesPendientes }}</strong> solicitud(es) pendiente(s) de revisión
                                    </p>
                                </div>
                            @endif
                            
                            <div class="flex gap-2">
                                <a href="{{ route('solicitudes.index') }}" class="bg-cyan-700 text-white px-6 py-3 rounded-lg font-semibold hover:bg-cyan-800 hover:scale-105 transition inline-block">
                                    Ver mis solicitudes
                                </a>
                                @if($solicitudesPendientes > 0)
                                    <a href="{{ route('solicitudes.index', ['estado' => 'Pendiente']) }}" class="bg-yellow-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-yellow-700 hover:scale-105 transition inline-block">
                                        Ver pendientes
                                    </a>
                                @endif
                            </div>
                        </div>
                    @elseif($rol === 'profesor')
                        <div class="bg-blue-50 rounded-lg p-4 mb-4 border border-blue-100">
                            <h4 class="text-lg font-semibold mb-3 text-blue-800">Panel de Profesor</h4>
                            <p class="text-gray-700 mb-4">Accede a tu dashboard específico para gestionar las solicitudes de tus estudiantes.</p>
                            
                            @if($solicitudesPendientes > 0)
                                <div class="mb-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                                    <p class="text-yellow-800 text-sm">
                                        <strong>{{ $solicitudesPendientes }}</strong> solicitud(es) pendiente(s) de revisión
                                    </p>
                                </div>
                            @endif
                            
                            <div class="flex gap-2">
                                <a href="{{ route('profesor.dashboard') }}" class="bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-800 hover:scale-105 transition inline-block">
                                    Ir al Dashboard del Profesor
                                </a>
                                @if($solicitudesPendientes > 0)
                                    <a href="{{ route('solicitudes.index', ['estado' => 'Pendiente']) }}" class="bg-yellow-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-yellow-700 hover:scale-105 transition inline-block">
                                        Ver pendientes
                                    </a>
                                @endif
                            </div>
                        </div>
                    @elseif($rol === 'secretaria_academica')
                        <div class="bg-green-50 rounded-lg p-4 mb-4 border border-green-100">
                            <h4 class="text-lg font-semibold mb-3 text-green-800">Panel de Secretaría Académica</h4>
                            <p class="text-gray-700 mb-4">Accede al panel de administración para gestionar profesores, clases y solicitudes.</p>
                            
                            @if($solicitudesPendientes > 0)
                                <div class="mb-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                                    <p class="text-yellow-800 text-sm">
                                        <strong>{{ $solicitudesPendientes }}</strong> solicitud(es) pendiente(s) de revisión
                                    </p>
                                </div>
                            @endif
                            
                            <div class="flex gap-2">
                                <a href="{{ route('secretaria.dashboard') }}" class="bg-green-700 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-800 hover:scale-105 transition inline-block">
                                    Ir al Panel de Secretaría
                                </a>
                                @if($solicitudesPendientes > 0)
                                    <a href="{{ route('solicitudes.index', ['estado' => 'Pendiente']) }}" class="bg-yellow-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-yellow-700 hover:scale-105 transition inline-block">
                                        Ver pendientes
                                    </a>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <p class="text-yellow-800">Tu perfil está siendo configurado. Por favor, contacta al administrador.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
