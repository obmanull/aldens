@extends('cabinet.profile.layout')

@section('main')

    <a class="btn btn-primary mb-3" href="{{ route('cabinet.profile.edit') }}" role="button">Edit</a>

    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>First name</th>
                <td scope="row">{{ $user->name }}</td>
            </tr>
            <tr>
                <th>Last name</th>
                <td>{{ $user->last_name }}</td>
            <tr>
                <th>Phone</th>
                <td>{{ $user->phone }}
                    @if(! $user->isPhoneVerified())
                        <form action="{{ route('cabinet.phone.verify.request') }}" method="post">
                            @csrf
                            <i>(is not verified)</i>
                            <button type="submit" class="btn btn-sm btn-success">Verify</button>
                        </form>
                    @endif
                </td>
            </tr>
        </tbody>
    </table>

@endsection