@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Subir Usuarios desde CSV</h2>
        <form action="{{ route('admin.import-users') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="csv_file" required>
            <button type="submit">Subir</button>
        </form>

        @if (session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif
    </div>
@endsection
