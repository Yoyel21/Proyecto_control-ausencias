@extends('admin.dashboardLayout')

@section('content')
    <div class="max-w-4xl mx-auto p-6 bg-white rounded shadow">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Gestión de Ausencias</h2>

        <!-- Formulario para registrar ausencia -->
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Registrar una Ausencia Nueva</h3>
        <form action="{{ route('admin.absences.store') }}" method="POST" class="mb-6">
            @csrf

            <!-- Selección de profesor -->
            <label for="user_id" class="block text-gray-700 font-medium">Profesor:</label>
            <select id="user_id" name="user_id" class="p-2 border rounded-md w-full mb-4" required>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->department->name }})</option>
                @endforeach
            </select>

            <!-- Fecha de la ausencia -->
            <label for="date" class="block text-gray-700 font-medium">Fecha:</label>
            <input type="date" id="date" name="date" class="p-2 border rounded-md w-full mb-4" required>

            <!-- Selección de hora -->
            <label for="hour" class="block text-gray-700 font-medium">Hora:</label>
            <select name="hour">
                <!-- Mañana -->
                <optgroup label="Mañana">
                    @foreach ($timeSlots as $slot)
                        @if (str_contains($slot->value, 'manana'))
                            <option value="{{ $slot->value }}">
                                {{ $slot->getSchedule() }}</option>
                        @endif
                    @endforeach
                </optgroup>

                <!-- Tarde -->
                <optgroup label="Tarde">
                    @foreach ($timeSlots as $slot)
                        @if (str_contains($slot->value, 'tarde') && !str_contains($slot->value, 'martes'))
                            <option value="{{ $slot->value }}">
                                {{ $slot->getSchedule() }}</option>
                        @endif
                    @endforeach
                </optgroup>

                <!-- Martes por la tarde -->
                <optgroup label="Martes Tarde">
                    @foreach ($timeSlots as $slot)
                        @if (str_contains($slot->value, 'martes'))
                            <option value="{{ $slot->value }}">
                                {{ $slot->getSchedule() }}</option>
                        @endif
                    @endforeach
                </optgroup>
            </select>

            <!-- Comentario opcional -->
            <label for="comment" class="block text-gray-700 font-medium">Comentario:</label>
            <textarea id="comment" name="comment" class="p-2 border rounded-md w-full mb-4" rows="3"></textarea>

            <!-- Botón de enviar -->
            <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700 transition">
                Registrar Ausencia
            </button>
        </form>

        <!-- Listado de ausencias -->
        <h3 class="text-xl font-semibold text-gray-800 mb-4 pt-5">Todas las Ausencias</h3>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border p-2">Profesor</th>
                        <th class="border p-2">Departamento</th>
                        <th class="border p-2">Fecha</th>
                        <th class="border p-2">Hora</th>
                        <th class="border p-2">Comentario</th>
                        <th class="border p-2">Acciones</th> <!-- Nueva columna -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($absences as $absence)
                        <tr class="border">
                            <td class="border p-2">{{ $absence->user->name }}</td>
                            <td class="border p-2">{{ $absence->user->department->name }}</td>
                            <td class="border p-2">{{ $absence->date }}</td>
                            <td class="border p-2">{{ $absence->hour->getSchedule() }}</td>
                            <td class="border p-2">{{ $absence->comment }}</td>
                            <td class="border p-2 flex gap-2">
                                <!-- Botón Editar -->
                                <a href="{{ route('admin.absences.edit', $absence->id) }}"
                                    class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition">
                                    ✏️ Editar
                                </a>

                                <!-- Botón Eliminar -->
                                <form action="{{ route('admin.absences.destroy', $absence->id) }}" method="POST"
                                    onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta ausencia?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition">
                                        🗑️ Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
