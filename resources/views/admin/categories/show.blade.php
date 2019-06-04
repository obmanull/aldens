@extends('layouts.admin')
@section('content')

    <h4 class="card-title">{{ $category->name }}</h4>
    <div class="single-table mb-2">

        <div class="row">
            <div class="col-4 mb-2">
                <a href="{{ route('admin.categories.edit', [$category]) }}" class="btn btn-success">Edit</a>
                <label for="btn-delete" class="btn btn-danger">Delete</label>

                <form action="{{ route('admin.categories.destroy', [$category])  }}" method="post">
                    @csrf
                    @method('DELETE')
                    <input type="submit" id="btn-delete" class="d-none">
                </form>

            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>

                        <tr>
                            <th>id</th>
                            <td>{{ $category->id }}</td>
                        </tr>
                        <tr>
                            <th>name</th>
                            <td>{{ $category->name }}</td>
                        </tr>
                        <tr>
                            <th>slug</th>
                            <td>{{ $category->slug }}</td>
                        </tr>
                        <tr>
                            <th>parent</th>
                            <td>@empty(! $category->parent)
                                    {{ $category->parent->name }}
                                @else
                                    None parent
                                @endempty
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('admin.categories.attributes.create', $category) }}" class="btn btn-primary mb-3">Add
        attribute</a>

    <div class="row">
        <div class="col-6">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>id</th>
                        <th>Sort</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Required</th>
                        <th>Delete</th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr>
                        <th colspan="6">Parent attributes</th>
                    </tr>

                    @forelse ($parentAttributes as $attribute)
                        <tr>
                            <td>{{ $attribute->id }}</td>
                            <td>{{ $attribute->sort }}</td>
                            <td>
                                <a href="{{ route('admin.categories.attributes.edit', [$category, $attribute]) }}">
                                    {{ $attribute->name }}
                                </a>
                            </td>
                            <td>{{ $attribute->type }}</td>
                            <td>{{ $attribute->required ? 'Yes' : 'No' }}</td>
                            <td>
                                <a href="{{ route('admin.categories.attributes.destroy', [$category, $attribute]) }}">
                                    <i class="ti-close"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">None</td>
                        </tr>
                    @endforelse

                    <tr>
                        <th colspan="6">Own attributes</th>
                    </tr>

                    @forelse ($attributes as $attribute)
                        <tr>
                            <td>{{ $attribute->id }}</td>
                            <td>{{ $attribute->sort }}</td>
                            <td>
                                <a href="{{ route('admin.categories.attributes.edit', [$category, $attribute]) }}">
                                    {{ $attribute->name }}
                                </a>
                            </td>
                            <td>{{ $attribute->type }}</td>
                            <td>{{ $attribute->required ? 'Yes' : 'No' }}</td>
                            <td>
                                <label for="btn-delete-attribute"><i class="ti-close"></i></label>
                                <form action="{{ route('admin.categories.attributes.destroy', [$category, $attribute]) }}"
                                      method="post">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" id="btn-delete-attribute" class="d-none">
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">None</td>
                        </tr>
                    @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>



@endsection