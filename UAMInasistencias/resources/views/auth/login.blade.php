<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio de Sesión - UAM</title>
    <link rel="icon" href="{{ asset('images/uam-logo.png') }}" type="image/x-icon">
    <meta name="description" content="Inicio de sesión en el sistema de inasistencias de la Universidad Americana.">
    <meta name="keywords" content="UAM, inasistencias, universidad, alumnos, profesores, gestión">
    <meta name="author" content="Scrum masters">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        uam: '#009DA9'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-uam min-h-screen flex items-center justify-center">

    <div class="bg-white w-full max-w-sm rounded-lg shadow-lg p-8">

        <!-- Logo -->
        <div class="text-center mb-6">
            <img src="{{ asset('images/uam-logo.png') }}" alt="Logo UAM" class="mx-auto w-24 h-24 object-contain">
            <h2 class="text-xl font-semibold text-gray-800 mt-4">INICIAR SESIÓN</h2>
        </div>

        <!-- Mostrar errores de validación -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulario -->
        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <!-- Correo UAM -->
            <div>
                <label class="text-sm text-gray-700 block">CORREO UAM</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    placeholder="tu.correo@uamv.edu.ni"
                    class="w-full mt-1 p-3 rounded bg-gray-100 text-gray-800 outline-none focus:ring-2 focus:ring-uam focus:bg-white @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Contraseña -->
            <div>
                <label class="text-sm text-gray-700 block">CONTRASEÑA</label>
                <input type="password" name="password" required
                    placeholder="Ingresa tu contraseña"
                    class="w-full mt-1 p-3 rounded bg-gray-100 text-gray-800 outline-none focus:ring-2 focus:ring-uam focus:bg-white @error('password') border-red-500 @enderror">
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Botón -->
            <div class="pt-4">
                <button type="submit" class="w-full bg-uam text-white font-semibold py-3 rounded hover:bg-cyan-800 hover:scale-105 transition">
                    INICIAR SESIÓN
                </button>
            </div>
        </form>

        <!-- Enlaces -->
        <div class="flex justify-between mt-6 text-sm">
            <a href="{{ route('register') }}" class="text-uam hover:underline">Crear cuenta</a>
            <a href="{{ route('password.request') }}" class="text-uam hover:underline">¿Olvidaste tu contraseña?</a>
        </div>

    </div>

</body>
</html>
