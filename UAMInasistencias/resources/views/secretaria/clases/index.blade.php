<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Gestión de Asignaturas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-white">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-white">Listado de Asignaturas</h2>
                        <a href="{{ route('secretaria.clases.create') }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-300">
                            ➕ Nueva Asignatura
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-600 text-white p-4 rounded-lg mb-6">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="w-full table-auto border-collapse border border-gray-600">
                            <thead>
                                <tr class="bg-gray-700">
                                    <th class="border border-gray-600 p-3 text-left">Código</th>
                                    <th class="border border-gray-600 p-3 text-left">Nombre</th>
                                    <th class="border border-gray-600 p-3 text-left">Profesor</th>
                                    <th class="border border-gray-600 p-3 text-left">Horario</th>
                                    <th class="border border-gray-600 p-3 text-left">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($asignaturas as $asignatura)
                                    <tr class="hover:bg-gray-700">
                                        <td class="border border-gray-600 p-3">{{ $asignatura->codigo }}</td>
                                        <td class="border border-gray-600 p-3">{{ $asignatura->nombre }}</td>
                                        <td class="border border-gray-600 p-3">
                                            {{ $asignatura->profesor->user->name ?? 'Sin asignar' }}
                                        </td>
                                        <td class="border border-gray-600 p-3">{{ $asignatura->horario ?? 'No definido' }}</td>
                                        <td class="border border-gray-600 p-3">
                                            <a href="{{ route('secretaria.clases.edit', $asignatura) }}" 
                                               class="text-blue-400 hover:text-blue-300 mr-3">Editar</a>
                                            <form action="{{ route('secretaria.clases.destroy', $asignatura) }}" 
                                                  method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-400 hover:text-red-300"
                                                        onclick="return confirm('¿Estás seguro de eliminar esta asignatura?')">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 