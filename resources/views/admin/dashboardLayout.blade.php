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
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </nav>

        <!-- Contenido principal -->
        <div class="flex flex-col md:flex-row flex-1">
            <!-- Sidebar -->
            <aside class="bg-white shadow-md w-full md:w-64 p-4 space-y-4">
                <a href="{{ route('admin.dashboard') }}"
                    class="block px-4 py-2 text-purple-700 hover:bg-purple-100 rounded">Dashboard</a>
                <a href="{{ route('admin.users.index') }}"
                    class="block px-4 py-2 text-purple-700 hover:bg-purple-100 rounded">Gestión de Usuarios</a>
                <a href="{{ route('admin.absences.index') }}"
                    class="block px-4 py-2 text-purple-700 hover:bg-purple-100 rounded">Gestión de Ausencias</a>
            </aside>
            <!-- Panel principal -->
            <main class="flex-1 p-6">
                @if (View::getSection('content'))
                    @yield('content')
                @else
                    <!-- Contenido del Dashboard por defecto -->
                    <h2 class="text-2xl font-semibold mb-4">Bienvenido, {{ Auth::user()->name }}</h2>
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
                @endif
            </main>
        </div>
    </div>
</body>

</html>