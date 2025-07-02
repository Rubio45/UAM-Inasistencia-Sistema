<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Solicitud') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-white">
                    <form method="POST" action="{{ route('solicitudes.update', $solicitud) }}">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Fecha de Ausencia</label>
                                <input type="date" name="fechaAusencia" value="{{ $solicitud->fechaAusencia->format('Y-m-d') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tipo de Ausencia</label>
                                <select name="tipoAusencia" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500">
                                    <option value="">Seleccionar...</option>
                                    <option value="Enfermedad" {{ $solicitud->tipoAusencia === 'Enfermedad' ? 'selected' : '' }}>Enfermedad</option>
                                    <option value="Emergencia Familiar" {{ $solicitud->tipoAusencia === 'Emergencia Familiar' ? 'selected' : '' }}>Emergencia Familiar</option>
                                    <option value="Problemas de Transporte" {{ $solicitud->tipoAusencia === 'Problemas de Transporte' ? 'selected' : '' }}>Problemas de Transporte</option>
                                    <option value="Otro" {{ $solicitud->tipoAusencia === 'Otro' ? 'selected' : '' }}>Otro</option>
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Comentario</label>
                                <textarea name="comentario" rows="4" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500">{{ $solicitud->comentario }}</textarea>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Evidencia (opcional)</label>
                                <input type="text" name="evidencia" value="{{ $solicitud->evidencia }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Estado</label>
                                <select name="estado" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500">
                                    <option value="Pendiente" {{ $solicitud->estado === 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="Aprobada" {{ $solicitud->estado === 'Aprobada' ? 'selected' : '' }}>Aprobada</option>
                                    <option value="Rechazada" {{ $solicitud->estado === 'Rechazada' ? 'selected' : '' }}>Rechazada</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Resolución (opcional)</label>
                                <input type="text" name="resolucion" value="{{ $solicitud->resolucion }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500">
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end space-x-3">
                            <a href="{{ route('solicitudes.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancelar</a>
                            <button type="submit" class="bg-cyan-700 text-white px-4 py-2 rounded hover:bg-cyan-800">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 