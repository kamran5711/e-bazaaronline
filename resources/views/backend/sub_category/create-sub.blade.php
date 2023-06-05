@extends('backend.layouts.master')

@section('main-content')

    <div class="card shadow m-3">
        <h5 class="card-header">Add sub category to "{{ $category->title}}"</h5>
        <div class="card-body">
            <form method="post" action="{{route('sub.category.store')}}"  enctype="multipart/form-data">
                {{csrf_field()}}
                <input type="hidden" name="category_id"  value='{{ $category->id }}'>
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Title <span class="text-danger">*</span></label>
                    <input id="inputTitle" type="text" name="title" placeholder="Enter title"  value="{{old('title')}}" class="form-control">
                    @error('title')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-control">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                    @error('status')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <button class="btn btn-success" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>

@endsection