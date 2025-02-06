@extends('layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto p-6" x-data="{ view: 'daily' }">
        <div class="flex justify-end mb-4">
            <a href="{{ route('absences.create') }}"
                class="bg-purple-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-purple-700 transition">
                Registrar Nueva Ausencia
            </a>
        </div>
        <!-- Botones para cambiar entre vista diaria y semanal -->
        {{-- <div class="flex justify-center gap-4 mb-6">
            <button x-on:click="view = 'daily'"
                :class="view === 'daily' ? 'bg-purple-600 text-white' : 'bg-gray-200 text-gray-800'"
                class="px-4 py-2 rounded transition duration-300">
                Vista Diaria
            </button>
            <button x-on:click="view = 'weekly'"
                :class="view === 'weekly' ? 'bg-purple-600 text-white' : 'bg-gray-200 text-gray-800'"
                class="px-4 py-2 rounded transition duration-300">
                Vista Semanal
            </button>
        </div> --}}

        <!-- Vista Diaria -->
        <div x-show="view === 'daily'" x-cloak>
            @include('absences.partials.daily', [
                'currentDate' => $currentDate,
                'currentHour' => $currentHour,
                'absences' => $dailyAbsences,
            ])
        </div>

        <!-- Vista Semanal -->
        <div x-show="view === 'weekly'" x-cloak>
            @include('absences.partials.weekly', [
                'selectedDate' => $selectedDate,
                'selectedHour' => $selectedHour,
                'absences' => $weeklyAbsences,
                'timeSlots' => $timeSlots,
            ])
        </div>
    </div>
@endsection