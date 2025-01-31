<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <!-- Navbar -->
        <nav class="bg-purple-700 text-white p-4 shadow-md flex justify-between items-center">
            <h1 class="text-xl font-semibold">Panel de Administración</h1>
        </nav>

        <!-- Contenido principal -->
        <div class="flex flex-col md:flex-row flex-1">
            <!-- Sidebar -->
            <aside class="bg-white shadow-md w-full md:w-64 p-4 space-y-4">
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-purple-700 hover:bg-purple-100 rounded">Dashboard</a>
                <a href="{{ route('admin.users') }}" class="block px-4 py-2 text-purple-700 hover:bg-purple-100 rounded">Gestión de Usuarios</a>
                <a href="{{ route('admin.absences') }}" class="block px-4 py-2 text-purple-700 hover:bg-purple-100 rounded">Gestión de Ausencias</a>
            </aside>

            <!-- Panel principal -->
            <main class="flex-1 p-6">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>

