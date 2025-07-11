<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Inasistencias - UAM</title>
    <link rel="icon" href="{{ asset('images/uam-logo.png') }}" type="image/x-icon">
    <meta name="description" content="Sistema de gestión de inasistencias para la Universidad Americana. Plataforma para alumnos y profesores.">
    <meta name="keywords" content="UAM, inasistencias, universidad, alumnos, profesores, gestión">
    <meta name="author" content="Scrum masters">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="relative bg-[#0E7490] min-h-screen flex items-center justify-center">

    <div class="bg-white p-10 rounded-xl shadow-xl text-center max-w-md w-full">
        <!-- Logo UAM -->
        <div class="flex justify-center mb-6">
            <img src="{{ asset('images/uam-logo.png') }}" alt="Logo UAM" class="w-24 h-24 object-contain">
        </div>

        <!-- Título -->
        <h1 class="text-2xl font-bold text-[#0E7490] mb-2">¡Bienvenido al sistema de inasistencias!</h1>
        <p class="text-gray-600 mb-6">Seleccione al sitio al que desea ingresar</p>

        <!-- Botones -->
        <div class="flex flex-col gap-4">
            <a href="{{ route('login') }}" class="bg-cyan-700 text-white py-3 px-6 rounded-lg font-semibold hover:bg-cyan-800 transition-colors duration-200 flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Acceso Estudiantes
            </a>
            <a href="{{ route('profesor.login') }}" class="bg-cyan-700 text-white py-3 px-6 rounded-lg font-semibold hover:bg-cyan-800 transition-colors duration-200 flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V6a4 4 0 018 0v1m-9 4h10m-12 0a2 2 0 012-2h12a2 2 0 012 2v7a2 2 0 01-2 2H6a2 2 0 01-2-2v-7z" />
                </svg>
                Acceso Profesores
            </a>
        </div>
    </div>

</body>
</html>
