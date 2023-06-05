@extends('backend.layouts.master')

@section('main-content')

<div class="card shadow m-3">
    <h5 class="card-header">Add Shipping</h5>
    <div class="card-body">
      <form method="post" action="{{route('shipping.store')}}">
        {{csrf_field()}}

        <div class="form-group">
          <label for="country" class="col-form-label">Country <span class="text-danger">*</span></label>
          <select name="country_id" class="form-control select2" id="country_id" onchange="getStatesByCountryId(this)">
              <option value="">Select</option>
              @foreach ($countries as $country)
                <option value="{{$country->id}}" {{ ($country->id == $store_country_id) ? 'selected' : '' }} >{{$country->name}}</option>                
              @endforeach
          </select>
          @error('country')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="state" class="col-form-label">State <span class="text-danger">*</span></label>
          <select name="state_id" class="form-control" id="state_id" onchange="getCitiesByStateId(this)">
              <option value="">Select</option>
              @foreach ($states as $state)
                <option value="{{$state->id}}" {{ ($state->id == $store_state_id) ? 'selected' : '' }}>{{$state->name}}</option>                
              @endforeach
          </select>
          @error('state')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="city" class="col-form-label">City <span class="text-danger">*</span></label>
          <select name="city_id" class="form-control" id="city_id">
              <option value="">Select</option>
              @foreach ($cities as $city)
                <option value="{{$city->id}}" {{ ($city->id == $store_city_id) ? 'selected' : '' }}>{{$city->name}}</option>                
              @endforeach
          </select>
          @error('city')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="price" class="col-form-label">Price <span class="text-danger">*</span></label>
        <input id="price" type="number" name="price" placeholder="Enter price"  value="{{old('price')}}" class="form-control">
        @error('price')
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
</script>
@endpush