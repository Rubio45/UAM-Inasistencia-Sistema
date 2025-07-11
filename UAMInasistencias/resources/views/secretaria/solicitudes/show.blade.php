<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-green-900 leading-tight">
                {{ __('Revisión de Solicitud') }}
            </h2>
            <a href="{{ route('secretaria.solicitudes.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <!-- Header con información principal -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-green-200 mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-2xl font-bold text-green-900">Solicitud #{{ $solicitud->id }}</h3>
                            <p class="text-green-700 text-sm">Fecha de solicitud: {{ $solicitud->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="text-right">
                            <span class="px-3 py-1 rounded-full text-sm font-semibold
                                @if(strtolower($solicitud->estado) === 'pendiente') bg-yellow-100 text-yellow-800
                                @elseif(strtolower($solicitud->estado) === 'aprobado') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst(strtolower($solicitud->estado)) }}
                            </span>
                            <!-- Debug: mostrar valor real del estado -->
                            <p class="text-xs text-gray-500 mt-1">Valor real: "{{ $solicitud->estado }}"</p>
                        </div>
                    </div>

                    <!-- Grid optimizado con 3 columnas -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                        <!-- Información del Estudiante -->
                        <div class="bg-green-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-green-900 mb-3 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Estudiante
                            </h4>
                            <div class="space-y-2 text-sm">
                                <div>
                                    <span class="font-medium text-green-700">Nombre:</span>
                                    <span class="text-green-900 block">
                                        @if($solicitud->user->estudiante)
                                            {{ $solicitud->user->name }} {{ $solicitud->user->estudiante->apellido }}
                                        @else
                                            {{ $solicitud->user->name }}
                                        @endif
                                    </span>
                                </div>
                                <div>
                                    <span class="font-medium text-green-700">Email:</span>
                                    <span class="text-green-900 block">{{ $solicitud->user->email }}</span>
                                </div>
                                @if($solicitud->user->estudiante)
                                <div>
                                    <span class="font-medium text-green-700">Carné:</span>
                                    <span class="text-green-900 block">{{ $solicitud->user->estudiante->carne }}</span>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Información de la Ausencia -->
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-blue-900 mb-3 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Ausencia
                            </h4>
                            <div class="space-y-2 text-sm">
                                <div>
                                    <span class="font-medium text-blue-700">Fecha:</span>
                                    <span class="text-blue-900 block">{{ $solicitud->fechaAusencia ? \Carbon\Carbon::parse($solicitud->fechaAusencia)->format('d/m/Y') : 'No especificada' }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-blue-700">Tipo:</span>
                                    <span class="text-blue-900 block">{{ $solicitud->tipoAusencia ? ucfirst($solicitud->tipoAusencia) : 'No especificado' }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-blue-700">Asignatura:</span>
                                    <span class="text-blue-900 block">{{ $solicitud->asignatura->nombre ?? 'No especificada' }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-blue-700">Profesor:</span>
                                    <span class="text-blue-900 block">
                                        @if($solicitud->profesor)
                                            {{ $solicitud->profesor->user->name }} {{ $solicitud->profesor->apellido }}
                                        @else
                                            No especificado
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Estado y Acciones Rápidas -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Estado
                            </h4>
                            <div class="space-y-3">
                                <div class="text-center">
                                    <span class="px-4 py-2 rounded-full text-sm font-semibold
                                        @if(strtolower($solicitud->estado) === 'pendiente') bg-yellow-100 text-yellow-800
                                        @elseif(strtolower($solicitud->estado) === 'aprobado') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst(strtolower($solicitud->estado)) }}
                                    </span>
                                </div>
                                
                                @if(strtolower($solicitud->estado) === 'pendiente')
                                <div class="space-y-2">
                                    <button onclick="mostrarModalAprobar()" 
                                            class="w-full bg-green-600 text-black px-4 py-2 rounded-md hover:bg-green-700 flex items-center justify-center gap-2 text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Aprobar
                                    </button>
                                    <button onclick="mostrarModalRechazar()" 
                                            class="w-full bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 flex items-center justify-center gap-2 text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Rechazar
                                    </button>
                                </div>
                                @else
                                <div class="text-center text-gray-500 text-sm">
                                    Solicitud procesada
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contenido de la solicitud -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Comentario del Estudiante -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                    <div class="p-6">
                        <h4 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            Comentario del Estudiante
                        </h4>
                        <div class="bg-gray-50 p-4 rounded-lg border-l-4 border-gray-400">
                            <p class="text-gray-800">{{ $solicitud->comentario ?: 'Sin comentario' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Evidencias -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                    <div class="p-6">
                        <h4 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                            </svg>
                            Evidencias ({{ $solicitud->evidencia ? count($solicitud->evidencia) : 0 }})
                        </h4>
                        @if($solicitud->evidencia && count($solicitud->evidencia) > 0)
                            <div class="space-y-2">
                                @foreach($solicitud->evidencia as $index => $evidencia)
                                <div class="bg-gray-50 p-3 rounded-lg border flex items-center space-x-3">
                                    @if(pathinfo($evidencia, PATHINFO_EXTENSION) === 'pdf')
                                        <svg class="w-6 h-6 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        </svg>
                                    @else
                                        <svg class="w-6 h-6 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">{{ basename($evidencia) }}</p>
                                        <a href="{{ asset('storage/' . $evidencia) }}" target="_blank" 
                                           class="text-sm text-blue-600 hover:text-blue-800 underline">
                                            Ver archivo
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8 text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                </svg>
                                <p>No hay evidencias adjuntas</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Comentario de Secretaría (si existe) -->
            @if($solicitud->comentario_secretaria)
            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg border border-green-200">
                <div class="p-6">
                    <h4 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h10a2 2 0 012 2v14a2 2 0 01-2 2z"></path>
                        </svg>
                        Comentario de Secretaría
                    </h4>
                    <div class="bg-green-50 p-4 rounded-lg border-l-4 border-green-400">
                        <p class="text-green-800">{{ $solicitud->comentario_secretaria }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Modal de Aprobar -->
    <div id="modalAprobar" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/2 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Aprobar Solicitud
                </h3>
                <form method="POST" action="{{ route('secretaria.solicitudes.aprobar-rechazar', $solicitud->id) }}" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="estado" value="aprobado">
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Comentario de Aprobación <span class="text-red-500">*</span>
                        </label>
                        <textarea name="comentario_secretaria" rows="4" 
                                  class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                                  placeholder="Agrega tu comentario sobre la aprobación..."
                                  required></textarea>
                    </div>
                    
                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="cerrarModal('modalAprobar')" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                            Cancelar
                        </button>
                        <button type="submit" class="bg-green-600 text-black px-4 py-2 rounded-md hover:bg-green-700">
                            Aprobar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de Rechazar -->
    <div id="modalRechazar" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/2 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Rechazar Solicitud
                </h3>
                <form method="POST" action="{{ route('secretaria.solicitudes.aprobar-rechazar', $solicitud->id) }}" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="estado" value="rechazado">
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Comentario de Rechazo <span class="text-red-500">*</span>
                        </label>
                        <textarea name="comentario_secretaria" rows="4" 
                                  class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500"
                                  placeholder="Agrega tu comentario sobre el rechazo..."
                                  required></textarea>
                    </div>
                    
                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="cerrarModal('modalRechazar')" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                            Cancelar
                        </button>
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">
                            Rechazar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function mostrarModalAprobar() {
            document.getElementById('modalAprobar').classList.remove('hidden');
        }

        function mostrarModalRechazar() {
            document.getElementById('modalRechazar').classList.remove('hidden');
        }

        function cerrarModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        // Cerrar modales al hacer clic fuera de ellos
        window.onclick = function(event) {
            const modals = ['modalAprobar', 'modalRechazar'];
            modals.forEach(modalId => {
                const modal = document.getElementById(modalId);
                if (event.target === modal) {
                    cerrarModal(modalId);
                }
            });
        }
    </script>
</x-app-layout> 