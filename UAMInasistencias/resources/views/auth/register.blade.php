<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Perfil - UAM</title>
    <link rel="icon" href="{{ asset('images/uam-logo.png') }}" type="image/x-icon">
    <meta name="description" content="Crear perfil en el sistema de inasistencias de la Universidad Americana.">
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

    <div class="bg-white w-full max-w-md rounded-lg shadow-lg p-8 relative">

        <!-- Icono de salir -->
        <a href="{{ route('login') }}" class="absolute top-4 right-4 text-gray-600 hover:text-uam text-lg">
            <i class="fas fa-arrow-right-from-bracket"></i>
        </a>

        <!-- Título -->
        <h2 class="text-xl font-semibold text-gray-800 mb-6">CREAR PERFIL</h2>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

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

            <!-- NOMBRE -->
            <div>
                <label class="text-sm text-gray-700 block">NOMBRES</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="w-full mt-1 p-2 rounded bg-gray-200 text-gray-800 outline-none focus:ring-2 focus:ring-uam @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- APELLIDO -->
            <div>
                <label class="text-sm text-gray-700 block">APELLIDOS</label>
                <input type="text" name="apellido" value="{{ old('apellido') }}" required
                    class="w-full mt-1 p-2 rounded bg-gray-200 text-gray-800 outline-none focus:ring-2 focus:ring-uam @error('apellido') border-red-500 @enderror">
                @error('apellido')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- CIF -->
            <div>
                <label class="text-sm text-gray-700 block">CIF</label>
                <input type="text" name="cif" value="{{ old('cif') }}" required
                    class="w-full mt-1 p-2 rounded bg-gray-200 text-gray-800 outline-none focus:ring-2 focus:ring-uam @error('cif') border-red-500 @enderror">
                @error('cif')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- CARRERA -->
            <div>
                <label class="text-sm text-gray-700 block">CARRERA</label>
                <input type="text" name="carrera" value="{{ old('carrera') }}" required
                    class="w-full mt-1 p-2 rounded bg-gray-200 text-gray-800 outline-none focus:ring-2 focus:ring-uam @error('carrera') border-red-500 @enderror">
                @error('carrera')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- CORREO -->
            <div>
                <label class="text-sm text-gray-700 block">CORREO</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full mt-1 p-2 rounded bg-gray-200 text-gray-800 outline-none focus:ring-2 focus:ring-uam @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- PIN (password) -->
            <div>
                <label class="text-sm text-gray-700 block">CONTRASEÑA</label>
                <input type="password" name="password" required
                    class="w-full mt-1 p-2 rounded bg-gray-200 text-gray-800 outline-none focus:ring-2 focus:ring-uam @error('password') border-red-500 @enderror">
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirmación de PIN -->
            <div>
                <label class="text-sm text-gray-700 block">CONFIRMAR CONTRASEÑA</label>
                <input type="password" name="password_confirmation" required
                    class="w-full mt-1 p-2 rounded bg-gray-200 text-gray-800 outline-none focus:ring-2 focus:ring-uam">
            </div>

            <!-- Botón -->
            <div class="flex justify-end">
                <button type="submit"
                    class="bg-uam text-white text-sm px-4 py-2 rounded hover:bg-cyan-800 transition">
                    CREAR
                </button>
            </div>
        </form>

    </div>

    <!-- FontAwesome for icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
</body>
</html>
