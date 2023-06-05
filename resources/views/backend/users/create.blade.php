@extends('backend.layouts.master')
@section('main-content')
<div class="card">
    <h5 class="card-header">Add Customer</h5>
    <div class="card-body">
      <form method="post" action="{{route('users.store')}}"  enctype="multipart/form-data">
       @csrf
       <div class="row">
       <div class="col-6">
        <div class="form-group">
          <label for="name" class="col-form-label">Name</label>
        <input type="text" name="name"   value="{{old('name')}}" style="border-radius: 1rem;" class="form-control" autofocus="1" autocomplete="off" required="required">
        @error('name')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div> </div>
        <div class="col-6">  
        <div class="form-group">
            <label for="email" class="col-form-label">Email</label>
            <input type="email" name="email" autocomplete="off" required="required"  style="border-radius: 1rem;" value="{{old('email')}}" class="form-control" >
          @error('email')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div></div></div>
        <div class="row">
        <div class="col-6">
        <div class="form-group">
            <label for="email_confirmation" class="col-form-label">Re-Enter Email</label>
            <input type="email" name="email_confirmation" autocomplete="off" required="required"
             value="{{old('email_confirmation')}}" style="border-radius: 1rem;" class="form-control" >
          @error('email_confirmation')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div></div>
        <div class="col-6">
        <div class="form-group">
            <label for="building" class="col-form-label"> Building Name / Number</label>
          <input type="text" name="building" style="border-radius: 1rem;" value="{{old('building')}}" class="form-control" required="required">
          @error('building')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div></div></div>
        <div class="row">
        <div class="col-6">
        <div class="form-group">
            <label for="address1" class="col-form-label"> Address Line 1</label>
          <input type="text" name="address1" style="border-radius: 1rem;" value="{{old('address1')}}" class="form-control"  required="required">
          @error('address1')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div></div>
        <div class="col-6">
        <div class="form-group">
            <label for="address2" class="col-form-label"> Address Line 2</label>
          <input type="text" name="address2" style="border-radius: 1rem;"   value="{{old('address2')}}" class="form-control">
          @error('address2')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div></div></div>
        <div class="row">
        <div class="col-6">
        <div class="form-group">
            <label for="area" class="col-form-label"> Area</label>
          <input  type="text" name="area" value="{{old('area')}}" style="border-radius: 1rem;" class="form-control" required="required">
          @error('area')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div></div>
        <div class="col-6">
        <div class="form-group">
            <label for="city" class="col-form-label"> City</label>
          <input  type="text" name="city" value="{{old('city')}}" style="border-radius: 1rem;" class="form-control" required="required">
          @error('city')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div></div></div>
        <div class="row">
        <div class="col-6">
        <div class="form-group">
            <label for="postcode" class="col-form-label"> Postcode</label>
            <input type="text" name="postcode" maxlength="7" size="7" style="border-radius: 1rem;"   value="{{old('postcode')}}" class="form-control" required="required">
        @error('postcode')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div></div>
        <div class="col-6">
        <div class="form-group">
            <label for="inputPassword" class="col-form-label">Password</label>
          <input type="password" name="password" style="border-radius: 1rem;" value="{{old('password')}}" class="form-control" maxlength="15" size="15"  title="Password must contain at least 8 characters, including UPPER/lowercase and numbers." required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"> 
          @error('password')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div></div></div>
        <div class="row">
        <div class="col-6">
        <div class="form-group">
            <label for="inputPassword" class="col-form-label">Confirm Password</label>
          <input type="password" name="password_confirmation" style="border-radius: 1rem;"  value="{{old('password_confirmation')}}" class="form-control" maxlength="15" size="15" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"  title="Please enter the same Password as above.">
          @error('password_confirmation')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div></div>
        <div class="col-6">
        @php 
        $roles=DB::table('users')->select('role')->get();
        @endphp
        <div class="form-group">
            <label for="role" class="col-form-label">Role</label>
            <select name="role" class="form-control" required="required" style="border-radius: 1rem;">
                <option value="">---Select Role---</option>
                <option value="admin">Admin</option>
                <option value="operator">Operator</option>
                <option value="user">customer</option>
            </select>
          @error('role')
          <span class="text-danger">{{$message}}</span>
          @enderror
          </div></div></div>
          <div class="row">
          <div class="col-6">
          <div class="form-group">
            <label for="status" class="col-form-label">Status</label>
            <select name="status" class="form-control" required="required" style="border-radius: 1rem;">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
          @error('status')
          <span class="text-danger">{{$message}}</span>
          @enderror
          </div></div>
          <div class="col-6">
        <!-- <div class="form-group">
        <label for="inputPhoto" class="col-form-label">Photo</label>
        <div class="input-group">
            <span class="input-group-btn">
                <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                <i class="fa fa-picture-o"></i> Choose
                </a>
            </span>
            <input id="thumbnail" class="form-control" type="text" name="photo" value="{{old('photo')}}">
        </div>
        <img id="holder" style="margin-top:15px;max-height:100px;">
          @error('photo')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div> -->
        <div class="form-group">
                      <label for="inputPhoto" class="col-form-label">Photo</label>
                      <div class="input-group">
                        <input type='file' onchange="readURL(this);" name="photo" value="{{old('photo')}}" style=" width: 237px;">
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
                </div></div><div>
                <div class="form-group text-left">
          <div class="g-recaptcha brochure__form__captcha" data-sitekey="6LcU1uQdAAAAAH2KrTLpwhxJxWjnvHlZ--aL1D3k">
            </div>
           </div>
        <div class="form-group mb-3">
          <button type="reset" class="btn btn-warning">Reset</button>
           <button class="btn btn-success" type="submit">Submit</button>
        </div>
      </form>
    </div>
</div>
@endsection
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script>
    $('#lfm').filemanager('image');
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