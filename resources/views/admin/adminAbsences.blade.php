@extends('admin.dashboardLayout')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded shadow">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Gestión de Ausencias</h2>
    
    <!-- Formulario para registrar ausencia -->
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
        <select id="hour" name="hour" class="p-2 border rounded-md w-full mb-4" required>
            <optgroup label="Mañana">
                @foreach ($timeSlots as $slot)
                    @if (str_contains($slot->value, 'mañana'))
                        <option value="{{ $slot->value }}">{{ $slot->getSchedule() }}</option>
                    @endif
                @endforeach
            </optgroup>
            <optgroup label="Tarde">
                @foreach ($timeSlots as $slot)
                    @if (str_contains($slot->value, 'tarde') && !str_contains($slot->value, 'martes'))
                        <option value="{{ $slot->value }}">{{ $slot->getSchedule() }}</option>
                    @endif
                @endforeach
            </optgroup>
            <optgroup label="Martes Tarde">
                @foreach ($timeSlots as $slot)
                    @if (str_contains($slot->value, 'martes'))
                        <option value="{{ $slot->value }}">{{ $slot->getSchedule() }}</option>
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
    <h3 class="text-xl font-semibold text-gray-800 mb-4">Todas las Ausencias</h3>
    <div class="overflow-x-auto">
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2">Profesor</th>
                    <th class="border p-2">Departamento</th>
                    <th class="border p-2">Fecha</th>
                    <th class="border p-2">Hora</th>
                    <th class="border p-2">Comentario</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($absences as $absence)
                <tr class="border">
                    <td class="border p-2">{{ $absence->user->name }}</td>
                    <td class="border p-2">{{ $absence->department->name }}</td>
                    <td class="border p-2">{{ $absence->date }}</td>
                    <td class="border p-2">{{ $absence->hour }}</td>
                    <td class="border p-2">{{ $absence->comment }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
