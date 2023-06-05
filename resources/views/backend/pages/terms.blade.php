@extends('backend.layouts.master')
@section('main-content')
<div class="row">
    <div class="col-md-12">
       @include('backend.layouts.notification')
    </div>
</div>
<div class="card">
    <h5 class="card-header">Terms and Conditions</h5>
    <div class="card-body">
      <form method="post" action="{{route('admin.terms')}}" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="row ml-1">
          <div class="col-col-6">
              <div class="form-group">
                  <label for="">Title</label>
                  <input type="text" class="form-control" placeholder="Title" name="title" value="{{old('title')}}{{isset($record->title) ? $record->title : ""}}">
                  @error('title')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
              </div>
          </div>
      </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <textarea name="content" id="about_us" cols="30" rows="10">
                        {!!isset($record->content) ? $record->content :  ""!!} {{old('content')}}
                    </textarea>
                    @error('content')
                    <span class="text-danger">{{$message}}</span><br>
                    @enderror
                    <button class="btn btn-success mt-3" type="submit">Save</button>
                </div>
            </div> 
        </div>
      </form>
    </div>
</div>
@endsection
@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
@endpush
@push('scripts')
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>

<script>

    // $('#lfm').filemanager('image');
    $(document).ready(function() {
      $('#about_us').summernote({
        placeholder: "Write short description.....",
          tabsize: 2,
          height: 100
      });
    });
    </script>
@endpush


