@extends('layouts.admin')
@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Thead light</h4>
                    <div class="single-table">
                        <div class="table-responsive">
                            <table class="table text-center">
                                <thead class="text-uppercase bg-light">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">date</th>
                                    <th scope="col">verified</th>
                                    <th scope="col">action</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($users as $user)
                                    <tr>
                                        <th scope="row">{{ $user->id }}</th>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->created_at->diffForHumans() }}</td>
                                        <td>
                                            @if(! empty($user->email_verified_at))
                                                <i class="ti-check"></i>
                                            @else
                                                <i class="ti-close"></i>
                                            @endif
                                        </td>
                                        <td>
                                            <ul class="d-flex justify-content-center">
                                                <li class="mr-3">
                                                    <a href="{{ route('admin.users.edit', $user) }}"
                                                       class="text-secondary">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <form action="{{ route('admin.users.destroy', $user) }}"
                                                          method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <label class="text-danger ti-trash">
                                                            <input type="submit" class="d-none">
                                                        </label>
                                                    </form>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

