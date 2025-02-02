<div>
    <h2 class="text-2xl font-bold text-center mb-4">Resumen de Ausencias de la Semana</h2>

    <!-- Formulario para seleccionar fecha y hora de la semana -->
    <form method="GET" action="{{ route('absences.index') }}"
        class="mb-6 flex flex-col md:flex-row gap-4 items-center justify-center">
        <div>
            <label for="weekly_date" class="block text-gray-700 font-medium">Fecha:</label>
            <input type="date" id="weekly_date" name="weekly_date" value="{{ $selectedDate }}"
                class="p-2 border rounded-md" required>
        </div>
        <div>
            <label for="weekly_hour" class="block text-gray-700 font-medium">Hora:</label>
            <select id="weekly_hour" name="weekly_hour" class="p-2 border rounded-md" required>
                <!-- Mañana -->
                <optgroup label="Mañana">
                    @foreach ($timeSlots as $slot)
                        @if (str_contains($slot->value, 'manana'))
                            <option value="{{ $slot->value }}" {{ $selectedHour == $slot->value ? 'selected' : '' }}>
                                {{ $slot->getSchedule() }}
                            </option>
                        @endif
                    @endforeach
                </optgroup>
            
                <!-- Tarde -->
                <optgroup label="Tarde">
                    @foreach ($timeSlots as $slot)
                        @if (str_contains($slot->value, 'tarde') && !str_contains($slot->value, 'martes'))
                            <option value="{{ $slot->value }}" {{ $selectedHour == $slot->value ? 'selected' : '' }}>
                                {{ $slot->getSchedule() }}
                            </option>
                        @endif
                    @endforeach
                </optgroup>
            
                <!-- Martes por la tarde -->
                <optgroup label="Martes Tarde">
                    @foreach ($timeSlots as $slot)
                        @if (str_contains($slot->value, 'martes'))
                            <option value="{{ $slot->value }}" {{ $selectedHour == $slot->value ? 'selected' : '' }}>
                                {{ $slot->getSchedule() }}
                            </option>
                        @endif
                    @endforeach
                </optgroup>
            </select>
        </div>
        <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">Ver
            Ausencias</button>
    </form>

    <!-- Tabla de ausencias filtradas por la selección semanal -->
    <table class="min-w-full bg-white shadow rounded-lg overflow-hidden">
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
        <tbody class="divide-y divide-gray-200">
            @foreach ($absences as $absence)
                <tr class="hover:bg-gray-100">
                    <td class="p-3">{{ $absence->date }}</td>
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
        <p class="mt-4 text-center text-gray-500">No hay ausencias registradas para esta selección.</p>
    @endif
</div>
