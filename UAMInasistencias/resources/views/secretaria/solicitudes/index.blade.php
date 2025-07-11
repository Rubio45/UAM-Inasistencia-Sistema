<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-green-900 leading-tight">
            {{ __('Gestión de Solicitudes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-green-200">
                    <div class="p-4 text-center">
                        <div class="text-2xl font-bold text-green-600">{{ $estadisticas['total'] }}</div>
                        <div class="text-sm text-green-700">Total Solicitudes</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-yellow-200">
                    <div class="p-4 text-center">
                        <div class="text-2xl font-bold text-yellow-600">{{ $estadisticas['pendientes'] }}</div>
                        <div class="text-sm text-yellow-700">Pendientes</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-green-200">
                    <div class="p-4 text-center">
                        <div class="text-2xl font-bold text-green-600">{{ $estadisticas['aprobadas'] }}</div>
                        <div class="text-sm text-green-700">Aprobadas</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-red-200">
                    <div class="p-4 text-center">
                        <div class="text-2xl font-bold text-red-600">{{ $estadisticas['rechazadas'] }}</div>
                        <div class="text-sm text-red-700">Rechazadas</div>
                    </div>
                </div>
            </div>

            <!-- Filtros -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-green-200 mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-green-900 mb-4">Filtros</h3>
                    <form method="GET" action="{{ route('secretaria.solicitudes.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Estado</label>
                            <select name="estado" class="w-full border border-green-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                                <option value="todos" {{ request('estado') == 'todos' ? 'selected' : '' }}>Todos</option>
                                <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendientes</option>
                                <option value="aprobado" {{ request('estado') == 'aprobado' ? 'selected' : '' }}>Aprobadas</option>
                                <option value="rechazado" {{ request('estado') == 'rechazado' ? 'selected' : '' }}>Rechazadas</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Tipo de Ausencia</label>
                            <select name="tipo_ausencia" class="w-full border border-green-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                                <option value="todos" {{ request('tipo_ausencia') == 'todos' ? 'selected' : '' }}>Todos</option>
                                <option value="enfermedad" {{ request('tipo_ausencia') == 'enfermedad' ? 'selected' : '' }}>Enfermedad</option>
                                <option value="emergencia" {{ request('tipo_ausencia') == 'emergencia' ? 'selected' : '' }}>Emergencia</option>
                                <option value="otro" {{ request('tipo_ausencia') == 'otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Fecha Inicio</label>
                            <input type="date" name="fecha_inicio" value="{{ request('fecha_inicio') }}" 
                                   class="w-full border border-green-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Fecha Fin</label>
                            <input type="date" name="fecha_fin" value="{{ request('fecha_fin') }}" 
                                   class="w-full border border-green-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                        <div class="md:col-span-4 flex gap-2">
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                Filtrar
                            </button>
                            <a href="{{ route('secretaria.solicitudes.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Limpiar
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabla de Solicitudes -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-green-200">
                <div class="p-6">
                    <h2 class="text-2xl font-bold mb-6 text-green-900">Solicitudes de Inasistencia</h2>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($solicitudes->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full table-auto border-collapse border border-green-200">
                                <thead>
                                    <tr class="bg-green-50">
                                        <th class="border border-green-200 p-3 text-left text-green-900">Estudiante</th>
                                        <th class="border border-green-200 p-3 text-left text-green-900">Fecha Ausencia</th>
                                        <th class="border border-green-200 p-3 text-left text-green-900">Tipo</th>
                                        <th class="border border-green-200 p-3 text-left text-green-900">Comentario</th>
                                        <th class="border border-green-200 p-3 text-left text-green-900">Estado</th>
                                        <th class="border border-green-200 p-3 text-left text-green-900">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($solicitudes as $solicitud)
                                        <tr class="hover:bg-green-50">
                                            <td class="border border-green-200 p-3">
                                                @if($solicitud->user->estudiante)
                                                    {{ $solicitud->user->name }} {{ $solicitud->user->estudiante->apellido }}
                                                @else
                                                    {{ $solicitud->user->name }}
                                                @endif
                                            </td>
                                            <td class="border border-green-200 p-3">{{ $solicitud->fechaAusencia ? \Carbon\Carbon::parse($solicitud->fechaAusencia)->format('d/m/Y') : 'No especificada' }}</td>
                                            <td class="border border-green-200 p-3">{{ $solicitud->tipoAusencia ? ucfirst($solicitud->tipoAusencia) : 'No especificado' }}</td>
                                            <td class="border border-green-200 p-3">{{ Str::limit($solicitud->comentario, 50) }}</td>
                                            <td class="border border-green-200 p-3">
                                                <span class="px-2 py-1 text-xs rounded-full 
                                                    @if($solicitud->estado === 'pendiente') bg-yellow-100 text-yellow-800
                                                    @elseif($solicitud->estado === 'aprobado') bg-green-100 text-green-800
                                                    @else bg-red-100 text-red-800 @endif">
                                                    {{ ucfirst($solicitud->estado) }}
                                                </span>
                                            </td>
                                            <td class="border border-green-200 p-3">
                                                <div class="flex flex-col gap-2">
                                                    <!-- Botón Revisar -->
                                                    <a href="{{ route('secretaria.solicitudes.show', $solicitud->id) }}" 
                                                       class="text-blue-600 hover:text-blue-800 text-sm flex items-center gap-1">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                        </svg>
                                                        Revisar
                                                    </a>
                                                    
                                                    @if($solicitud->estado === 'pendiente')
                                                        <!-- Botón Aprobar -->
                                                        <button onclick="mostrarModalAprobar({{ $solicitud->id }})" 
                                                                class="text-green-600 hover:text-green-800 text-sm flex items-center gap-1">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                            </svg>
                                                            Aprobar
                                                        </button>
                                                        
                                                        <!-- Botón Rechazar -->
                                                        <button onclick="mostrarModalRechazar({{ $solicitud->id }})" 
                                                                class="text-red-600 hover:text-red-800 text-sm flex items-center gap-1">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                            Rechazar
                                                        </button>
                                                    @else
                                                        <span class="text-gray-500 text-sm">Procesada</span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="text-6xl mb-4">📋</div>
                            <h3 class="text-xl font-semibold text-gray-600 mb-2">No hay solicitudes</h3>
                            <p class="text-gray-500">No se encontraron solicitudes con los filtros aplicados.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


</x-app-layout> 