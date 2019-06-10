@extends('cabinet.profile.layout')

@section('main')

    <form action="{{ route('cabinet.phone.verify') }}" method="post">
        @csrf

        <div class="form-group">
            <label for="token">Sms token</label>
            <input type="text"
                   class="form-control {{ $errors->has('token') ? ' is-invalid' : '' }}" name="token" id="token" value="{{ old('token') }}">
            @error('token')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

        </div>
        <button type="submit" class="btn btn-primary">Send</button>

    </form>

@endsection