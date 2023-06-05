@extends('frontend.layouts.master')
@section('title','E-SHOP || Register Page')
@section('page-title','Register Page')
@section('main-content')
<style>
         @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');
*{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Poppins',sans-serif;
}
.containerr{
  max-width: 1000px;
  margin-bottom: 3%;
  margin-top: 3%;
  margin-left:20%;
  margin-right:20%;
  width: 100%;
  background-color: whitesmoke;
  padding: 25px 30px;
  border-radius: 5px;
  box-shadow: 0 5px 10px rgba(0,0,0,0.15);
}
.containerr .title{
  font-size: 25px;
  font-weight: 500;
  position: relative;
}
.containerr .title::before{
  content: "";
  position: absolute;
  /* left: 0; */
  bottom: 0;
  height: 3px;
  width: 30px;
  border-radius: 5px;
  background: linear-gradient(135deg, #71b7e6, #9b59b6);
}
.content form .user-details{
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  margin: 20px 0 12px 0;
}
form .user-details .input-box{
  margin-bottom: 15px;
  width: calc(100% / 2 - 20px);
}
form .input-box span.details{
  display: block;
  font-weight: 500;
  margin-bottom: 5px;
}
.user-details .input-box input{
  height: 45px;
  width: 100%;
  outline: none;
  font-size: 16px;
  border-radius: 5px;
  padding-left: 15px;
  border: 1px solid #ccc;
  border-bottom-width: 2px;
  transition: all 0.3s ease;
}
/* .input-box .nice-select {
  width: 100% !important;
}
.input-box .list {
  width: 100% !important;
  height: 200px;
  overflow: auto
} */
.user-details .input-box input:focus,
.user-details .input-box input:valid{
  border-color: #0000003d;
}
 form .gender-details .gender-title{
  font-size: 20px;
  font-weight: 500;
 }
 form .category{
   display: flex;
   width: 80%;
   margin: 14px 0 ;
   justify-content: space-between;
 }
 form .category label{
   display: flex;
   align-items: center;
   cursor: pointer;
 }
 form .category label .dot{
  height: 18px;
  width: 18px;
  border-radius: 50%;
  margin-right: 10px;
  background: #d9d9d9;
  border: 5px solid transparent;
  transition: all 0.3s ease;
}
 #dot-1:checked ~ .category label .one,
 #dot-2:checked ~ .category label .two,
 #dot-3:checked ~ .category label .three{
   background: #9b59b6;
   border-color: #d9d9d9;
 }
 form input[type="radio"]{
   display: none;
 }
 form .button{
   height: 45px;
   margin: 35px 0
 }
 form .button input{
   height: 100%;
   width: 100%;
   border-radius: 5px;
   border: none;
   color: white;
   font-size: 18px;
   font-weight: 500;
   letter-spacing: 1px;
   cursor: pointer;
   transition: all 0.3s ease;
   background: #424646;
   /* background: linear-gradient(135deg, #71b7e6, #9b59b6); */
 }
 form .button input:hover{
  /* transform: scale(0.99); */
  background: #fd7e14;
  /* background: linear-gradient(-135deg, #71b7e6, #9b59b6); */
  }
 @media(max-width: 584px){
 .container{
  max-width: 100%;
}
form .user-details .input-box{
    margin-bottom: 15px;
    width: 100%;
  }
  form .category{
    width: 100%;
  }
  .content form .user-details{
    max-height: 300px;
    overflow-y: scroll;
  }
  .user-details::-webkit-scrollbar{
    width: 5px;
  }
  }
  @media(max-width: 459px){
  .container .content .category{
    flex-direction: column;
  }
}
</style>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<div class="containerr">
    <div class="title text-center">Register</div>
                    <p>Please register in order to checkout more quickly</p>
    <div class="content">
    <form class="form" method="post" action="{{route('register.submit')}}">
       @csrf
        <div class="user-details">
          <div class="input-box">
            <span class="details">Full Name</span>
            <input type="text"  name="name" value="{{old('name')}}" placeholder="Enter your name" autofocus="1">
            @error('name')
               <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
          <div class="input-box">
            <span class="details">Email</span>
            <input type="email" name="email" placeholder="Enter email" value="{{old('email')}}">
            @error('email')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>

          <div class="input-box">
            <span class="details">Phone</span>
            <input type="number" name="phone" id="phone" placeholder="Enter phone" value="{{old('phone')}}">
            @error('phone')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>

        <div class="col-md-6 pl-0 pr-0">
            <div class="input-box">
              <span class="details">Country <span class="text-danger">*</span></span>
                <select class="form-control select2" name="country_id" id="country_id" required onchange="getStatesByCountryId(this)">
                    <option value="">Select Country</option>
                    @foreach($countries as $country)
                    <option value="{{$country->id}}">{{$country->name}}</option>
                    @endforeach
                </select>
                @if($errors->has('country_id'))
                <span class="invalid-feedback" id="country_span_id">
                    {{ $errors->first('country_id') }}
                </span>
                @endif
            </div>
        </div>

        <div class="col-md-6 pl-0 pr-0">
          <div class="input-box">
              <span class="details">State <span class="text-danger">*</span></span>
                <select class="form-control select2"
                    name="state_id" id="state_id" required onchange="getCitiesByStateId(this)">
                    <option value="">Select country first</option>
                </select>
                @if($errors->has('state_id'))
                <span class="invalid-feedback" id="state_span_id">
                    {{ $errors->first('state_id') }}
                </span>
                @endif
            </div>
        </div>

        <div class="col-md-6 pl-0">
          <div class="input-box">
              <span class="details">City <span class="text-danger">*</span></span>
                <select class="form-control select2"
                    name="city_id" id="city_id" required>
                    <option value="">Select state first</option>
                </select>
                @if($errors->has('city_id'))
                <span class="invalid-feedback" id="city_span_id">
                    {{ $errors->first('city_id') }}
                </span>
                @endif
            </div>
        </div>
          <div class="input-box">
            <span class="details">Address Line 1</span>
            <input type="text" placeholder="Address Line 1" name="address1"  value="{{old('address1')}}">
            @error('address1')
             <span class="text-danger">{{$message}}</span>
              @enderror
          </div>
          <div class="input-box">
            <span class="details">Address Line 2</span>
            <input type="text" name="address2" placeholder="Address Line 2" value="{{old('address2')}}">
            @error('address2')
              <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="input-box">
            <span class="details">Postcode</span>
            <input type="text" name="postcode" placeholder="postcode"  value="{{old('postcode')}}">
            @error('postcode')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="input-box">
            <span class="details">Password</span>
            <input type="password" name="password" placeholder="Password" value="{{old('password')}}"
            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{5,}" title="Password must contain at least 8 characters, including UPPER/lowercase and numbers."/>
            @error('password')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="input-box">
            <span class="details">Confirm Password</span>
            <input type="password" name="password_confirmation" placeholder="Re-Enter Password" value="{{old('password_confirmation')}}">
            @error('password_confirmation')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
       
        </div>
        <div class="col-12">
                             <div class="form-group text-left">
                            <div class="g-recaptcha brochure__form__captcha" data-sitekey="6Lfj_CQeAAAAAAAwa_5B8dgn5V6jCts-Rwbkyfhb"></div>
                            </div>
                            </div>
        <div class="button">
          <input type="submit" value="Register">
        </div>
      </form>
    </div>
  </div>
@endsection



@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endpush
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script>
  
    $(document).ready(function() {
      $('.select2').select2();
        $('.nice-select').next().hide();
    });
    // $('select').selectpicker();
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


@push('scripts')
<script src='https://www.google.com/recaptcha/api.js'></script>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=9z77wjhpwrx6pvh3r3oeiky25krlx0jzd8m69yte73hjrrgg">
</script>
<script src="{{asset('mainJS/jquery.mask.js')}}"></script>
<script>
    $(document).ready(function(){
        $('#phone').mask('00000000000000',{placeholder:"92xxxxxxxxxxxx"});
        // $('#person_tel').mask('00000000000000',{placeholder:"92xxxxxxxxxxxx"});
    });

  function get_action(form) {
    var v = grecaptcha.getResponse();
    if(v.length == 0)
    {
        document.getElementById('captcha').innerHTML="You can't leave Captcha Code empty";
        return false;
    }
    else
    {
        document.getElementById('captcha').innerHTML="Captcha completed";
        return true; 
    }
  }
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