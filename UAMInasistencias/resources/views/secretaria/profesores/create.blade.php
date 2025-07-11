<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-green-900 leading-tight">
                {{ __('Registrar Nuevo Profesor') }}
            </h2>
            <a href="{{ route('secretaria.profesores.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 flex items-center gap-2">
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <h2 class="text-2xl font-bold text-green-900">Registrar Nuevo Profesor</h2>
                    </div>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('secretaria.profesores.store') }}" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="nombre" class="block text-sm font-medium text-green-700 mb-2">Nombre:</label>
                                <input type="text" name="nombre" id="nombre" required 
                                       class="w-full border border-green-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 @error('nombre') border-red-500 @enderror"
                                       placeholder="Ingrese el nombre del profesor">
                                @error('nombre')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="apellido" class="block text-sm font-medium text-green-700 mb-2">Apellido:</label>
                                <input type="text" name="apellido" id="apellido" required 
                                       class="w-full border border-green-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 @error('apellido') border-red-500 @enderror"
                                       placeholder="Ingrese el apellido del profesor">
                                @error('apellido')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-green-700 mb-2">Correo electrónico:</label>
                            <input type="email" name="email" id="email" required 
                                   class="w-full border border-green-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 @error('email') border-red-500 @enderror"
                                   placeholder="ejemplo@uam.edu.ni">
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="cif" class="block text-sm font-medium text-green-700 mb-2">CIF:</label>
                                <input type="text" name="cif" id="cif" required 
                                       class="w-full border border-green-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 @error('cif') border-red-500 @enderror"
                                       placeholder="Ingrese el CIF del profesor">
                                @error('cif')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="facultad" class="block text-sm font-medium text-green-700 mb-2">Facultad:</label>
                                <input type="text" name="facultad" id="facultad" required 
                                       class="w-full border border-green-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 @error('facultad') border-red-500 @enderror"
                                       placeholder="Ingrese la facultad">
                                @error('facultad')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end space-x-4 pt-4">
                            <a href="{{ route('secretaria.profesores.index') }}" 
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
                                Registrar Profesor
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 