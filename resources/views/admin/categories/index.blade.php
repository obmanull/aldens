@extends('admin.categories.layout')

@section('main')

    <div class="table-responsive">
        <table class="table">
            <thead class="text-uppercase bg-light">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">action</th>
            </tr>
            </thead>
            <tbody>

            @foreach($categories as $category)
                <tr>
                    <th scope="row">{{ $category->id }}</th>
                    <td>
                        <a href="{{ route('admin.categories.show', $category) }}">
                            @for($i = 0; $i < $category->depth; $i++)
                                -
                            @endfor
                            {{ $category->name }}
                        </a>
                    <td>

                        <ul class="d-flex justify-content-left list-unstyled">
                            <li class="mr-3 ">
                                <form action="{{ route('admin.categories.up', $category) }}"
                                      method="post">
                                    @csrf
                                    <label class="fas fa-chevron-up cursor-pointer text-primary">
                                        <input type="submit" class="d-none">
                                    </label>
                                </form>
                            </li>
                            <li class="mr-3">
                                <form action="{{ route('admin.categories.down', $category) }}"
                                      method="post">
                                    @csrf
                                    <label class="fas fa-chevron-down cursor-pointer text-primary">
                                        <input type="submit" class="d-none">
                                    </label>
                                </form>
                            </li>
                            <li class="mr-3">
                                <a href="{{ route('admin.categories.edit', $category) }}"
                                   class="text-secondary fa fa-edit text-success">
                                </a>
                            </li>
                            <li>
                                <form action="{{ route('admin.categories.destroy', $category) }}"
                                      method="post">
                                    @csrf
                                    @method('DELETE')
                                    <label class="text-danger cursor-pointer fas fa-trash">
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




@endsection