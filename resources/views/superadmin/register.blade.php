@extends('layouts.main')
@section('content')
<style>
    /* Style all input fields */
    /* input {
      width: 100%;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
      margin-top: 6px;
      margin-bottom: 16px;
    } */
    
    /* Style the submit button */
    input[type=submit] {
      background-color: #04AA6D;
      color: white;
    }
    
    /* The message box is shown when the user clicks on the password field */
    #message {
      display:none;
      background: #f1f1f1;
      color: #000;
      position: relative;
      padding: 3px;
      margin-top: 3px;
    }
    
    #message p {
      padding: 7px 35px;
      font-size: 14px;
    }
    
    /* Add a green text color and a checkmark when the requirements are right */
    .valid {
      color: green;
    }
    
    .valid:before {
      position: relative;
      left: -35px;
      content: "✔";
    }
    
    /* Add a red text color and an "x" when the requirements are wrong */
    .invalid {
      color: red;
    }
    
    .invalid:before {
      position: relative;
      left: -35px;
      content: "✖";
    }

    label {
    display: inline-block;
    margin-bottom: 0.5rem;
    color: gray;
    font-size: 13px;
    font-weight: 400;
}
    </style>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<div class="container">
<div class="row justify-content-center" style="margin-top: 3rem; margin-bottom: 3rem;">
    {{-- <div class="row justify-content-center"> --}}
    {{-- <div class="col-md-12"> --}}
        <div class="card mx-12" style="background-color: whitesmoke;">
       
            <div class="card-body p-4">
                <form method="POST" action="{{ route('store.register_process') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <h3 class="text-center" style="color: rgb(19, 18, 18)">Register Business</h3>
                    <!-- <p class="text-center">Register</p> -->
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <label for="domain">Enter Business Name <span class="text-danger">*</span></label>
                            <div class="form-group mb-3">
                                <input type="text" name="domain"
                                    class="form-control{{ $errors->has('domain') ? ' is-invalid' : '' }}"
                                    value="{{ old('domain', null) }}">
                                @if($errors->has('domain'))
                                <span class="invalid-feedback" id="domain">
                                    {{ $errors->first('domain') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4"><label for="business_email">Business Email Address <span class="text-danger">*</span></label>
                            <div class="form-group mb-3">
                                <input type="email" name="email"
                                    class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                    value="{{ old('email', null) }}">
                                @if($errors->has('email'))
                                <span class="invalid-feedback" id="business_email">
                                    {{ $errors->first('email') }}
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-4"><label for="category_id">Business Type <span class="text-danger">*</span></label>
                            <div class="form-group mb-3">
                                <select class="form-control{{ $errors->has('category_id') ? ' is-invalid' : '' }}"
                                    name="category_id" required>
                                    <option value="">Select</option>
                                    @foreach($category as $ct)
                                    <option value="{{$ct->id}}">{{$ct->name}}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('package_id'))
                                <span class="invalid-feedback" id="category_id">
                                    {{ $errors->first('package_id') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4"><label for="country_id">Country <span class="text-danger">*</span></label>
                            <div class="form-group mb-3">
                                <select class="form-control{{ $errors->has('country_id') ? ' is-invalid' : '' }}"
                                    name="country_id" id="country_id" required onchange="getStatesByCountryId(this)">
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

                        <div class="col-md-4"><label for="state_id">State <span class="text-danger">*</span></label>
                            <div class="form-group mb-3">
                                <select class="form-control{{ $errors->has('state_id') ? ' is-invalid' : '' }}"
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

                        <div class="col-md-4"><label for="city_id">City <span class="text-danger">*</span></label>
                            <div class="form-group mb-3">
                                <select class="form-control{{ $errors->has('city_id') ? ' is-invalid' : '' }}"
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

                        {{-- <div class="col-md-4"><label for="address">Business Address <span class="text-danger">*</span></label>
                            <div class="form-group mb-3">
                                <input type="text" name="address"
                                    class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}"
                                    value="{{ old('address', null) }}">
                                @if($errors->has('address'))
                                <span class="invalid-feedback">
                                    {{ $errors->first('address') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4"><label for="short_description">Building Name / Number <span class="text-danger">*</span></label>
                            <div class="form-group mb-3">
                                <input type="text" name="building"
                                    class="form-control{{ $errors->has('building') ? ' is-invalid' : '' }}">
                                @if($errors->has('building'))
                                <span class="invalid-feedback" id="short_description">
                                    {{ $errors->first('building') }}
                                </span>
                                @endif
                            </div>
                        </div> --}}
                        <div class="col-md-4"><label for="address1">Address Line 1</label>
                            <div class="form-group mb-3">
                                <input type="text" name="address1"
                                    class="form-control{{ $errors->has('address1') ? ' is-invalid' : '' }}"
                                    value="{{ old('address1', null) }}">
                                @if($errors->has('address1'))
                                <span class="invalid-feedback" id="address1">
                                    {{ $errors->first('address1') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4"><label for="address2">Address Line 2</label>
                            <div class="form-group mb-4">
                                <input type="text" name="address2"
                                    class="form-control{{ $errors->has('address2') ? ' is-invalid' : '' }}"
                                    value="{{ old('address2', null) }}">
                                @if($errors->has('address2'))
                                <span class="invalid-feedback" id="address2">
                                    {{ $errors->first('address2') }}
                                </span>
                                @endif
                            </div>
                        </div>

                        {{-- <div class="col-md-4"><label for="area">Area <span class="text-danger">*</span></label>
                            <div class="form-group mb-3">
                                <input type="text" name="area"
                                    class="form-control{{ $errors->has('area') ? ' is-invalid' : '' }}"
                                    value="{{ old('area', null) }}">
                                @if($errors->has('area'))
                                <span class="invalid-feedback" id="area">
                                    {{ $errors->first('area') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4"><label for="city">City <span class="text-danger">*</span></label>
                            <div class="form-group mb-3">
                                <input type="text" name="city"
                                    class="form-control{{ $errors->has('city') ? ' is-invalid' : '' }}"
                                    value="{{ old('city', null) }}">
                                @if($errors->has('city'))
                                <span class="invalid-feedback" id="city">
                                    {{ $errors->first('city') }}
                                </span>
                                @endif
                            </div>
                        </div> --}}
                        <div class="col-md-4"><label for="postcode">Postcode</label>
                            <div class="form-group mb-3">
                                <input type="number" name="postcode" class="form-control{{ $errors->has('postcode') ? ' is-invalid' : '' }}" 
                                    value="{{ old('postcode', null) }}">
                                @if($errors->has('postcode'))
                                <span class="invalid-feedback" id="postcode">
                                    {{ $errors->first('postcode') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4"><label for="business_contact_number">Business Contact Number <span class="text-danger">*</span></label>
                            <div class="form-group mb-3">
                                <input type="number" id="business_contact_number" name="business_contact_number"
                                    class="form-control{{ $errors->has('business_contact_number') ? ' is-invalid' : '' }}"
                                    value="{{ old('business_contact_number', null) }}" maxlength="14" minlength="14">
                                @if($errors->has('business_contact_number'))
                                <span class="invalid-feedback" id="business_contact_number">
                                    {{ $errors->first('business_contact_number') }}
                                </span>
                                @endif
                            </div>
                        </div>

                        {{-- <div class="col-md-4"><label for="email_confirmation">Re-Enter Email</label>
                            <div class="form-group mb-3">
                                <input type="email" name="email_confirmation"
                                    class="form-control{{ $errors->has('email_confirmation') ? ' is-invalid' : '' }}"
                                    value="{{ old('email_confirmation', null) }}">
                                @if($errors->has('email_confirmation'))
                                <span class="invalid-feedback">
                                    {{ $errors->first('email_confirmation') }}
                                </span>
                                @endif
                            </div>
                        </div> --}}
                        <div class="col-md-4"><label for="person_name">Business Contact Person Name <span class="text-danger">*</span></label>
                            <div class="form-group mb-3">
                                <input type="text" id="person
                                _name" name="person_name"
                                    class="form-control{{ $errors->has('person_name') ? ' is-invalid' : '' }}"
                                    value="{{ old('person_name', null) }}">
                                @if($errors->has('person_name'))
                                <span class="invalid-feedback" id="person_name">
                                    {{ $errors->first('person_name') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4"><label for="person_tel">Contact Person Tel. Number <span class="text-danger">*</span></label>
                            <div class="form-group mb-3">
                                <input type="number" id="person_tel" name="person_tel"
                                    class="form-control{{ $errors->has('person_tel') ? ' is-invalid' : '' }}"
                                    value="{{ old('person_tel', null) }}" maxlength="14" minlength="14">
                                @if($errors->has('person_tel'))
                                <span class="invalid-feedback" id="person_tel">
                                    {{ $errors->first('person_tel') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4"><label for="psw">Password <span class="text-danger">*</span></label>
                            <div class="form-group mb-3">
                                <input type="password" name="password" id="psw"
                                    class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                    value="{{ old('password', null) }}"
                                    title="Password must contain at least 8 characters, including UPPER/lowercase and numbers."
                                    maxlength="15" size="15" type="password" required
                                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">
                                @if($errors->has('password'))
                                <span class="invalid-feedback" id="psw">
                                    {{ $errors->first('password') }}
                                </span>
                                @endif
                            </div>
                       
                    <div id="message">
                        <span> A Password must be of at least 8 characters and Should contain </SPAN> 
                        <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
                        <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
                        <p id="number" class="invalid">A <b>number</b></p>
                        <p id="length" class="invalid">Minimum <b>8 characters</b></p>
                    </div>

                    </div>
		
                    <div class="col-md-4">
                        <label for="psw">Re-Enter Password <span class="text-danger">*</span></label>
                        <div class="form-group mb-3">
                            <input type="password" name="password_confirmation"  id="psw"
                                class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}"
                                value="{{ old('password_confirmation', null) }}" required
                                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" maxlength="15" size="15"
                                title="Please enter the same Password as above.">
                            @if($errors->has('password_confirmation'))
                            <span class="invalid-feedback">
                                {{ $errors->first('password_confirmation') }}
                            </span>
                            @endif
                        </div>
                    </div>
                      <div class="col-md-8 "><label for="your_business">Is Your Business</label><br>
                            <div class="form-check form-check-inline"><label class="btn btn-default">
                                    <input class="form-check-input" type="radio" name="your_business"
                                        id="inlineRadio1" value="Sole Trade">
                                    Sole Trade</label>
                            </div>
                            <div class="form-check form-check-inline"><label class="btn btn-default">
                                    <input class="form-check-input" type="radio" name="your_business"
                                        id="inlineRadio2" value="Limited">
                                    Limited Company</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="btn btn-default">
                                    <input class="form-check-input" type="radio" name="your_business"
                                        id="inlineRadio2" value="Not Yet Registered" checked>
                                    Not Yet Registered</label>
                            </div>
                        </div>


                        <div class="col-md-4 Limited select" class="Limited"><label for="password">Company Registration
                                Number</label>
                            <div class="form-group mb-3">
                                <input type="text" name="company_reg_no"
                                    class="form-control{{ $errors->has('company_reg_no') ? ' is-invalid' : '' }}"
                                    value="{{ old('company_reg_no', null) }}">
                                @if($errors->has('company_reg_no'))
                                <span class="invalid-feedback">
                                    {{ $errors->first('company_reg_no') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 Limited select" class="Limited"><label for="password">Tax Department
                                Number</label>
                            <div class="form-group mb-3">
                                <input type="number" name="tax_dep_nu"
                                    class="form-control{{ $errors->has('tax_dep_nu') ? ' is-invalid' : '' }}"
                                    value="{{ old('tax_dep_nu', null) }}">
                                @if($errors->has('tax_dep_nu'))
                                <span class="invalid-feedback">
                                    {{ $errors->first('tax_dep_nu') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 Limited select" class="Limited"><label for="password">Company Registration
                                Certificate: upload Document (jpg, jpeg, png, bmp, gif, svg, webp, pdf,
                                docx)</label>
                            <div class="col-md-6">
                                <input type="file" name="company_reg_cerf">
                                @if($errors->has('company_reg_cerf'))
                                <span class="invalid-feedback">
                                    {{ $errors->first('company_reg_cerf') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 Limited select" class="Limited"><label for="password">Tax Department
                                Certificate (jpg, jpeg, png, bmp, gif, svg, webp, pdf,
                                docx)</label>
                            <div class="col-md-6">
                                <input type="file" name="tax_dep_cerf">
                                @if($errors->has('tax_dep_cerf'))
                                <span class="invalid-feedback">
                                    {{ $errors->first('tax_dep_cerf') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 Limited select" class="Limited"><label for="password">Other Registration
                                Documents (jpg, jpeg, png, bmp, gif, svg, webp, pdf,
                                docx)</label>
                            <div class="col-md-6">
                                <input type="file" name="other_reg_docu">
                                @if($errors->has('other_reg_docu'))
                                <span class="invalid-feedback">
                                    {{ $errors->first('other_reg_docu') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12"><br><label for="short_description">Short Description <span class="text-danger">*</span></label>
                            {{-- <div class="form-group mb-3">
                                <textarea name="short_description" placeholder="Enter short description" rows="1"
                                    class="form-control"></textarea>
                            </div> --}}

                            You have <b><label id="myCounter">200</label></b> characters left
                            <br/>
                            <textarea class="inputtextfield form-control" onKeyPress="return taLimit(this)" onKeyUp="return taCount(this,'myCounter')" id="content" name="short_description" rows=3 wrap="physical" cols=40></textarea>
                        </div>


                        <div class="col-md-12">
                            <label for="long_description">Bussiness Details</label>
                            <textarea name="long_description" id="longDescription" placeholder="Enter long description"
                                class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row mb-12 mt-5">
                        <div class="col-md-6">
                            <label for="image">Upload Business Profile image ( 270 X 370 )</label>
                            <input type="file" name="image">
                            @if($errors->has('image'))
                            <span class="invalid-feedback">
                                {{ $errors->first('image') }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <br>
                   
                    <div class="row">
                      <div class="col-md-6">
                            <div class="form-group text-left">
                            <div class="g-recaptcha brochure__form__captcha" data-sitekey="6LdSECYeAAAAAAqrr_Bu7pQMhL34FjQ1EGg286c2">
                            </div>
                            </div>
                      </div>
                        <div class="col-md-3">
                            <button class="btn btn-block btn-primary">
                                Register
                            </button>
                        </div>
                        <div class="col-md-3">
                            <a class="btn btn-block btn-primary btn-link" href="{{ url('/login') }}">
                                Already have account?<br /> click to login
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- </div> --}}
@endsection
@section('scripts')
<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=9z77wjhpwrx6pvh3r3oeiky25krlx0jzd8m69yte73hjrrgg">
</script>
<script src="{{asset('mainJS/jquery.mask.js')}}"></script>
<script>
    $(document).ready(function(){
        $('#business_contact_number').mask('00000000000000',{placeholder:"92xxxxxxxxxxxx"});
        $('#person_tel').mask('00000000000000',{placeholder:"92xxxxxxxxxxxx"});
    });
</script>
<script>
tinymce.init({
    selector: '#longDescription',
    plugins: 'table,textcolor,image,lists,link,code,wordcount,advlist, autosave',
    theme: 'modern',
    menubar: 'none',
    height: '120',
    toolbar: 'restoredraft,bold italic underline | fontselect |  fontsizeselect | forecolor backcolor |alignleft aligncenter alignright alignjustify| bullist,numlist | link image'
});
</script>
<script type="text/javascript">
$(document).ready(function() {
    $('.Limited').hide();
    $('#Not Yet Registered').hide(); 
    $('#Sole Trade').hide();   
    $('input[type="radio"]').click(function() {
        var inputValue = $(this).attr("value");
        if (inputValue == "Not Yet Registered" || inputValue == "Sole Trade") {
            $(".Limited").hide();
            $("#Not Yet Registered").hide();
        } else {
            $("#Not Yet Registered").hide();
            $(".Limited").show();
        }
    });
})
</script>
				
<script>
var myInput = document.getElementById("psw");
var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");

// When the user clicks on the password field, show the message box
myInput.onfocus = function() {
  document.getElementById("message").style.display = "block";
}

// When the user clicks outside of the password field, hide the message box
myInput.onblur = function() {
  document.getElementById("message").style.display = "none";
}

// When the user starts to type something inside the password field
myInput.onkeyup = function() {
  // Validate lowercase letters
  var lowerCaseLetters = /[a-z]/g;
  if(myInput.value.match(lowerCaseLetters)) {  
    letter.classList.remove("invalid");
    letter.classList.add("valid");
  } else {
    letter.classList.remove("valid");
    letter.classList.add("invalid");
  }
  
  // Validate capital letters
  var upperCaseLetters = /[A-Z]/g;
  if(myInput.value.match(upperCaseLetters)) {  
    capital.classList.remove("invalid");
    capital.classList.add("valid");
  } else {
    capital.classList.remove("valid");
    capital.classList.add("invalid");
  }

  // Validate numbers
  var numbers = /[0-9]/g;
  if(myInput.value.match(numbers)) {  
    number.classList.remove("invalid");
    number.classList.add("valid");
  } else {
    number.classList.remove("valid");
    number.classList.add("invalid");
  }
  
  // Validate length
  if(myInput.value.length >= 8) {
    length.classList.remove("invalid");
    length.classList.add("valid");
  } else {
    length.classList.remove("valid");
    length.classList.add("invalid");
  }
}
</script>

<script src='https://www.google.com/recaptcha/api.js'></script>
<script>

function get_action(form) 
{
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
</script>


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


@endsection