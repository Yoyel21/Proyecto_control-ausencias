<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
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
                <a href="#" class="block px-4 py-2 text-purple-700 hover:bg-purple-100 rounded">Dashboard</a>
                <a href="#" class="block px-4 py-2 text-purple-700 hover:bg-purple-100 rounded">Gestión de Usuarios</a>
                <a href="#" class="block px-4 py-2 text-purple-700 hover:bg-purple-100 rounded">Gestión de Ausencias</a>
            </aside>

            <!-- Panel principal -->
            <main class="flex-1 p-6">
                <h2 class="text-2xl font-semibold mb-4">Bienvenido, Administrador</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-lg font-semibold">Usuarios Registrados</h3>
                        <p class="text-4xl font-bold mt-2">{{ $totalUsuarios ?? 0 }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-lg font-semibold">Ausencias Reportadas</h3>
                        <p class="text-4xl font-bold mt-2">{{ $totalAusencias ?? 0 }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-lg font-semibold">Departamentos</h3>
                        <p class="text-4xl font-bold mt-2">{{ $totalDepartamentos ?? 0 }}</p>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
