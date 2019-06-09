@extends('layouts.app')

@section('content')
    @include ('cabinet.partials._nav', ['page' => 'profile'])

    <h4 class="header-title">Profile</h4>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form action="{{ route('cabinet.profile.update', $user) }}" method="post">
        @csrf
        <div class="form-group">
            <label for="lastName">Last name</label>
            <input type="text" name="last_name"
                   class="form-control {{ $errors->has('last_name') ? ' is-invalid' : '' }}"
                   id="lastName" value="{{ old('last_name', $user->last_name) }}">
            @error('last_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="name">First name</label>
            <input type="text" name="name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                   id="name"
                   value="{{ old('name', $user->name) }}">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="tel" name="phone" class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}"
                   id="phone"
                   value="{{ old('phone', $user->phone) }}">
            @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>

@endsection