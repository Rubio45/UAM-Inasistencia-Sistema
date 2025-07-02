@php
    $rol = Auth::user()->rol;
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-2 text-gray-900">Bienvenido, {{ Auth::user()->name }}</h3>
                    <p class="mb-4 text-gray-700">Tu rol: <span class="font-semibold text-cyan-700">{{ ucfirst($rol) }}</span></p>

                    @if($rol === 'estudiante')
                        <div class="bg-gray-50 rounded-lg p-4 mb-4 border border-cyan-100">
                            <h4 class="text-lg font-semibold mb-3 text-cyan-800">Panel de Estudiante</h4>
                            <p class="text-gray-700 mb-4">Desde aquí puedes gestionar tus solicitudes de inasistencia.</p>
                            <a href="{{ route('solicitudes.index') }}" class="bg-cyan-700 text-white px-6 py-3 rounded-lg font-semibold hover:bg-cyan-800 hover:scale-105 transition inline-block">
                                Ver mis solicitudes
                            </a>
                        </div>
                    @else
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <p class="text-yellow-800">Tu perfil está siendo configurado. Por favor, contacta al administrador.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
