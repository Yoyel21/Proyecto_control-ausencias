@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto p-6">
        <a href=""></a>
        <!-- Título y navegación por día (opcional) -->
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-center mb-4 sm:mb-0">
                Ausencias del día <span class="font-normal">{{ $currentDate }}</span> - Franja: <span
                    class="font-normal">{{ $currentHour }}</span>
            </h2>
            <div class="flex gap-4">
                <a href="{{ route('absences.daily', ['date' => \Carbon\Carbon::parse($currentDate)->subDay()->toDateString(), 'hour' => $currentHour]) }}"
                    class="px-4 py-2 bg-purple-500 text-white rounded hover:bg-purple-700">
                    Día Anterior
                </a>
                <a href="{{ route('absences.daily', ['date' => \Carbon\Carbon::parse($currentDate)->addDay()->toDateString(), 'hour' => $currentHour]) }}"
                    class="px-4 py-2 bg-purple-500 text-white rounded hover:bg-purple-700">
                    Día Siguiente
                </a>
            </div>
        </div>

        @if ($absences->isEmpty())
            <p class="mt-4 text-center text-gray-500">No hay ausencias registradas para esta franja.</p>
        @endif
    </div>
@endsection
