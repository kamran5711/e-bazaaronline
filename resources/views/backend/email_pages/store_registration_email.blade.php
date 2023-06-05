@extends('backend.layouts.master')
@section('main-content')

<style>
  .btn-default{border:1px solid;}
</style>
  <div class="card shadow m-3">
    <div class="card-header bg-primary text-white rounded-0">
      <h6 class="m-0 font-weight-bold float-left">{{ $title }}</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
              @include('backend.layouts.notification')
            </div>
        </div>
        <form method="post" action="{{route('update-email-template')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <input type="hidden" name="record_id" value="{{ optional($record)->id }}">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Email Subject</label>
                        <input type="text" class="form-control" placeholder="email subject" name="subject" value="{{optional($record)->subject}}">
                        @error('subject')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6 pt-3 mt-3">
                  <div class="form-group">
                    <label class="btn btn-default w-100 text-left">
                      <input type="checkbox" name="mention_receiver_name" {{ (optional($record)->mention_receiver_name) === 'true' ? 'checked' : '' }} class="btn btn-default" value="true"> You want to send store name in email ?
                    </label>
                  </div>
                </div>
            </div>
            {{-- <br /> --}}
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <textarea name="contents" id="about_us" cols="30" rows="10">
                            {!!optional($record)->contents!!}
                        </textarea>
                        @error('contents')
                        <span class="text-danger">{{$message}}</span><br>
                        @enderror
                        <button class="btn btn-primary mt-3" type="submit">Update</button>
                    </div>
                </div> 
            </div>
        </form>
    </div>
  </div>

@endsection


@push('styles')
  <link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
@endpush

@push('scripts')
  <script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
  <script>
  
    // $('#lfm').filemanager('image');
    $(document).ready(function() {
      $('#about_us').summernote({
        placeholder: "Write short description.....",
          tabsize: 2,
          height: 300
      });
    });
</script>
@endpush

