@extends('admin.dashboardLayout')

@section('content')
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
@endsection