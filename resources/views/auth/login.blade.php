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

    input[type=text], input[type=email], input[type=password] {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        box-sizing: border-box;
    }
    </style>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>


<div class="container">
<div class="row justify-content-center m-5" style="">
    {{-- <div class="row justify-content-center"> --}}
    {{-- <div class="col-md-12"> --}}
        <div class="card mx-12 w-100" style="background-color: whitesmoke; max-width:460px!important;">
            <div class="card-body p-6">
                <div class="login-form">
                    <form method="POST" action="{{ route('login') }}" class="form">
                        @csrf
                        <h3 class="text-center p-2 text-primary">Sign in</h3> 
                         @if(Session::has('message'))
                          <p class="alert alert-success">{{ session('message')}}</p>
                        @endif
                        @error('message_error')
                          <p class="alert alert-danger"> {{ $message }}</p>
                        @enderror 

                        <div class="form-group pt-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <span class="fa fa-user"></span>
                                    </span>                    
                                </div>
                                <input type="text" name="email" placeholder="Enter Email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" required>				
                            </div>
                            @error('email')
                            <span class="text-danger">{{$message}}</span>
                           @enderror
                        </div>
                        <div class="form-group pt-2">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-lock"></i>
                                    </span>                    
                                </div>
                                <input name="password" id="psw" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" required placeholder="Enter Password">				
                              @if($errors->has('password'))
                            <div class="invalid-feedback">
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                            </div>
                        </div>        
                        <div class="clearfix">
                            <label class="float-left form-check-label pl-0"><input type="checkbox"> Remember me</label>
                            {{-- <a  href="{{url('password/reset')}}" class="float-right">Forgot Password?</a> --}}
                        </div>
                        <div class="form-group pt-2 text-center">
                            <button type="submit" class="btn btn-primary login-btn rounded-0 pl-5 pr-5">Sign in</button>
                        </div>
                        {{-- <div class="or-seperator"><i>or</i></div> --}}
                        {{-- <p class="text-center">Login with your social media account</p> --}}
                        {{-- <div class="text-center social-btn">
                            <a href="#" class="btn btn-secondary"><i class="fa fa-facebook"></i>&nbsp; Facebook</a>
                            <a href="#" class="btn btn-info"><i class="fa fa-twitter"></i>&nbsp; Twitter</a>
                            <a href="#" class="btn btn-danger"><i class="fa fa-google"></i>&nbsp; Google</a>
                        </div> --}}
                    </form>
                    <p class="text-center text-muted small">Don't have an account? <a href="{{ route('store.register') }}">Sign up here!</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- </div> --}}
@endsection
@section('scripts')
<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=9z77wjhpwrx6pvh3r3oeiky25krlx0jzd8m69yte73hjrrgg">
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