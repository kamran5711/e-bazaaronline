@extends('backend.layouts.master')
@section('main-content')
<div class="card">
   <h5 class="card-header">Edit Customer</h5>
    <div class="card-body">
    <form method="post" action="{{route('users.update',$user->id)}}" enctype="multipart/form-data">
        @csrf 
        @method('PATCH')
       <div class="row">
       <div class="col-6">
        <div class="form-group">
          <label for="name" class="col-form-label">Name</label>
        <input type="text" name="name"   value="{{$user->name}}" style="border-radius: 1rem;" class="form-control" autofocus="1" autocomplete="off" required="required">
        @error('name')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div> </div>
        
        <div class="col-6">
        <div class="form-group">
            <label for="building" class="col-form-label"> Building Name / Number</label>
          <input type="text"   name="building" style="border-radius: 1rem;" value="{{$user->building}}" class="form-control" required="required">
          @error('building')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div></div></div>
        <div class="row">
        <div class="col-6">
        <div class="form-group">
            <label for="address1" class="col-form-label"> Address Line 1</label>
          <input type="text"   name="address1" style="border-radius: 1rem;" value="{{$user->address1}}" class="form-control"  required="required">
          @error('address1')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div></div>
        <div class="col-6">
        <div class="form-group">
            <label for="address2" class="col-form-label"> Address Line 2</label>
          <input type="text"  name="address2" style="border-radius: 1rem;" value="{{$user->address2}}" class="form-control">
          @error('address2')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div></div></div>
        <div class="row">
        <div class="col-6">
        <div class="form-group">
            <label for="area" class="col-form-label"> Area</label>
          <input  type="text" name="area"  value="{{$user->area}}" style="border-radius: 1rem;" class="form-control" required="required">
          @error('area')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div></div>
        <div class="col-6">
        <div class="form-group">
            <label for="city" class="col-form-label"> City</label>
          <input  type="text" name="city"  value="{{$user->city}}" style="border-radius: 1rem;" class="form-control" required="required">
          @error('city')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div></div></div>
        <div class="row">
        <div class="col-6">
        <div class="form-group">
            <label for="postcode" class="col-form-label"> Postcode</label>
            <input type="text" name="postcode" maxlength="7" size="7" style="border-radius: 1rem;"   value="{{$user->postcode}}" class="form-control" required="required">
        @error('postcode')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div></div>
        <div class="col-6">
        @php 
        $roles=DB::table('users')->select('role')->where('id',$user->id)->get();
        // dd($roles);
        @endphp
        <div class="form-group">
            <label for="role" class="col-form-label">Role</label>
            <select name="role" class="form-control" required="required" style="border-radius: 1rem;">
            @foreach($roles as $role)
                    <option value="admin" {{(($role->role=='admin') ? 'selected' : '')}}>Admin</option>
                    <option value="operator" {{(($role->role=='operator') ? 'selected' : '')}}>Operator</option>
                    <option value="user" {{(($role->role=='user') ? 'selected' : '')}}>Customer</option>
                @endforeach
            </select>
          @error('role')
          <span class="text-danger">{{$message}}</span>
          @enderror
          </div></div></div>
          <div class="row">
          <div class="col-6">
          <div class="form-group">
            <label for="status" class="col-form-label">Status</label>
            <select name="status" class="form-control"  style="border-radius: 1rem;">
                <option value="active" {{(($user->status=='active') ? 'selected' : '')}}>Active</option>
                <option value="inactive" {{(($user->status=='inactive') ? 'selected' : '')}}>Inactive</option>
            </select>
          @error('status')
          <span class="text-danger">{{$message}}</span>
          @enderror
          </div></div>
          <div class="col-6">
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
        <div class="form-group mb-3">
          <button type="reset" class="btn btn-warning">Reset</button> 
           <button class="btn btn-success" type="submit">Update</button>
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