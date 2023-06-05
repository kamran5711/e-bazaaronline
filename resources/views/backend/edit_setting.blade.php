@extends('backend.layouts.master')
@section('main-content')
    
<style type="text/css">
        .bootstrap-tagsinput{
            width: 100%;
        }
        .label-info{
            background-color: #17a2b8;

        }
        .label {
            display: inline-block;
            padding: .25em .4em;
            font-size: 75%;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: .25rem;
            transition: color .15s ease-in-out,background-color .15s ease-in-out,
            border-color .15s ease-in-out,box-shadow .15s ease-in-out;
        }
    </style>
<div class="card">
    <h5 class="card-header">Update Shop Setting</h5>
    <div class="card-body">
        <form method="post" action="{{route('settings.update',$setting->id)}}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            
            <div class="form-group">
                <label for="short_des" class="col-form-label">Title <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="short_des" required value="{!!$setting->short_des!!}">
                @error('short_des')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="description" class="col-form-label">Description <span class="text-danger">*</span></label>
                <textarea class="form-control" id="description" name="description">{!!$setting->description!!}</textarea>
                @error('description')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="address" class="col-form-label">Address <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="address" required value="{{$setting->address}}">
                @error('address')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="email" class="col-form-label">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control" name="email" required value="{{$setting->email}}">
                @error('email')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="phone" class="col-form-label">Phone Number <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="phone" required value="{{$setting->phone}}">
                @error('phone')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="row">
                <div class="form-group mb-6">
                    <div class="col-md-4">
                        <img width="200" height="200" id="display_product_image"
                        src="{{ asset('products/images/logo/'.$setting->logo) }}" /><br><br>
                    </div>
                    <label for="inputPhoto" class="col-form-label">Logo <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <!-- <span class="input-group-btn">
                  <a id="lfm1" data-input="thumbnail1" data-preview="holder1" class="btn btn-primary">
                  <i class="fa fa-picture-o"></i> Choose </a>  </span> -->
                        <!-- <input id="thumbnail1" class="form-control" type="text" name="logo" value=""> -->
                        <input type='file' onchange="eadURL(this);" name="logo" value="{{old('logo')}}" style=" width: 237px;">
                        <img id="blah" style="height:100px; wight: 100px;" />
                        <div id="holder" style="height:10px; wight: 10px;"></div>
                        @error('logo')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div id="holder1" style="height:10px; wight: 10px;"></div>
                    @error('logo')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
               
                <div class="form-group mb-6 offset-2">
                    <div class="col-md-4">
                        <img width="200" height="200"
                        src="{{ asset('products/images/photo/'.$setting->photo) }}" /><br><br>
                    </div>
                    <label for="inputPhoto" class="col-form-label">Photo <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <!-- <span class="input-group-btn">
                  <a id="lfm1" data-input="thumbnail1" data-preview="holder1" class="btn btn-primary">
                  <i class="fa fa-picture-o"></i> Choose
                  </a>
              </span> -->
                        <!-- <input id="thumbnail1" class="form-control" type="text" name="logo" value=""> -->
                        <input type='file' onchange="readURL(this);" name="photo" value="{{old('photo')}}" style=" width: 237px;">
                        <img id="blahh" style="height:100px; wight: 100px;" />
                        <div id="holder" style="height:10px; wight: 10px;"></div>
                        @error('photo')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div id="holder1" style=" height:10px; wight: 10px;"></div>
                    @error('photo')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" integrity="sha512-xmGTNt20S0t62wHLmQec2DauG9T+owP9e6VU8GigI0anN7OXLip9i7IwEhelasml2osdxX71XcYm6BQunTQeQg==" crossorigin="anonymous" />


@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js" integrity="sha512-VvWznBcyBJK71YKEKDMpZ0pCVxjNuKwApp4zLF3ul+CiflQi6aIJR+aZCP/qWsoFBA28avL5T5HA+RE+zrGQYg==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput-angular.min.js" integrity="sha512-KT0oYlhnDf0XQfjuCS/QIw4sjTHdkefv8rOJY5HHdNEZ6AmOh1DW/ZdSqpipe+2AEXym5D0khNu95Mtmw9VNKg==" crossorigin="anonymous"></script>
  

<script>
$('#lfm').filemanager('image');
$('#lfm1').filemanager('image');
$(document).ready(function() {
    $('#summary').summernote({
        placeholder: "Write short description.....",
        tabsize: 2,
        height: 150
    });
});

$(document).ready(function() {
    $('#quote').summernote({
        placeholder: "Write short Quote.....",
        tabsize: 2,
        height: 100
    });
});
$(document).ready(function() {
    $('#description').summernote({
        placeholder: "Write detail description.....",
        tabsize: 2,
        height: 150
    });
});


function eadURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blahh')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
</script>
@endpush