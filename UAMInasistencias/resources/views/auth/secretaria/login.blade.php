<x-guest-layout>
    <div class="text-center mb-8">
        <div class="flex justify-center mb-4">
            <img src="{{ asset('images/uam-logo.png') }}" alt="UAM Logo" class="w-16 h-16">
        </div>
        <h2 class="text-2xl font-bold text-green-900 mb-2">Acceso Secretaría Académica</h2>
        <p class="text-green-700">Sistema de Inasistencias UAM</p>
    </div>

    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h10a2 2 0 012 2v14a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-green-800">
                    Ingresa tus credenciales para acceder al panel de secretaría académica.
                </p>
            </div>
        </div>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('secretaria.login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-green-900 mb-2">
                Correo Electrónico
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                    </svg>
                </div>
                <input id="email" 
                       type="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       required 
                       autofocus
                       class="block w-full pl-10 pr-3 py-3 border border-green-300 rounded-lg shadow-sm placeholder-green-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200"
                       placeholder="secretaria@uamv.edu.ni">
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

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-green-900 mb-2">
                Contraseña
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <input id="password" 
                       type="password" 
                       name="password" 
                       required 
                       autocomplete="current-password"
                       class="block w-full pl-10 pr-3 py-3 border border-green-300 rounded-lg shadow-sm placeholder-green-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200"
                       placeholder="Ingresa tu contraseña">
            </div>
            @error('password')
                <div class="mt-2 flex items-center">
                    <svg class="h-4 w-4 text-red-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm text-red-600">{{ $message }}</p>
                </div>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember" class="inline-flex items-center">
                <input id="remember" type="checkbox" name="remember" class="rounded border-green-300 text-green-600 shadow-sm focus:border-green-500 focus:ring-green-500">
                <span class="ml-2 text-sm text-green-700">Recordarme</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-green-700 hover:text-green-800 transition-colors duration-200" href="{{ route('password.request') }}">
                    ¿Olvidaste tu contraseña?
                </a>
            @endif
        </div>

        <!-- Botón Iniciar Sesión -->
        <button type="submit"
            class="w-full mt-6 bg-green-700 text-black text-lg px-6 py-3 rounded-lg font-bold shadow hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors duration-200 flex items-center justify-center">
            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
            </svg>
            Iniciar Sesión
        </button>
    </form>

    <div class="mt-8 pt-6 border-t border-green-200">
        <div class="text-center">
            <p class="text-sm text-green-700">
                ¿Necesitas ayuda? 
                <a href="mailto:soporte@uam.edu.ni" class="font-medium text-green-800 hover:text-green-900 transition-colors duration-200">
                    Contacta al administrador
                </a>
            </p>
        </div>
    </div>

    <!-- Enlace de retorno -->
    <div class="text-center mt-4">
        <a href="{{ route('welcome') }}"
           class="inline-flex items-center justify-center w-full px-4 py-2 bg-green-50 border border-green-600 text-green-700 font-semibold rounded-lg hover:bg-green-100 hover:text-green-800 transition-colors duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Volver a la página principal
        </a>
    </div>
</x-guest-layout> 