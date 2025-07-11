@php
    $user = Auth::user();
    $secretaria = $user->secretariaAcademica;
    
    // Obtener solicitudes pendientes
    $solicitudesPendientes = \App\Models\Solicitud::where('estado', 'Pendiente')
        ->with(['estudiante.user', 'asignatura'])
        ->orderBy('created_at', 'desc')
        ->get();
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-green-900 leading-tight">
            Panel de Secretaría Académica
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border border-green-200">
                <div class="p-6 text-green-900">
                    <div class="flex items-center gap-3 mb-6">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <div>
                            <h3 class="text-lg font-bold text-green-900">Bienvenida, {{ $user->name }}</h3>
                            <p class="text-green-700">Rol: <span class="font-semibold text-green-700">Secretaría Académica</span></p>
                        </div>
                    </div>

                    <!-- Estadísticas rápidas -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <div class="flex items-center">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-green-600">Pendientes</p>
                                    <p class="text-2xl font-bold text-green-900">{{ $solicitudesPendientes->count() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filtros rápidos y avanzados -->
                    <div class="mb-6">
                        <form method="GET" action="{{ route('secretaria.solicitudes.index') }}" class="flex flex-wrap gap-2 items-end">
                            <div>
                                <label class="block text-sm font-medium text-green-900 mb-1">Estado</label>
                                <select name="estado" class="rounded border-green-300 focus:border-green-500 focus:ring-green-500">
                                    <option value="">Todos</option>
                                    <option value="Pendiente" {{ request('estado') == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="Aprobada" {{ request('estado') == 'Aprobada' ? 'selected' : '' }}>Aprobada</option>
                                    <option value="Rechazada" {{ request('estado') == 'Rechazada' ? 'selected' : '' }}>Rechazada</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-green-900 mb-1">Tipo de Ausencia</label>
                                <select name="tipo_ausencia" class="rounded border-green-300 focus:border-green-500 focus:ring-green-500">
                                    <option value="">Todos</option>
                                    <option value="Justificada" {{ request('tipo_ausencia') == 'Justificada' ? 'selected' : '' }}>Justificada</option>
                                    <option value="Injustificada" {{ request('tipo_ausencia') == 'Injustificada' ? 'selected' : '' }}>Injustificada</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-green-900 mb-1">Desde</label>
                                <input type="date" name="fecha_desde" value="{{ request('fecha_desde') }}" class="rounded border-green-300 focus:border-green-500 focus:ring-green-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-green-900 mb-1">Hasta</label>
                                <input type="date" name="fecha_hasta" value="{{ request('fecha_hasta') }}" class="rounded border-green-300 focus:border-green-500 focus:ring-green-500">
                            </div>
                            <button type="submit" class="ml-2 bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800 transition flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"></path>
                                </svg>
                                Filtrar
                            </button>
                        </form>
                    </div>

                    <!-- Tabla de solicitudes pendientes -->
                    <div class="overflow-x-auto">
                        @if($solicitudesPendientes->count() > 0)
                            <table class="min-w-full divide-y divide-green-200">
                                <thead class="bg-green-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Estudiante</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Asignatura</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Fecha</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Tipo</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Estado</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-green-100">
                                    @foreach($solicitudesPendientes as $solicitud)
                                        <tr class="hover:bg-green-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-green-900">
                                                {{ $solicitud->estudiante->user->name }} {{ $solicitud->estudiante->apellido }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-green-900">
                                                {{ $solicitud->asignatura->nombre ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-green-900">
                                                {{ \Carbon\Carbon::parse($solicitud->fecha_ausencia)->format('d/m/Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-green-900">
                                                {{ $solicitud->tipo_ausencia }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    {{ $solicitud->estado }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex gap-2">
                                                <a href="{{ route('secretaria.solicitudes.show', $solicitud->id) }}" 
                                                   class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                    Revisar
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-green-900">No hay solicitudes pendientes</h3>
                                <p class="mt-1 text-sm text-green-500">Todas las solicitudes han sido procesadas.</p>
                            </div>
                        @endif
                    </div>

                    @if($solicitudesPendientes->count() > 0)
                        <div class="mt-6 text-center">
                            <a href="{{ route('secretaria.solicitudes.index') }}" 
                               class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700 transition flex items-center gap-2 mx-auto w-fit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                                Ver todas las solicitudes
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 