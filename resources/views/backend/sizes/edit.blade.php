@extends('backend.layouts.master')

@section('main-content')

<div class="card m-3">
    <h5 class="card-header">Edit Size</h5>
    <div class="card-body">
      <form method="post" action="{{route('size.update',$size->id)}}">
        @csrf
            @method('PATCH')
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Size</label>
          <input id="inputTitle" type="text" name="title" placeholder="Enter Size"  value="{{$size->title}}" class="form-control">
          @error('title')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
          <select name="status" class="form-control">
            <option value="active" {{(($size->status=='active') ? 'selected' : '')}}>Active</option>
            <option value="inactive" {{(($size->status=='inactive') ? 'selected' : '')}}>Inactive</option>
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
