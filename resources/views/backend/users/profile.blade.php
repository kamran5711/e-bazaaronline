@extends('backend.layouts.master')
@section('main-content')
<style>
img{ background: white; }
input[type=file]{padding:4px;background: white;}
.hidden{display:none;}
.btn-default{border:1px solid;}

.sd-box {
  background-color: #ffffff;
  position: relative;
  /* padding: 25px 20px; */
  width: 100%;
  text-align: center;
  border: 1px solid #EBE9E9;
  border-radius: 2px;
  /* line-height: 18px; */
}
</style>
<div class="row">
    <div class="col-md-12">
       @include('backend.layouts.notification')
    </div>
</div>
<div class="card m-3">
    <h5 class="card-header">Profile</h5>
    <div class="card-body">
      <form method="POST" action="{{route('profile-update', $profile->id)}}" enctype="multipart/form-data">
        <input type="hidden" name="store_id" value="{{ $profile->store->id }}" />
        <input type="hidden" name="store_address_id" value="{{ $profile->store->address->id }}">
        <input type="hidden" name="user_id" value="{{ $profile->id }}" />
        <input type="hidden" name="user_address_id" value="{{ $profile->address->id }}">
        {{csrf_field()}}
        <h5 class="text-info text-center mb-3"><strong>User Information</strong></h5>
        {{-- <hr /> --}}
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="userName">Name <span class="text-danger">*</span></label>
              <input id="userName" type="text" name="name" placeholder="Enter Name"  value="{{old('name') ? old('name') : $profile->name }}" class="form-control" required="required">
              @error('name')
              <span class="text-danger">{{$message}}</span>
              @enderror
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="userEmail">Email <span class="text-danger">*</span></label>
              <input id="userEmail" type="text" name="email" placeholder="Enter Email"  value="{{old('email') ? old('email') : $profile->email }}" class="form-control" required="required">
              @error('email')
              <span class="text-danger">{{$message}}</span>
              @enderror
            </div>
          </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                  <label for="userPhone">Phone Number<span class="text-danger">*</span></label>
                  <input id="userPhone" type="text" name="phone" placeholder="Enter Phone Number"  value="{{old('phone') ? old('phone') : $profile->phone }}" class="form-control" required="required">
                  @error('phone')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
            </div>
            {{-- {{ dd($profile->address->country_id) }} --}}
            <div class="col-md-6">
                <div class="form-group">
                  <label for="Country">Country <span class="text-danger">*</span></label>
                  <select name="country_id" id="Country" class="form-control" required="required" onchange="getStatesByCountryId(this)">
                      <option value="">Select</option>
                    @foreach($countries as $country)
                      <option value="{{$country->id}}" {{ ( $country->id == $profile->address->country_id ) ? 'selected' : '' }}>{{ $country->name }}</option>
                    @endforeach
                  </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="state_id">State <span class="text-danger">*</span></label>
                    <select class="form-control" name="state_id" id="state_id" required onchange="getCitiesByStateId(this)">
                        <option value="{{$profile->address->state->id}}">{{$profile->address->state->name}}</option>
                    </select>
                    @if($errors->has('state_id'))
                    <span class="invalid-feedback" id="state_span_id">
                        {{ $errors->first('state_id') }}
                    </span>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="city_id">City <span class="text-danger">*</span></label>
                    <select class="form-control" name="city_id" id="city_id" required>
                        <option value="{{$profile->address->city->id}}">{{$profile->address->city->name}}</option>
                    </select>
                    @if($errors->has('city_id'))
                    <span class="invalid-feedback" id="city_span_id">
                        {{ $errors->first('city_id') }}
                    </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                  <label for="userAddress1">Address #1 <span class="text-danger">*</span></label>
                  <input id="userAddress1" type="text" name="address1" placeholder="Enter First Address"  value="{{old('address1') ? old('address1') : $profile->address->address1 }}" class="form-control" required="required">
                  @error('address1')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                  <label for="address2">Address #2</label>
                  <input id="address2" type="text" name="address2" placeholder="Enter Second Address"  value="{{old('address2') ? old('address2') : $profile->address->address2 }}" class="form-control" required="required">
                  @error('address2')
                    <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                <label for="postcode">Post Code</label>
                    <input type="number" name="postcode" class="form-control" value="{{old('postcode') ? old('postcode') : $profile->address->postcode }}">
                    @error('postcode')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="custom-file" style="margin-top: 2rem!important">
                  <input accept="image/*" onchange="readURL(this);" class="custom-file-input form-control" type='file' name="photo" value="{{old('photo')}}" id="exampleInputFile">
                  <label class="custom-file-label" for="exampleInputFile">Profile Picture</label>
                </div>
                <input type="hidden" name="user_image" value="{{ $profile->photo }}" />
                <div class="mt-3 mb-3 show_images {{ ($profile->photo) ? 'd-block' : 'd-none' }}">
                    <img id="show_images" class="img img-responsive" src="{{asset('images/profile/'. $profile->photo)}}" style="max-height:250px; max-width:100%;" /><br>
                </div>
            </div>
        </div>
        <h5 class="text-info text-center mb-3 mt-3"><strong>Store Information</strong></h5>

        <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="storeName">Name <span class="text-danger">*</span></label>
                <input id="storeName" type="text" name="store_name" placeholder="Enter Store Name"  value="{{old('store_name') ? old('store_name') : $profile->store->name }}" class="form-control" required="required">
                @error('store_name')
                    <span class="text-danger">{{$message}}</span>
                @enderror
              </div>
            </div>
  
            <div class="col-md-6">
              <div class="form-group">
                <label for="userEmail">Email <span class="text-danger">*</span></label>
                <input id="userEmail" type="text" name="store_email" placeholder="Enter Store Email"  value="{{old('store_email') ? old('store_email') : $profile->store->email }}" class="form-control" required="required">
                @error('store_email')
                    <span class="text-danger">{{$message}}</span>
                @enderror
              </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                  <label for="storePhone">Phone Number<span class="text-danger">*</span></label>
                  <input id="storePhone" type="text" name="store_phone_number" placeholder="Enter Phone Number"  value="{{old('store_phone_number') ? old('store_phone_number') : $profile->store->phone }}" class="form-control" required="required">
                  @error('store_phone_number')
                    <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                  <label for="storePostCode">Post Code<span class="text-danger">*</span></label>
                  <input id="storePostCode" type="text" name="store_post_code" placeholder="Enter Post Code"  value="{{old('store_post_code') ? old('store_post_code') : $profile->store->address->postcode }}" class="form-control" required="required">
                  @error('store_post_code')
                    <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                  <label for="store_country_id">Country <span class="text-danger">*</span></label>
                  <select name="store_country_id" id="store_country_id" class="form-control" required="required" onchange="getStatesByCountryIdForStore(this)">
                      <option value="">Select</option>
                    @foreach($countries as $country)
                      <option value="{{$country->id}}" {{ ( $country->id == $profile->address->country_id ) ? 'selected' : '' }}>{{ $country->name }}</option>
                    @endforeach
                  </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="state_id">State <span class="text-danger">*</span></label>
                    <select class="form-control" name="store_state_id" id="store_state_id" required onchange="getCitiesByStateIdForStore(this)">
                        <option value="{{$profile->address->state->id}}">{{$profile->address->state->name}}</option>
                    </select>
                    @if($errors->has('store_state_id'))
                    <span class="invalid-feedback" id="state_span_id">
                        {{ $errors->first('store_state_id') }}
                    </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="store_city_id">City <span class="text-danger">*</span></label>
                    <select class="form-control" name="store_city_id" id="store_city_id" required>
                        <option value="{{$profile->address->city->id}}">{{$profile->address->city->name}}</option>
                    </select>
                    @if($errors->has('store_city_id'))
                    <span class="invalid-feedback" id="city_span_id">
                        {{ $errors->first('store_city_id') }}
                    </span>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                  <label for="storeAddress1">Address #1 <span class="text-danger">*</span></label>
                  <input id="storeAddress1" type="text" name="store_address_1" placeholder="Enter First Address"  value="{{old('store_address_1') ? old('store_address_1') : $profile->store->address->address1 }}" class="form-control" required="required">
                  @error('store_address_1')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                  <label for="storeaddress2">Address #2</label>
                  <input id="storeaddress2" type="text" name="store_address_2" placeholder="Enter Second Address"  value="{{old('store_address_2') ? old('store_address_2') : $profile->store->address->address2 }}" class="form-control" required="required">
                  @error('store_address_2')
                    <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="custom-file" style="margin-top: 2rem!important">
                  <input accept="image/*" onchange="readURL1(this);" class="custom-file-input form-control" type='file' name="store_photo" value="{{old('store_photo')}}" id="exampleInputFile">
                  <label class="custom-file-label" for="exampleInputFile">Store Picture</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                  <label for="store_type">Store Type <span class="text-danger">*</span></label>
                  <select name="store_type" id="store_type" class="form-control" required="required" onchange="getStatesByCountryIdForStore(this)">
                      <option value="">Select</option>
                    @foreach($categories as $category)
                      <option value="{{$category->id}}" {{ ( $category->id == $profile->store->category_id ) ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                  </select>
                </div>
            </div>
            <div class="col-md-6">
                <input type="hidden" name="store_image" value="{{ $profile->store->image }}" />
                <div class="mt-3 mb-3 p-2 show_images {{ ($profile->store->image) ? 'd-block' : 'd-none' }}">
                    <img id="show_images1" class="img img-responsive" src="{{asset('images/stores/'. $profile->store->image)}}" style="max-height:250px; max-width:100%;" /><br>
                </div>
            </div>
        </div>
        <div class="row mt-2 mb-2">
            <div class="col-md-12">
                <label for="short_description">Short Description <span class="text-danger">*</span></label>
                You have <b><label id="myCounter">{{ ( strlen($profile->store->short_description) > 0 ) ? 201 - strlen($profile->store->short_description) :"200" }}</label></b> characters left
                <br/>
                <textarea class="form-control" onKeyPress="return taLimit(this)" onKeyUp="return taCount(this,'myCounter')" id="content" name="short_description" rows=3 wrap="physical" cols=40>{{old('short_description') ? old('short_description') : $profile->store->short_description }}</textarea>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="long_description" class="col-form-label">Store/Shop Details</label>
                    <textarea class="form-control" id="long_description" name="long_description">{{old('long_description') ? old('long_description') : $profile->store->long_description }}</textarea>
                    @error('long_description')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
            </div>
        </div>
 
        <div class="col-md-12 mt-3">
          <div class="form-group">
            <button type="reset" class="btn btn-warning">Reset</button> &nbsp;
            <button class="btn btn-success" type="submit">Submit</button>
          </div>
        </div>
      </form>
    </div>
</div>
@endsection
@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
<link rel="stylesheet" href="{{asset('backend/css/simpledropit.min.css')}}">
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" /> --}}
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
{{-- https://www.jqueryscript.net/form/drag-drop-upload-zone.html --}}
<script src="{{asset('backend/js/simpledropit.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script>

    function getStatesByCountryId(country) {
        var country_id = country.value;
        $.ajax({
            url: "{{url('get-states-by-country-id').'/'}}"+country_id,
            method: 'GET',
            success:function(response){
                $('#state_id').html("");
                if(response.length === 0)
                $('#state_id').html("<option>No states found against country</option");
                $('#city_id').html("<option value=''>select state first</option");
                $.each(response, function (index, value) {
                    if(index == 0 )
                    $('#state_id').append('<option>Select State</option>');
                    $('#state_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                });
            },
            error: function(response) {
                $('#state_id').html("<option>No states found against country</option");
                console.log(response);
            }
        });
    }


    function getCitiesByStateId(state) {
        var state_id = state.value;
        $.ajax({
            url: "{{url('get-cities-by-state-id').'/'}}"+state_id,
            method: 'GET',
            success:function(response){
                $('#city_id').html("");
                if(response.length === 0)
                $('#city_id').html("<option>No cities found against state</option");
                $.each(response, function (index, value) {
                    if( index == 0 )
                    $('#city_id').append('<option>Select City</option>');
                    $('#city_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                });
            },
            error: function(response) {
                $('#city_id').html("<option>No cities found against state</option");
                console.log(response);
            }
        });
    }


    function getStatesByCountryIdForStore(country) {
        var country_id = country.value;
        $.ajax({
            url: "{{url('get-states-by-country-id').'/'}}"+country_id,
            method: 'GET',
            success:function(response){
                $('#store_state_id').html("");
                if(response.length === 0)
                $('#store_state_id').html("<option>No states found against country</option");
                $('#store_city_id').html("<option value=''>select state first</option");
                $.each(response, function (index, value) {
                    if(index == 0 )
                    $('#store_state_id').append('<option>Select State</option>');
                    $('#store_state_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                });
            },
            error: function(response) {
                $('#store_state_id').html("<option>No states found against country</option");
                console.log(response);
            }
        });
    }


    function getCitiesByStateIdForStore(state) {
        var state_id = state.value;
        $.ajax({
            url: "{{url('get-cities-by-state-id').'/'}}"+state_id,
            method: 'GET',
            success:function(response){
                $('#store_city_id').html("");
                if(response.length === 0)
                $('#store_city_id').html("<option>No cities found against state</option");
                $.each(response, function (index, value) {
                    if( index == 0 )
                    $('#store_city_id').append('<option>Select City</option>');
                    $('#store_city_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                });
            },
            error: function(response) {
                $('#store_city_id').html("<option>No cities found against state</option");
                console.log(response);
            }
        });
    }


    $(document).ready(function() {
      $('.select2').select2();
    //   $('#summary').summernote({
    //     placeholder: "Write short description.....",
    //       tabsize: 2,
    //       height: 100
    //   });
      $('#long_description').summernote({
        placeholder: "Write detail description.....",
          tabsize: 2,
          height: 150
      });
    });
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#show_images').parent().removeClass('d-none');
                $('#show_images').attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    function readURL1(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#show_images1').parent().removeClass('d-none');
                $('#show_images1').attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    //Count content
    maxL = 200;
    var bName = navigator.appName;

    function taLimit(taObj) {
        if (taObj.value.length == maxL) return false;
        return true;
    }

    function taCount(taObj, Cnt) {
        objCnt = createObject(Cnt);
        objVal = taObj.value;
        if (objVal.length > maxL) objVal = objVal.substring(0, maxL);
        if (objCnt) {
            if (bName == "Netscape") {
                objCnt.textContent = maxL - objVal.length;
            } else {
                objCnt.innerText = maxL - objVal.length;
            }
        }
        return true;
    }

    function createObject(objId) {
        if (document.getElementById) return document.getElementById(objId);
        else if (document.layers) return eval("document." + objId);
        else if (document.all) return eval("document.all." + objId);
        else return eval("document." + objId);
    } //End Count content
</script>

@endpush


