<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-900 leading-tight">
                {{ __('Solicitudes') }}
            </h2>
            @if(Auth::user()->isEstudiante())
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
            
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">
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
                        <p class="text-center text-gray-500">No hay solicitudes para mostrar.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 