@extends('admin.users.layout')

@section('main')

    <h4 class="mb-3"><strong>Create user</strong></h4>

    <form action="{{ route('admin.users.store') }}" method="post">
        @csrf

        <div class="form-group">

            <label for="name-input" class="col-form-label">Name</label>
            <input class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" type="text" name="name"
                   value="{{ old('name') }}" id="name-input">
            @if($errors->has('name'))
                <div class="invalid-feedback">{{ $errors->first('name') }}</div>
            @endif

        </div>

        <div class="form-group">
            <label for="email-input" class="col-form-label">Email</label>
            <input class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" type="text" name="email"
                   value="{{  old('email') }}" id="email-input">
            @if($errors->has('email'))
                <div class="invalid-feedback">{{ $errors->first('email') }}</div>
            @endif
        </div>

        <div class="form-group">
            <label for="email-input" class="col-form-label">Role</label>
            <select name="role" class="custom-select {{ $errors->has('role') ? ' is-invalid' : '' }}">
                @foreach($roles as $id => $role)
                    <option value="{{ $id }}" {{ $id == old('role') ? 'selected': false }}>{{ $role }}</option>
                @endforeach
            </select>
            @if($errors->has('role'))
                <div class="invalid-feedback">{{ $errors->first('role') }}</div>
            @endif
        </div>

        <div class="form-group">
            <label for="password-input" class="col-form-label">Password</label>
            <input class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" type="text" name="password"
                   value="{{ old('password') }}"
                   id="password-input">
            @if($errors->has('password'))
                <div class="invalid-feedback">{{ $errors->first('password') }}</div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Save</button>

    </form>


@endsection

