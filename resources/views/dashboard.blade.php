<x-app-layout>

    @extends('layouts.app')

    @section('content')
        @if (auth()->user()->is_admin)
            @include('admin.dashboardLayout')
        @else
            <h2>Bienvenido a tu perfil</h2>
            <p>Aquí puedes gestionar tu cuenta.</p>
        @endif
    @endsection
</x-app-layout>
