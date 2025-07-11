<x-guest-layout>
    <div class="text-center mb-8">
        <div class="flex justify-center mb-4">
            <img src="{{ asset('images/uam-logo.png') }}" alt="UAM Logo" class="w-16 h-16">
        </div>
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Recuperar Contraseña</h2>
        <p class="text-gray-600">Sistema de Inasistencias UAM</p>
    </div>

    <div class="bg-cyan-50 border border-cyan-200 rounded-lg p-4 mb-6">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-cyan-800">
                    ¿Olvidaste tu contraseña? No hay problema. Solo ingresa tu dirección de correo electrónico y te enviaremos un enlace para restablecer tu contraseña.
                </p>
            </div>
        </div>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-800">
                        {{ session('status') }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                Correo Electrónico
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                    </svg>
                </div>
                <input id="email" 
                       type="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       required 
                       autofocus
                       class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-colors duration-200"
                       placeholder="ejemplo@uam.edu.mx">
            </div>
            @error('email')
                <div class="mt-2 flex items-center">
                    <svg class="h-4 w-4 text-red-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm text-red-600">{{ $message }}</p>
                </div>
            @enderror
        </div>

        <div class="flex flex-col sm:flex-row gap-3">
            <button type="submit" 
                    class="flex-1 bg-cyan-700 text-white px-6 py-3 rounded-lg font-medium hover:bg-cyan-800 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 transition-colors duration-200 flex items-center justify-center">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                Enviar Enlace de Restablecimiento
            </button>
            
            <a href="{{ route('login') }}" 
               class="flex-1 bg-gray-100 text-gray-700 px-6 py-3 rounded-lg font-medium hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200 flex items-center justify-center">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver al Login
            </a>
        </div>
    </form>

    <div class="mt-8 pt-6 border-t border-gray-200">
        <div class="text-center">
            <p class="text-sm text-gray-600">
                ¿No tienes una cuenta? 
                <a href="{{ route('register') }}" class="font-medium text-cyan-700 hover:text-cyan-800 transition-colors duration-200">
                    Regístrate aquí
                </a>
            </p>
        </div>
    </div>
</x-guest-layout>
