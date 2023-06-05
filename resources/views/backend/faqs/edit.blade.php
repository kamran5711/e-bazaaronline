@extends('backend.layouts.master')
@section('title','E-SHOP || FAQS Edit')
@section('main-content')

<div class="card">
    <h5 class="card-header">Edit faqs</h5>
    <div class="card-body">
      <form method="post" action="{{route('faq.update',$faq->id)}}"  enctype="multipart/form-data">
        @csrf 
        @method('PATCH')
        <div class="form-group">
          <label for="question" class="col-form-label">Question <span class="text-danger">*</span></label>
        <input id="question" type="text" name="question" placeholder="Enter question"  value="{{$faq->question}}" class="form-control">
        @error('question')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
          <label for="answer" class="col-form-label">answer</label>
       <input id="answer" type="text" name="answer" placeholder="Enter answer"  value="{{$faq->answer}}" class="form-control">
          @error('answer')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
       
        <div class="form-group">
          <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
          <select name="status" class="form-control">
            <option value="active" {{(($faq->status=='active') ? 'selected' : '')}}>Active</option>
            <option value="inactive" {{(($faq->status=='inactive') ? 'selected' : '')}}>Inactive</option>
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
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script>
    $('#lfm').filemanager('image');

    $(document).ready(function() {
    $('#description').summernote({
      placeholder: "Write short description.....",
        tabsize: 2,
        height: 150
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