<div>
    <h2 class="text-2xl font-bold text-center mb-4">
        Ausencias del día <span class="font-normal">{{ $currentDate }}</span> - Franja: <span
            class="font-normal">{{ $currentHour }}</span>
    </h2>

    <!-- Navegación por día (opcional) -->
    <div class="flex justify-between mb-4">
        <a href="{{ route('absences.index', ['daily_date' => \Carbon\Carbon::parse($currentDate)->subDay()->toDateString(), 'daily_hour' => $currentHour]) }}"
            class="px-4 py-2 bg-purple-500 text-white rounded hover:bg-purple-700">
            Día Anterior
        </a>
        <a href="{{ route('absences.index', ['daily_date' => \Carbon\Carbon::parse($currentDate)->addDay()->toDateString(), 'daily_hour' => $currentHour]) }}"
            class="px-4 py-2 bg-purple-500 text-white rounded hover:bg-purple-700">
            Día Siguiente
        </a>
    </div>

    <!-- Tabla de ausencias para la franja diaria -->
    <table class="min-w-full bg-white shadow rounded-lg overflow-hidden mb-6">
        <thead class="bg-purple-600 text-white">
            <tr>
                <th class="p-3 text-left">Profesor</th>
                <th class="p-3 text-left">Departamento</th>
                <th class="p-3 text-left">Hora</th>
                <th class="p-3 text-left">Comentario</th>
                <th class="p-3 text-left">Registrado</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach ($absences as $absence)
                <tr class="hover:bg-gray-100">
                    <td class="p-3">{{ $absence->user->name }}</td>
                    <td class="p-3">{{ $absence->department->name }}</td>
                    <td class="p-3">{{ $absence->hour->getSchedule() }}</td>
                    <td class="p-3">{{ $absence->comment ?? 'Sin comentarios' }}</td>
                    <td class="p-3">{{ $absence->created_at->diffForHumans() }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if ($absences->isEmpty())
        <p class="text-center text-gray-500">No hay ausencias registradas para esta franja.</p>
    @endif

    <!-- Formulario para registrar una ausencia (los cambios de 10 minutos se controlan en el backend) -->
    <div class="mt-8 bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-xl font-semibold mb-4">Registrar Ausencia</h3>
        <form action="{{ route('absences.store') }}" method="POST" class="space-y-4">
            @csrf
            <!-- Enviamos la fecha y la hora actual como campos ocultos -->
            <input type="hidden" name="date" value="{{ $currentDate }}">
            <input type="hidden" name="hour" value="{{ $currentHour }}">
            <div class="mb-4">
                <label for="comment_daily" class="block text-gray-700">Comentario:</label>
                <textarea name="comment" id="comment_daily" class="w-full p-2 border rounded-md" required></textarea>
            </div>
            <button type="submit" class="w-full bg-purple-600 text-white py-2 px-4 rounded hover:bg-purple-700">
                Registrar Ausencia
            </button>
        </form>
    </div>
</div>
