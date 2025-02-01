@extends('admin.dashboardLayout')

@section('content')
    <div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-purple-700 mb-6">Gestión de Usuarios</h2>

        <!-- Selector de método de registro (Individual / CSV) -->


        <!-- Formulario de Registro Individual -->
        <div class="space-y-4">
            <h3 class="text-xl font-semibold text-gray-800">Registrar Usuario Individual</h3>
            <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="name" class="block text-gray-700">Nombre:</label>
                    <input type="text" name="name" id="name" class="w-full p-2 border rounded-md" required>
                </div>
                <div>
                    <label for="email" class="block text-gray-700">Correo Electrónico:</label>
                    <input type="email" name="email" id="email" class="w-full p-2 border rounded-md" required>
                </div>
                <div>
                    <label for="department_id" class="block text-gray-700">Departamento:</label>
                    <select name="department_id" id="department_id" class="w-full p-2 border rounded-md" required>
                        @foreach (\App\Models\Department::all() as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="alias" class="block text-gray-700">Alias:</label>
                    <input type="text" name="alias" id="alias" class="w-full p-2 border rounded-md" required>
                </div>
                <!-- No es necesario generar contraseña, se usará 'olvidé la contraseña' -->
                <button type="submit" class="w-full bg-purple-600 text-white py-2 rounded-md hover:bg-purple-700">
                    Registrar Usuario
                </button>
            </form>
        </div>

        <!-- Formulario para Carga CSV -->
        <div class="space-y-4">
            <h3 class="text-xl font-semibold text-gray-800">Cargar Usuarios desde CSV</h3>
            <form action="{{ route('admin.processCsv') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label for="csv_file" class="block text-gray-700">Archivo CSV:</label>
                    <input type="file" name="csv_file" id="csv_file" class="w-full p-2 border rounded-md" accept=".csv"
                        required>
                </div>
                <p class="text-sm text-gray-600">El CSV debe tener el formato:
                    <code>nombre;apellidos;email;dept;alias</code></p>
                <button type="submit" class="w-full bg-purple-600 text-white py-2 rounded-md hover:bg-purple-700">
                    Subir Archivo CSV
                </button>
            </form>
        </div>
    </div>
@endsection
