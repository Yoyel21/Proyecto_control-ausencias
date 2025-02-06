<div>
    <h2 class="text-2xl font-bold text-center mb-4">
        Ausencias del día <span class="font-normal">{{ $currentDate }}</span>
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
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow rounded-lg overflow-hidden mb-6">
            <thead class="bg-purple-600 text-white">
                <tr>
                    <th class="p-3 text-left">Profesor</th>
                    <th class="p-3 text-left">Departamento</th>
                    <th class="p-3 text-left">Hora</th>
                    <th class="p-3 text-left">Comentario</th>
                    <th class="p-3 text-left">Registrado</th>
                    <th class="p-3 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($dailyAbsences as $absence)
                    <tr class="hover:bg-gray-100">
                        <td class="p-3">{{ $absence->user->name }}</td>
                        <td class="p-3">{{ $absence->user->department->name }}</td>
                        <td class="p-3">{{ $absence->hour->getSchedule() }}</td>
                        <td class="p-3">{{ $absence->comment ?? '-' }}</td>
                        <td class="p-3">{{ $absence->created_at->diffForHumans() }}</td>
                        <td class="p-3">
                            @if (Auth::id() === $absence->user_id || Auth::user()->is_admin)
                                <div class="flex space-x-2">
                                    <!-- Botón que abre el modal -->
                                    @if (Auth::id() === $absence->user_id || Auth::user()->is_admin)
                                        <button onclick="openModal('editModal-{{ $absence->id }}')"
                                            class="bg-purple-500 text-white px-3 py-1 rounded hover:bg-purple-700">
                                            Editar
                                        </button>

                                        <!-- Modal de edición -->
                                        <div id="editModal-{{ $absence->id }}"
                                            class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden">
                                            <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                                                <h2 class="text-xl font-bold mb-4">Editar Ausencia</h2>

                                                <form action="{{ route('absences.update', $absence->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <label for="date"
                                                        class="block text-sm font-medium text-gray-700">Fecha:</label>
                                                    <input type="date" id="date" name="date"
                                                        value="{{ $absence->date }}" required
                                                        class="w-full p-2 border rounded">

                                                    <label for="hour"
                                                        class="block text-sm font-medium text-gray-700 mt-2">Hora:</label>
                                                    <select id="hour" name="hour"
                                                        class="p-2 border rounded-md w-full mb-4" required>
                                                        <!-- Mañana -->
                                                        <optgroup label="Manana">
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

                                                    <label for="comment"
                                                        class="block text-sm font-medium text-gray-700 mt-2">Comentario:</label>
                                                    <textarea id="comment" name="comment" class="w-full p-2 border rounded">{{ $absence->comment }}</textarea>

                                                    <div class="flex justify-between mt-4">
                                                        <button type="button"
                                                            onclick="closeModal('editModal-{{ $absence->id }}')"
                                                            class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700">
                                                            Cancelar
                                                        </button>
                                                        <button type="submit"
                                                            class="bg-purple-500 text-white px-4 py-2 rounded hover:bg-purple-700">
                                                            Guardar Cambios
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- JavaScript para manejar el modal -->
                                    <script>
                                        function openModal(modalId) {
                                            document.getElementById(modalId).classList.remove('hidden');
                                        }

                                        function closeModal(modalId) {
                                            document.getElementById(modalId).classList.add('hidden');
                                        }
                                    </script>
                                    <form action="{{ route('absences.destroy', $absence) }}" method="POST"
                                        onsubmit="return confirm('¿Estás seguro?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-700">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            @else
                                <span class="text-gray-500">No has registrado esta falta</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if ($dailyAbsences->isEmpty())
        <p class="text-center text-gray-500">No hay ausencias registradas para este día.</p>
    @endif
</div>
