@extends('layouts.app')

@section('content')
    @include ('admin.partials._nav', ['page' => 'users'])

    <h4 class="header-title">Users</h4>

    <main class="py-2">
        @yield('main')
    </main>

@endsection