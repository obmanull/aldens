@extends('layouts.admin')
@section('content')


    <h4 class="header-title">Category</h4>
    <div class="single-table p-2 mb-2">

        <h4 class="mb-3"><strong>Editing category</strong></h4>

        <form action="{{ route('admin.categories.update', $category) }}" method="post">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name-input" class="col-form-label">Name</label>
                <input class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" type="text" name="name"
                       value="{{ old('name', $category->name) }}" id="name-input">
                @if($errors->has('name'))
                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                @endif
            </div>

            <div class="form-group">
                <label for="slug-input" class="col-form-label">Slug</label>
                <input class="form-control {{ $errors->has('slug') ? ' is-invalid' : '' }}" type="text" name="slug"
                       value="{{ old('slug', $category->slug) }}" id="slug-input">
                @if($errors->has('slug'))
                    <div class="invalid-feedback">{{ $errors->first('slug') }}</div>
                @endif
            </div>

            <div class="form-group">

                <label for="email-input" class="col-form-label">Parent</label>

                <select name="parent_id" class="custom-select  {{ $errors->has('parent_id') ? ' is-invalid' : '' }}">
                    <option value="">
                    @foreach($categories as $row)
                        <option value="{{ $row->id  }}"
                                {{ $row->id == old('parent_id', $category->parent_id) ? 'selected': '' }}>
                            -@for($i = 0; $i < $row->depth; $i++) - @endfor {{ $row->name }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('parent_id'))
                    <div class="invalid-feedback">{{ $errors->first('parent_id') }}</div>
                @endif
            </div>

            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Save</button>

        </form>

    </div>

@endsection