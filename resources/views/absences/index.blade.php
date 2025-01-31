@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-2xl font-bold text-center mb-4">Ausencias para {{ $hour }} del {{ $date }}</h2>

        <div class="flex justify-between mb-4">
            <a href="{{ route('absences.index', ['date' => $date, 'hour' => \Carbon\Carbon::parse($hour)->subHour()->format('H:00')]) }}"
                class="px-4 py-2 bg-purple-500 text-white rounded hover:bg-purple-700">
                ⬅ Anterior
            </a>

            <a href="{{ route('absences.index', ['date' => $date, 'hour' => \Carbon\Carbon::parse($hour)->addHour()->format('H:00')]) }}"
                class="px-4 py-2 bg-purple-500 text-white rounded hover:bg-purple-700">
                Siguiente ➡
            </a>
        </div>

        @if ($absences->isEmpty())
            <p class="text-center text-gray-600">No hay ausencias registradas en este horario.</p>
        @else
            <ul class="divide-y divide-gray-300">
                @foreach ($absences as $absence)
                    <li class="p-4 bg-gray-100 rounded-lg shadow-md mb-2">
                        <p><strong>Profesor:</strong> {{ $absence->user->name }}</p>
                        <p><strong>Departamento:</strong> {{ $absence->department->name }}</p>
                        <p><strong>Comentario:</strong> {{ $absence->comment ?? 'Sin comentarios' }}</p>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

<!--ESTILO 2-->
<div class="max-w-3xl mx-auto mt-10">
    <h2 class="text-xl font-semibold mb-4">Ausencias para la Hora Actual ({{ $hour }})</h2>

    <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
        <thead class="bg-purple-600 text-white">
            <tr>
                <th class="p-3">Profesor</th>
                <th class="p-3">Departamento</th>
                <th class="p-3">Comentario</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($absences as $absence)
                <tr class="border-b">
                    <td class="p-3">{{ $absence->user->name }}</td>
                    <td class="p-3">{{ $absence->department->name }}</td>
                    <td class="p-3">{{ $absence->comment }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if ($absences->isEmpty())
        <p class="mt-4 text-gray-500">No hay ausencias registradas para esta hora.</p>
    @endif
</div>


<!--Estilo 3-->

<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Registrar Ausencia</h2>
    
    <form method="POST" action="{{ route('absences.store') }}" class="bg-white p-6 rounded-lg shadow-md">
        @csrf
        
        <div class="mb-4">
            <label for="date" class="block text-gray-700">Fecha:</label>
            <input type="date" id="date" name="date" class="w-full p-2 border rounded" required>
        </div>
        
        <div class="mb-4">
            <label for="hour" class="block text-gray-700">Hora:</label>
            <select id="hour" name="hour" class="w-full p-2 border rounded" required>
                {{-- @foreach ($hour as $horas)
                    <option value="{{ $horas }}">{{ $horas }}</option>
                @endforeach --}}
            </select>
        </div>
        
        <div class="mb-4">
            <label for="comment" class="block text-gray-700">Motivo:</label>
            <textarea id="comment" name="comment" class="w-full p-2 border rounded" required></textarea>
        </div>
        
        <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">Registrar Ausencia</button>
    </form>
</div>

<div class="container mx-auto p-6 mt-6">
    <h2 class="text-2xl font-bold mb-4">Ausencias para la Hora Actual</h2>
    
    <div class="bg-white p-6 rounded-lg shadow-md">
        <ul>
            @forelse ($absences as $absence)
                <li class="mb-2 p-4 border rounded">
                    <strong>{{ $absence->user->name }}</strong> - {{ $absence->user->department->name }}
                    <p class="text-gray-600">Motivo: {{ $absence->comment }}</p>
                </li>
            @empty
                <p>No hay ausencias registradas en esta hora.</p>
            @endforelse
        </ul>
    </div>
</div>
@endsection
