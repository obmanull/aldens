@extends('layouts.admin')
@section('content')

    <div class="single-table p-2 mb-2">

        <h4 class="mb-3"><strong>Edit attribute</strong></h4>

        <form action="{{ route('admin.categories.attributes.update', [$category, $attribute]) }}" method="post">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name-input" class="col-form-label">Name</label>
                <input class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" type="text" name="name"
                       value="{{ old('name', $attribute->name) }}"
                       id="name-input">
                @if($errors->has('name'))
                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                @endif
            </div>

            <div class="form-group">
                <label for="type-select" class="col-form-label">Type</label>

                <select name="type" id="type-select"
                        class="form-control {{ $errors->has('type') ? ' is-invalid' : '' }}">
                    @foreach($typesList as $key => $type)
                        <option value="{{ $key }}" {{ $key == $attribute->type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>

                @if($errors->has('type'))
                    <div class="invalid-feedback">{{ $errors->first('type') }}</div>
                @endif
            </div>

            <div class="form-group">
                <label for="sort-input" class="col-form-label">Sort</label>
                <input type="number" class="form-control {{ $errors->has('sort') ? ' is-invalid' : '' }}" name="sort"
                       value="{{ old('sort', $attribute->sort) }}"
                       id="sort-input">
                @if($errors->has('sort'))
                    <div class="invalid-feedback">{{ $errors->first('sort') }}</div>
                @endif
            </div>


            <div class="form-group">
                <input type="hidden" name="required" value="0">
                <div class="checkbox">
                    <label>
                        <input type="checkbox"
                               name="required" {{ old('required', $attribute->required) ? 'checked' : '' }}> required
                    </label>
                </div>
                @if ($errors->has('required'))
                    <span class="text-danger"><strong>{{ $errors->first('required') }}</strong></span>
                @endif
            </div>

            <div class="form-group">
                <label for="variants-input" class="col-form-label">Variants</label>
                <textarea name="variants" id="variants-input" cols="30" rows="3"
                          class="form-control{{ $errors->has('variants') ? ' is-invalid' : '' }}">{{ old('variants', implode("\n", $attribute->variants)) }}</textarea>
                @if ($errors->has('variants'))
                    <span class="invalid-feedback"><strong>{{ $errors->first('variants') }}</strong></span>
                @endif
            </div>

            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Save</button>

        </form>

    </div>

@endsection