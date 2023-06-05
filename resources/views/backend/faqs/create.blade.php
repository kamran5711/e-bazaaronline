@extends('backend.layouts.master')

@section('title','E-SHOP || FAQS Create')

@section('main-content')
<style>
  img{
  max-width:180px;
  background: white;
}
input[type=file]{
padding:10px;
/* background:#2d2d2d; */
background: white;
}
</style>
<div class="card m-3">
    <h5 class="card-header">Add FAQS</h5>
    <div class="card-body">
      <form method="post" action="{{route('faq.store')}}" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Question <span class="text-danger">*</span></label>
        <input id="inputTitle" type="text" name="question" placeholder="Enter question"  value="{{old('question')}}" class="form-control">
        @error('question')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
          <label for="inputDesc" class="col-form-label">Answer</label>
          <input id="inputDesc" type="text" name="answer" placeholder="Enter Answer"  value="{{old('answer')}}" class="form-control">
         
          @error('answer')
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