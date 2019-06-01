@extends('layouts.admin')

@section('content')

    <h4 class="mb-3"><strong>Editing user</strong></h4>

    <form action="{{ route('admin.users.update', $user) }}" method="post">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name-input" class="col-form-label">Name</label>
            <input class="form-control" type="text" name="name" value="{{ old('name', $user->name) }}"
                   id="name-input">
            @if($errors->has('name'))
                <div class="invalid-feedback">{{ $errors->first('name') }}</div>
            @endif
        </div>

        <div class="form-group">
            <label for="email-input" class="col-form-label">Email</label>
            <input class="form-control" type="text" name="email"
                   value="{{  old('email', $user->email) }}" id="email-input">
            @if($errors->has('email'))
                <div class="invalid-feedback">{{ $errors->first('email') }}</div>
            @endif
        </div>
        <div class="form-group">
            <label for="email-input" class="col-form-label">Role</label>
            <select name="role" class="custom-select">
                @foreach($roles as $id => $role)
                    <option value="{{ $id }}" {{ $id === old('role', $user->role) ? 'selected': false }}>{{ $role }}</option>
                @endforeach
            </select>
            @if($errors->has('role'))
                <div class="invalid-feedback">{{ $errors->first('role') }}</div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Save</button>

    </form>


@endsection

