<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-900 leading-tight">
                {{ __('Solicitudes') }}
            </h2>
            @if(Auth::user()->rol === 'estudiante')
                <a href="{{ route('solicitudes.create') }}" class="bg-cyan-700 text-white px-4 py-2 rounded hover:bg-cyan-800 transition">
                    Nueva Solicitud
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Filtros -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Filtros</h3>
                        <button type="button" 
                                onclick="toggleFiltros()"
                                class="flex items-center gap-2 text-sm font-medium text-cyan-700 hover:text-cyan-800 transition-colors duration-200">
                            <span id="filtros-texto">Mostrar filtros avanzados</span>
                            <svg id="filtros-icono" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Filtros rápidos -->
                    <div class="mb-4 flex flex-wrap gap-2">
                        <a href="{{ route('solicitudes.index') }}" 
                           class="px-3 py-1 rounded-full text-sm font-medium transition-colors duration-200 {{ !request('estado') && !request('fecha_desde') && !request('fecha_hasta') && !request('tipo_ausencia') ? 'bg-cyan-100 text-cyan-800' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Todas
                        </a>
                        <a href="{{ route('solicitudes.index', ['estado' => 'Pendiente']) }}" 
                           class="px-3 py-1 rounded-full text-sm font-medium transition-colors duration-200 {{ request('estado') == 'Pendiente' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Solo Pendientes
                        </a>
                        <a href="{{ route('solicitudes.index', ['estado' => 'Aprobada']) }}" 
                           class="px-3 py-1 rounded-full text-sm font-medium transition-colors duration-200 {{ request('estado') == 'Aprobada' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Solo Aprobadas
                        </a>
                        <a href="{{ route('solicitudes.index', ['estado' => 'Rechazada']) }}" 
                           class="px-3 py-1 rounded-full text-sm font-medium transition-colors duration-200 {{ request('estado') == 'Rechazada' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Solo Rechazadas
                        </a>
                        <a href="{{ route('solicitudes.index', ['fecha_desde' => now()->format('Y-m-d'), 'fecha_hasta' => now()->format('Y-m-d')]) }}" 
                           class="px-3 py-1 rounded-full text-sm font-medium transition-colors duration-200 {{ request('fecha_desde') == now()->format('Y-m-d') && request('fecha_hasta') == now()->format('Y-m-d') ? 'bg-orange-100 text-orange-800' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Hoy
                        </a>
                        <a href="{{ route('solicitudes.index', ['fecha_desde' => now()->subDays(7)->format('Y-m-d')]) }}" 
                           class="px-3 py-1 rounded-full text-sm font-medium transition-colors duration-200 {{ request('fecha_desde') == now()->subDays(7)->format('Y-m-d') ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Últimos 7 días
                        </a>
                        <a href="{{ route('solicitudes.index', ['fecha_desde' => now()->startOfMonth()->format('Y-m-d')]) }}" 
                           class="px-3 py-1 rounded-full text-sm font-medium transition-colors duration-200 {{ request('fecha_desde') == now()->startOfMonth()->format('Y-m-d') ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Este mes
                        </a>
                    </div>

                    <!-- Filtros avanzados (dropdown) -->
                    <div id="filtros-avanzados" class="hidden overflow-hidden transition-all duration-300 ease-in-out" style="max-height: 0px;">
                        <div class="border-t border-gray-200 pt-4">
                            <form method="GET" action="{{ route('solicitudes.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                <!-- Filtro por estado -->
                                <div>
                                    <label for="estado" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                                    <select name="estado" id="estado" class="w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500">
                                        <option value="">Todos los estados</option>
                                        @foreach($estados as $estado)
                                            <option value="{{ $estado }}" {{ request('estado') == $estado ? 'selected' : '' }}>
                                                {{ $estado }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Filtro por tipo de ausencia -->
                                <div>
                                    <label for="tipo_ausencia" class="block text-sm font-medium text-gray-700 mb-1">Tipo de Ausencia</label>
                                    <select name="tipo_ausencia" id="tipo_ausencia" class="w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500">
                                        <option value="">Todos los tipos</option>
                                        @foreach($tiposAusencia as $tipo)
                                            <option value="{{ $tipo }}" {{ request('tipo_ausencia') == $tipo ? 'selected' : '' }}>
                                                {{ $tipo }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Filtro por fecha desde -->
                                <div>
                                    <label for="fecha_desde" class="block text-sm font-medium text-gray-700 mb-1">Fecha desde</label>
                                    <input type="date" name="fecha_desde" id="fecha_desde" 
                                           value="{{ request('fecha_desde') }}"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500">
                                </div>

                                <!-- Filtro por fecha hasta -->
                                <div>
                                    <label for="fecha_hasta" class="block text-sm font-medium text-gray-700 mb-1">Fecha hasta</label>
                                    <input type="date" name="fecha_hasta" id="fecha_hasta" 
                                           value="{{ request('fecha_hasta') }}"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500">
                                </div>

                                <!-- Botones de filtro -->
                                <div class="md:col-span-2 lg:col-span-4 flex gap-2">
                                    <button type="submit" class="bg-cyan-700 text-white px-4 py-2 rounded hover:bg-cyan-800 transition-colors duration-200">
                                        Aplicar Filtros
                                    </button>
                                    <a href="{{ route('solicitudes.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition-colors duration-200">
                                        Limpiar Filtros
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">
                    <!-- Resumen de resultados -->
                    <div class="mb-4 flex justify-between items-center">
                        <div class="text-sm text-gray-600">
                            Mostrando {{ $solicitudes->count() }} solicitud(es)
                            @if(request('estado') || request('tipo_ausencia') || request('fecha_desde') || request('fecha_hasta'))
                                con filtros aplicados
                            @endif
                        </div>
                        @if($solicitudes->count() > 0)
                            <div class="text-sm text-gray-600">
                                @if(request('estado') == 'Pendiente')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Solo pendientes
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div>

                    @if($solicitudes->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Fecha Ausencia</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Tipo</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Estado</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Asignatura</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Profesor</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Comentario Secretaría</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($solicitudes as $solicitud)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-gray-900">{{ $solicitud->fechaAusencia->format('d/m/Y') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-gray-900">{{ $solicitud->tipoAusencia }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-block px-3 py-1 rounded-full text-xs font-bold border
                                                    @if($solicitud->estado === 'Aprobada') bg-green-100 text-green-800 border-green-300
                                                    @elseif($solicitud->estado === 'Rechazada') bg-red-100 text-red-800 border-red-300
                                                    @else bg-yellow-100 text-yellow-800 border-yellow-300 @endif">
                                                    {{ $solicitud->estado }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-gray-900">{{ $solicitud->asignatura->nombre ?? '-' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-gray-900">
                                                {{ $solicitud->profesor->user->name ?? '-' }} {{ $solicitud->profesor->apellido ?? '' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-gray-900">
                                                @if($solicitud->comentario_secretaria)
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                                        </svg>
                                                        Tiene comentario
                                                    </span>
                                                @else
                                                    <span class="text-gray-400 text-xs">Sin comentario</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex gap-2">
                                                <a href="{{ route('solicitudes.show', $solicitud) }}" class="px-3 py-1 rounded bg-cyan-100 text-cyan-800 border border-cyan-300 text-xs font-semibold hover:bg-cyan-200 transition">Ver</a>
                                                <a href="{{ route('solicitudes.edit', $solicitud) }}" class="px-3 py-1 rounded bg-gray-100 text-gray-800 border border-gray-300 text-xs font-semibold hover:bg-gray-200 transition">Editar</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No se encontraron solicitudes</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                @if(request('estado') || request('tipo_ausencia') || request('fecha_desde') || request('fecha_hasta'))
                                    No hay solicitudes que coincidan con los filtros aplicados.
                                @else
                                    No hay solicitudes para mostrar.
                                @endif
                            </p>
                            @if(request('estado') || request('tipo_ausencia') || request('fecha_desde') || request('fecha_hasta'))
                                <div class="mt-6">
                                    <a href="{{ route('solicitudes.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-cyan-700 hover:bg-cyan-800">
                                        Limpiar filtros
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
function toggleFiltros() {
    const filtrosAvanzados = document.getElementById('filtros-avanzados');
    const filtrosTexto = document.getElementById('filtros-texto');
    const filtrosIcono = document.getElementById('filtros-icono');
    
    if (filtrosAvanzados.classList.contains('hidden')) {
        // Mostrar filtros
        filtrosAvanzados.classList.remove('hidden');
        setTimeout(() => {
            filtrosAvanzados.style.maxHeight = filtrosAvanzados.scrollHeight + 'px';
        }, 10);
        filtrosTexto.textContent = 'Ocultar filtros avanzados';
        filtrosIcono.style.transform = 'rotate(180deg)';
    } else {
        // Ocultar filtros
        filtrosAvanzados.style.maxHeight = '0px';
        setTimeout(() => {
            filtrosAvanzados.classList.add('hidden');
        }, 300);
        filtrosTexto.textContent = 'Mostrar filtros avanzados';
        filtrosIcono.style.transform = 'rotate(0deg)';
    }
}

// Mostrar filtros automáticamente si hay filtros activos
document.addEventListener('DOMContentLoaded', function() {
    const hasActiveFilters = {{ request('estado') || request('tipo_ausencia') || request('fecha_desde') || request('fecha_hasta') ? 'true' : 'false' }};
    
    if (hasActiveFilters) {
        const filtrosAvanzados = document.getElementById('filtros-avanzados');
        const filtrosTexto = document.getElementById('filtros-texto');
        const filtrosIcono = document.getElementById('filtros-icono');
        
        filtrosAvanzados.classList.remove('hidden');
        filtrosAvanzados.style.maxHeight = filtrosAvanzados.scrollHeight + 'px';
        filtrosTexto.textContent = 'Ocultar filtros avanzados';
        filtrosIcono.style.transform = 'rotate(180deg)';
    }
});
</script> 