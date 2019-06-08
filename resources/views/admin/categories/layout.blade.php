@extends('layouts.app')

@section('content')
    @include ('admin.partials._nav', ['page' => 'categories'])

    <h4 class="header-title">Category</h4>

    <main class="py-2">
        @yield('main')
    </main>

@endsection