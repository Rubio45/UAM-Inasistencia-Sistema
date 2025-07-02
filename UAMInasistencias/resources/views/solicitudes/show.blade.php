<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 leading-tight">
            {{ __('Detalle de Solicitud') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold">Solicitud #{{ $solicitud->id }}</h3>
                        <div class="flex gap-2">
                            <a href="{{ route('solicitudes.edit', $solicitud) }}" class="bg-cyan-700 text-white px-4 py-2 rounded hover:bg-cyan-800 transition">Editar</a>
                            <form action="{{ route('solicitudes.destroy', $solicitud) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta solicitud?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">Eliminar</button>
                            </form>
                        </div>
                    </div>
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Estado:</dt>
                            <dd class="text-sm">
                                <span class="px-3 py-1 rounded-full text-white font-semibold
                                    @if($solicitud->estado === 'Aprobada') bg-green-600
                                    @elseif($solicitud->estado === 'Rechazada') bg-red-600
                                    @else bg-yellow-500 text-gray-900 @endif">
                                    {{ $solicitud->estado }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Fecha de Ausencia:</dt>
                            <dd class="text-sm text-gray-900">{{ $solicitud->fechaAusencia->format('d/m/Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tipo de Ausencia:</dt>
                            <dd class="text-sm text-gray-900">{{ $solicitud->tipoAusencia }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Asignatura:</dt>
                            <dd class="text-sm text-gray-900">{{ $solicitud->asignatura->nombre ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Profesor:</dt>
                            <dd class="text-sm text-gray-900">
                                {{ $solicitud->profesor->user->name ?? '-' }} {{ $solicitud->profesor->apellido ?? '' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Comentario:</dt>
                            <dd class="text-sm text-gray-900">{{ $solicitud->comentario }}</dd>
                        </div>
                        @if($solicitud->evidencia)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Evidencia:</dt>
                            <dd class="text-sm">
                                <a href="{{ asset('storage/' . $solicitud->evidencia) }}" target="_blank" class="text-cyan-700 hover:underline">Ver evidencia</a>
                            </dd>
                        </div>
                        @endif
                        @if($solicitud->resolucion)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Resolución:</dt>
                            <dd class="text-sm text-gray-900">{{ $solicitud->resolucion }}</dd>
                        </div>
                        @endif
                    </dl>
                    <div class="mt-8 flex justify-end">
                        <a href="{{ route('solicitudes.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700 transition">Volver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 