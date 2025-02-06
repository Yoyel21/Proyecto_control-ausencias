<div>
    <h2 class="text-2xl font-bold text-center mb-4">Resumen de Ausencias de la Semana</h2>

    <!-- Formulario para seleccionar la fecha de la semana -->
    <form method="GET" action="{{ route('absences.index') }}"
        class="mb-6 flex flex-col md:flex-row gap-4 items-center justify-center">
        <div>
            <label for="weekly_date" class="block text-gray-700 font-medium">Fecha de la Semana:</label>
            <input type="date" id="weekly_date" name="weekly_date" value="{{ $selectedDate }}"
                class="p-2 border rounded-md" required>
        </div>
        <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">Ver
            Ausencias</button>
    </form>

    <!-- Tabla de ausencias filtradas por la selección semanal -->
    <table class="min-w-full bg-white shadow rounded-lg overflow-hidden mb-6 lg:table lg:divide-y lg:divide-gray-200">
        <thead class="bg-purple-600 text-white">
            <tr>
                <th class="p-3 text-left">Fecha</th>
                <th class="p-3 text-left">Profesor</th>
                <th class="p-3 text-left">Departamento</th>
                <th class="p-3 text-left">Hora</th>
                <th class="p-3 text-left">Comentario</th>
                <th class="p-3 text-left">Registrado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($absences as $absence)
                <tr class="hover:bg-gray-100">
                    <td class="p-3">{{ $absence->date }}</td>
                    <td class="p-3">{{ $absence->user->name }}</td>
                    <td class="p-3">{{ $absence->user->department->name }}</td>
                    <td class="p-3">{{ $absence->hour->getSchedule() }}</td>
                    <td class="p-3">{{ $absence->comment ?? 'Sin comentarios' }}</td>
                    <td class="p-3">{{ $absence->created_at->diffForHumans() }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if ($absences->isEmpty())
        <p class="mt-4 text-center text-gray-500">No hay ausencias registradas para esta selección.</p>
    @endif
</div>
