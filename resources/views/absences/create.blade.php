@extends('layouts.app')

@section('content')
    <div class="max-w-lg mx-auto mt-10 bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-4">Registrar Ausencia</h2>

        <form action="{{ route('absences.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium">Fecha</label>
                <input type="date" name="date" class="w-full p-2 border rounded-lg" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">Hora</label>
                <select name="hour" class="w-full p-2 border rounded-lg" required>
                    @for ($i = 8; $i <= 19; $i++)
                        <option value="{{ $i }}:00">{{ $i }}:00</option>
                    @endfor
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">Comentario</label>
                <textarea name="comment" class="w-full p-2 border rounded-lg"></textarea>
            </div>

            <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded-lg">Registrar</button>
        </form>
    </div>
@endsection
