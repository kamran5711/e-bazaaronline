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
<div class="row justify-content-center" style="margin-top: 6rem; margin-bottom: 13rem;">
        <div class="card mx-12" style="background-color: whitesmoke;">
            <div class="card-body p-6">
               
                  <h3 class="text-success text-center">Congratulations</h3>

                  <p>Dear <strong class="text-primary">{{$name}}</strong></p>

                  <p>Thank you for sending your registration Request for <strong class="text-primary">{{$business}}.</strong></p>

                  <p>It is to acknowledge that we have received your request and are now processing to setup your shop.</p></p>

                  <p>We will send you a Welcome Email within 3 days that will have information on how to access your page and admin panel.</p></p>

                  <p>Best Wishes </p>

                  <p>Softech Business Services</p>
                  <br>
                  
                       <h3 class="text-success text-center">مبارکباد</h3>
                <div class="text-right">
                 <p> <strong class="text-primary">  {{$name}}</strong>محترم / محترمہ</p>

                  <p>کے لیے اپنی رجسٹریشن بھیجنے کا شکریہ۔ <strong class="text-primary">{{$business}} </strong></p>

                 <p> ہمیں آپ کی درخواست موصول ہوئی ہے اور اب ہم آپ کی آن لائن دکان کی سيٹ اپ کر رہے ہیں۔</p>

                 <p> ہم آپ کو 3 دن کے اندر ایک خوش آمدیدی ای میل بھیجیں گے جس میں آپ کے ویب ساقئٹ اور ایڈمن پینل تک رسائی کے بارے میں معلومات ہوگی۔ </p>

                 <p> نیک خواہشات </p>

                 <p> سافٹ ٹیک بزنس سروسز </p>
                </div>
            </div>
        </div>
    </div>
</div>


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