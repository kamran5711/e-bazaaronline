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
    </style>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<div class="container">
<div class="row justify-content-center" style="margin-top: 3rem; margin-bottom: 3rem;">
    {{-- <div class="row justify-content-center"> --}}
    {{-- <div class="col-md-12"> --}}
        <div class="card mx-12" style="background-color: whitesmoke;">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <h3 class="text-center" style="color: rgb(19, 18, 18)">Register Business</h3>
                    <!-- <p class="text-center">Register</p> -->
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <label for="domain">Enter Business Name</label>
                            <div class="input-group mb-3">
                                <input type="text" name="domain"
                                    class="form-control{{ $errors->has('domain') ? ' is-invalid' : '' }}"
                                    value="{{ old('domain', null) }}">
                                @if($errors->has('domain'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('domain') }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4"><label for="category_id">Business Type:</label>
                            <div class="input-group mb-3">
                                <select class="form-control{{ $errors->has('category_id') ? ' is-invalid' : '' }}"
                                    name="category_id" required>
                                    <option value="">Select Business Type</option>
                                    @foreach($category as $ct)
                                    <option value="{{$ct->id}}">{{$ct->name}}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('package_id'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('package_id') }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4"><label for="address">Business Address</label>
                            <div class="input-group mb-3">
                                <input type="text" name="address"
                                    class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}"
                                    value="{{ old('address', null) }}">
                                @if($errors->has('address'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('address') }}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"><label for="short_description">Building Name / Number</label>
                            <div class="input-group mb-3">
                                <input type="text" name="building"
                                    class="form-control{{ $errors->has('building') ? ' is-invalid' : '' }}">
                                @if($errors->has('building'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('building') }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4"><label for="address1">Address Line 1</label>
                            <div class="input-group mb-3">
                                <input type="text" name="address1"
                                    class="form-control{{ $errors->has('address1') ? ' is-invalid' : '' }}"
                                    value="{{ old('address1', null) }}">
                                @if($errors->has('address1'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('address1') }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4"><label for="address2">Address Line 2</label>
                            <div class="input-group mb-4">
                                <input type="text" name="address2"
                                    class="form-control{{ $errors->has('address2') ? ' is-invalid' : '' }}"
                                    value="{{ old('address2', null) }}">
                                @if($errors->has('address2'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('address2') }}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"><label for="area">Area</label>
                            <div class="input-group mb-3">
                                <input type="text" name="area"
                                    class="form-control{{ $errors->has('area') ? ' is-invalid' : '' }}"
                                    value="{{ old('area', null) }}">
                                @if($errors->has('area'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('area') }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4"><label for="city:">City</label>
                            <div class="input-group mb-3">
                                <input type="text" name="city"
                                    class="form-control{{ $errors->has('city') ? ' is-invalid' : '' }}"
                                    value="{{ old('city', null) }}">
                                @if($errors->has('city'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('city') }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4"><label for="postcode">Postcode</label>
                            <div class="input-group mb-3">
                                <input type="number" name="postcode" class="form-control{{ $errors->has('postcode') ? ' is-invalid' : '' }}" 
                                    value="{{ old('postcode', null) }}">
                                @if($errors->has('postcode'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('postcode') }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4"><label for="business_contact_number">Business Contact Number</label>
                            <div class="input-group mb-3">
                                <input type="number" name="business_contact_number"
                                    class="form-control{{ $errors->has('business_contact_number') ? ' is-invalid' : '' }}"
                                    value="{{ old('business_contact_number', null) }}">
                                @if($errors->has('business_contact_number'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('business_contact_number') }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4"><label for="business_email">Business Email Address</label>
                            <div class="input-group mb-3">
                                <input type="email" name="email"
                                    class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                    value="{{ old('email', null) }}">
                                @if($errors->has('email'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('email') }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4"><label for="email_confirmation">Re-Enter Email</label>
                            <div class="input-group mb-3">
                                <input type="email" name="email_confirmation"
                                    class="form-control{{ $errors->has('email_confirmation') ? ' is-invalid' : '' }}"
                                    value="{{ old('email_confirmation', null) }}">
                                @if($errors->has('email_confirmation'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('email_confirmation') }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4"><label for="person_name">Business Contact Person Name</label>
                            <div class="input-group mb-3">
                                <input type="text" name="person_name"
                                    class="form-control{{ $errors->has('person_name') ? ' is-invalid' : '' }}"
                                    value="{{ old('person_name', null) }}">
                                @if($errors->has('person_name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('person_name') }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4"><label for="person_tel">Contact Person Tel. Number</label>
                            <div class="input-group mb-3">
                                <input type="number" name="person_tel"
                                    class="form-control{{ $errors->has('person_tel') ? ' is-invalid' : '' }}"
                                    value="{{ old('person_tel', null) }}">
                                @if($errors->has('person_tel'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('person_tel') }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4"><label for="psw">Password</label>
                            <div class="input-group mb-3">
                                <input type="password" name="password" id="psw"
                                    class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                    value="{{ old('password', null) }}"
                                    title="Password must contain at least 8 characters, including UPPER/lowercase and numbers."
                                    maxlength="15" size="15" type="password" required
                                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">
                                @if($errors->has('password'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('password') }}
                                </div>
                                @endif
                            </div>
                       
<div id="message">
<div> A Password must be of at least 8 characters and Should contain </div> 
  <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
  <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
  <p id="number" class="invalid">A <b>number</b></p>
  <p id="length" class="invalid">Minimum <b>8 characters</b></p>
</div>

</div>
		
                        <div class="col-md-4">
                            <label for="psw">Re-Enter Password</label>
                            <div class="input-group mb-3">
                                <input type="password" name="password_confirmation"  id="psw"
                                    class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}"
                                    value="{{ old('password_confirmation', null) }}" required
                                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" maxlength="15" size="15"
                                    title="Please enter the same Password as above.">
                                @if($errors->has('password_confirmation'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('password_confirmation') }}
                                </div>
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
                                        id="inlineRadio2" value="Not Yet Registered">
                                    Not Yet Registered</label>
                            </div>
                        </div>


                        <div class="col-md-4 Limited select" class="Limited"><label for="password">Company Registration
                                Number</label>
                            <div class="input-group mb-3">
                                <input type="text" name="company_reg_no"
                                    class="form-control{{ $errors->has('company_reg_no') ? ' is-invalid' : '' }}"
                                    value="{{ old('company_reg_no', null) }}">
                                @if($errors->has('company_reg_no'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('company_reg_no') }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 Limited select" class="Limited"><label for="password">Tax Department
                                Number</label>
                            <div class="input-group mb-3">
                                <input type="number" name="tax_dep_nu"
                                    class="form-control{{ $errors->has('tax_dep_nu') ? ' is-invalid' : '' }}"
                                    value="{{ old('tax_dep_nu', null) }}">
                                @if($errors->has('tax_dep_nu'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('tax_dep_nu') }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 Limited select" class="Limited"><label for="password">Company Registration
                                Certificate: upload Document (jpg, jpeg, png, bmp, gif, svg, webp, pdf,
                                docx)</label>
                            <div class="col-md-6">
                                <input type="file" name="company_reg_cerf">
                                @if($errors->has('company_reg_cerf'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('company_reg_cerf') }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 Limited select" class="Limited"><label for="password">Tax Department
                                Certificate (jpg, jpeg, png, bmp, gif, svg, webp, pdf,
                                docx)</label>
                            <div class="col-md-6">
                                <input type="file" name="tax_dep_cerf">
                                @if($errors->has('tax_dep_cerf'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('tax_dep_cerf') }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 Limited select" class="Limited"><label for="password">Other Registration
                                Documents (jpg, jpeg, png, bmp, gif, svg, webp, pdf,
                                docx)</label>
                            <div class="col-md-6">
                                <input type="file" name="other_reg_docu">
                                @if($errors->has('other_reg_docu'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('other_reg_docu') }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12"><br><label for="short_description">Short Description</label>
                            <div class="input-group mb-3">
                                <textarea name="short_description" placeholder="Enter short description" rows="1"
                                    class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-12">
                        <div class="col-md-12">
                            <label for="long_description">Products description & specification</label>
                            <textarea name="long_description" id="longDescription" placeholder="Enter long description"
                                class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row mb-12">
                        <div class="col-md-6">
                            <label for="image">Upload Business Profile image (jpg, jpeg, png, bmp, gif, svg, webp, pdf)</label>
                            <input type="file" name="image">
                            @if($errors->has('image'))
                            <div class="invalid-feedback">
                                {{ $errors->first('image') }}
                            </div>
                            @endif
                        </div>
                    </div><br>
                   
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
                            <a class="btn btn-block btn-primary" href="{{ url('/') }}">
                                Back
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
@endsection