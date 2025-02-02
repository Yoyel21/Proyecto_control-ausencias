<x-app-layout>

    @extends('layouts.app')

    @section('content')
        @if (auth()->user()->is_admin)
            @include('admin.dashboardLayout')
        @else
        @include('absences.index')
        @endif
    @endsection
</x-app-layout>
