@extends('layouts.app')

@section('content')
    @include ('cabinet.partials._nav', ['page' => 'profile'])

    <h4 class="header-title">Profile</h4>

    @yield('main')

@endsection