@php
    $user = Auth::user();
    $profesor = $user->profesor;
    $solicitudes = $profesor ? $profesor->solicitudesAprobadas()->latest()->get() : collect();
    $asignaturas = $profesor ? $profesor->asignaturas : collect();
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel del Profesor') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-2 text-gray-900">Bienvenido, {{ $user->name }}</h3>
                    <p class="mb-4 text-gray-700">Rol: <span class="font-semibold text-cyan-700">Profesor</span></p>

                    @if($profesor)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                            <!-- Tarjeta de solicitudes pendientes -->
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                                <div class="flex items-center">
                                    <div class="p-2 bg-blue-100 rounded-lg">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-blue-600">Solicitudes Pendientes</p>
                                        <p class="text-2xl font-bold text-blue-900">{{ $solicitudes->where('estado', 'Pendiente')->count() }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Tarjeta de solicitudes aprobadas -->
                            <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                                <div class="flex items-center">
                                    <div class="p-2 bg-green-100 rounded-lg">
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-green-600">Solicitudes Aprobadas</p>
                                        <p class="text-2xl font-bold text-green-900">{{ $solicitudes->where('estado', 'Aprobada')->count() }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Tarjeta de solicitudes rechazadas -->
                            <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                                <div class="flex items-center">
                                    <div class="p-2 bg-red-100 rounded-lg">
                                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-red-600">Solicitudes Rechazadas</p>
                                        <p class="text-2xl font-bold text-red-900">{{ $solicitudes->where('estado', 'Rechazada')->count() }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sección de acciones rápidas -->
                        <div class="bg-gray-50 rounded-lg p-6 mb-8">
                            <h4 class="text-lg font-semibold mb-4 text-gray-800">Acciones Rápidas</h4>
                            <div class="flex flex-wrap gap-4">
                                <a href="{{ route('solicitudes.index') }}" class="bg-cyan-700 text-white px-6 py-3 rounded-lg font-semibold hover:bg-cyan-800 hover:scale-105 transition inline-flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Ver todas las solicitudes
                                </a>
                                <a href="{{ route('profile.edit') }}" class="bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-700 hover:scale-105 transition inline-flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Editar perfil
                                </a>
                            </div>
                        </div>

                        <!-- Sección de asignaturas -->
                        @if($asignaturas->count() > 0)
                        <div class="bg-white border border-gray-200 rounded-lg mb-8">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h4 class="text-lg font-semibold text-gray-800">Mis Asignaturas</h4>
                            </div>
                            <div class="p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach($asignaturas as $asignatura)
                                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                        <div class="flex items-center justify-between mb-2">
                                            <h5 class="font-semibold text-blue-900">{{ $asignatura->nombre }}</h5>
                                            <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">{{ $asignatura->codigo }}</span>
                                        </div>
                                        <p class="text-sm text-blue-700 mb-2">{{ $asignatura->horario ?? 'Horario no especificado' }}</p>
                                        <div class="text-xs text-blue-600">
                                            Solicitudes: {{ $solicitudes->where('asignatura_id', $asignatura->id)->count() }}
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Lista de solicitudes recientes -->
                        @if($solicitudes->count() > 0)
                        <div class="bg-white border border-gray-200 rounded-lg">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h4 class="text-lg font-semibold text-gray-800">Solicitudes Recientes</h4>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estudiante</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Asignatura</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Ausencia</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Evidencias</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($solicitudes->take(5) as $solicitud)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $solicitud->estudiante->nombre ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $solicitud->asignatura->nombre ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $solicitud->fechaAusencia->format('d/m/Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $solicitud->tipoAusencia }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if(count($solicitud->evidencias) > 0)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        {{ count($solicitud->evidencias) }} archivo(s)
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                        Sin evidencias
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    @if($solicitud->estado === 'Pendiente') bg-yellow-100 text-yellow-800
                                                    @elseif($solicitud->estado === 'Aprobada') bg-green-100 text-green-800
                                                    @else bg-red-100 text-red-800
                                                    @endif">
                                                    {{ $solicitud->estado }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('solicitudes.show', $solicitud) }}" class="text-cyan-600 hover:text-cyan-900">Ver detalles</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @else
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 text-center">
                            <p class="text-gray-500">No hay solicitudes registradas aún.</p>
                        </div>
                        @endif
                    @else
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <p class="text-yellow-800">Tu perfil de profesor está siendo configurado. Por favor, contacta al administrador.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 