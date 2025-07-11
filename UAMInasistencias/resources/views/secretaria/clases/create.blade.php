<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-green-900 leading-tight">
                {{ __('Registrar Nueva Asignatura') }}
            </h2>
            <a href="{{ route('secretaria.clases.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-green-200">
                <div class="p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <h2 class="text-2xl font-bold text-green-900">Registrar Nueva Asignatura</h2>
                    </div>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('secretaria.clases.store') }}" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="codigo" class="block text-sm font-medium text-green-700 mb-2">Código:</label>
                                <input type="text" name="codigo" id="codigo" required 
                                       class="w-full border border-green-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 @error('codigo') border-red-500 @enderror"
                                       placeholder="Ej: MAT-101">
                                @error('codigo')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="nombre" class="block text-sm font-medium text-green-700 mb-2">Nombre:</label>
                                <input type="text" name="nombre" id="nombre" required 
                                       class="w-full border border-green-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 @error('nombre') border-red-500 @enderror"
                                       placeholder="Ej: Matemáticas I">
                                @error('nombre')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="profesor_id" class="block text-sm font-medium text-green-700 mb-2">Profesor:</label>
                            <select name="profesor_id" id="profesor_id" 
                                    class="w-full border border-green-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 @error('profesor_id') border-red-500 @enderror">
                                <option value="">Seleccionar profesor</option>
                                @foreach ($profesores as $profesor)
                                    <option value="{{ $profesor->id }}">
                                        {{ $profesor->user->name }} {{ $profesor->apellido }}
                                    </option>
                                @endforeach
                            </select>
                            @error('profesor_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="horario" class="block text-sm font-medium text-green-700 mb-2">Horario:</label>
                            <input type="text" name="horario" id="horario" 
                                   placeholder="Ej: Lunes y Miércoles 8:00 AM - 10:00 AM"
                                   class="w-full border border-green-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 @error('horario') border-red-500 @enderror">
                            @error('horario')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end space-x-4 pt-4">
                            <a href="{{ route('secretaria.clases.index') }}" 
                               class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-md transition duration-300 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="bg-green-600 hover:bg-green-700 text-black px-6 py-2 rounded-md transition duration-300 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Registrar Asignatura
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 