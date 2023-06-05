@extends('backend.layouts.master')
@section('title','E-SHOP || Color Edit')
@section('main-content')

<div class="card m-3">
    <h5 class="card-header">Edit Color</h5>
    <div class="card-body">
      <form method="post" action="{{route('color.update',$color->id)}}"  enctype="multipart/form-data">
        @csrf 
        @method('PATCH')
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Title <span class="text-danger">*</span></label>
             <input id="inputTitle" type="text" name="title" placeholder="Enter title"  value="{{$color->title}}" class="form-control">
            @error('title')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="form-group">
          <label for="hex_code" class="col-form-label">Hex Code <span class="text-danger">*</span></label>
             <input id="hex_code" type="text" name="hex" placeholder="Enter Hex Code"  value="{{$color->hex}}" class="form-control">
            @error('hex')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="form-group">
          <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
          <select name="status" class="form-control">
            <option value="active" {{(($color->status=='active') ? 'selected' : '')}}>Active</option>
            <option value="inactive" {{(($color->status=='inactive') ? 'selected' : '')}}>Inactive</option>
          </select>
          @error('status')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group mb-3">
           <button class="btn btn-success" type="submit">Update</button>
        </div>
      </form>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
@endpush