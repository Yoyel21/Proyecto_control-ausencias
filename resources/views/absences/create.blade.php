@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-6 bg-white rounded shadow">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Registrar Nueva Ausencia</h2>

    <form action="{{ route('absences.store') }}" method="POST">
        @csrf

        <!-- Fecha de la ausencia -->
        <label for="absence_date" class="block text-gray-700 font-medium">Fecha:</label>
        <input type="date" id="absence_date" name="absence_date" class="p-2 border rounded-md w-full mb-4" required>

        <!-- Selección de hora -->
        <label for="weekly_hour" class="block text-gray-700 font-medium">Hora:</label>
        <select id="weekly_hour" name="weekly_hour" class="p-2 border rounded-md w-full mb-4" required>
            <!-- Mañana -->
            <optgroup label="Manana">
                @foreach ($timeSlots as $slot)
                    @if (str_contains($slot->value, 'manana'))
                        <option value="{{ $slot->value }}">{{ $slot->getSchedule() }}</option>
                    @endif
                @endforeach
            </optgroup>

            <!-- Tarde -->
            <optgroup label="Tarde">
                @foreach ($timeSlots as $slot)
                    @if (str_contains($slot->value, 'tarde') && !str_contains($slot->value, 'martes'))
                        <option value="{{ $slot->value }}">{{ $slot->getSchedule() }}</option>
                    @endif
                @endforeach
            </optgroup>

            <!-- Martes por la tarde -->
            <optgroup label="Martes Tarde">
                @foreach ($timeSlots as $slot)
                    @if (str_contains($slot->value, 'martes'))
                        <option value="{{ $slot->value }}">{{ $slot->getSchedule() }}</option>
                    @endif
                @endforeach
            </optgroup>
        </select>

        <!-- Comentario -->
        <label for="comment" class="block text-gray-700 font-medium">Comentario:</label>
        <textarea id="comment" name="comment" class="p-2 border rounded-md w-full mb-4" rows="3"></textarea>

        <!-- Botón de enviar -->
        <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700 transition">
            Registrar Ausencia
        </button>
    </form>
</div>
@endsection

