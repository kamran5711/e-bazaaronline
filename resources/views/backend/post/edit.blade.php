@extends('backend.layouts.master')

@section('main-content')

<div class="card shadow m-3">
    <h5 class="card-header">Edit Post</h5>
    <div class="card-body">
      <form method="post" action="{{route('post.update',$post->id)}}" enctype="multipart/form-data">
        @csrf 
        @method('PATCH')
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Title <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="title" placeholder="Enter title"  value="{{$post->title}}" class="form-control">
          @error('title')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="category_id">Category <span class="text-danger">*</span></label>
          <select name="category_id" class="form-control select2">
              <option value="">Select</option>
              @foreach($categories as $key=>$data)
                  <option value='{{$data->id}}' {{( ($data->id == $post->category_id) ? 'selected' : '')}}>{{$data->title}}</option>
              @endforeach
          </select>
        </div>

        <div class="form-group">
          <label for="tags">Tag</label>
          <select name="tags[]" multiple class="form-control select2" id="tags">
              <option value="">Select</option>
              @foreach($tags as $tag)
                <option value="{{ $tag->id }}">{{ $tag->title }}</option>
              @endforeach
          </select>
        </div>

        @push('scripts')
          <script>
              $('#tags').val(@json($post->post_tags->pluck('post_tag_id')));
          </script>
        @endpush

        <div class="form-group">
          <label for="description" class="col-form-label">Description</label>
          <textarea class="form-control" id="description" name="description">{{$post->description}}</textarea>
          @error('description')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
          <select name="status" class="form-control">
            <option value="active" {{(($post->status=='active')? 'selected' : '')}}>Active</option>
            <option value="inactive" {{(($post->status=='inactive')? 'selected' : '')}}>Inactive</option>
        </select>
          @error('status')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <input type='file' onchange="readURL(this);" name="photo" value="{{old('photo')}}" style=" width: 237px;">
        <img id="blah" style="height:100px; wight: 100px;" />
        <div class="form-group mb-3">
           <button class="btn btn-success" type="submit">Update</button>
        </div>
      </form>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
      $('.select2').select2();
      $('#description').summernote({
        placeholder: "Write detail description.....",
          tabsize: 2,
          height: 250
      });
    });
    function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

</script>
@endpush