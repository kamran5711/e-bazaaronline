@extends('frontend.layouts.master')
@section('title','E-SHOP || Register Page')
@section('page-title','Register Page')
@section('main-content')
<style>
         @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');
/* *{
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
  left: 0;
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
} */

</style>
<div class="containerr">
    <div class="title text-center">Register</div>
                    <p>Please register in order to checkout more quickly</p>
    <div class="content">
    <form class="form" method="post" action="{{route('registerCheckout.submit')}}">
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
            <span class="details">Re-Enter Email</span>
            <input type="email" name="email_confirmation" placeholder="Re-Enter Email" value="{{old('email_confirmation')}}">
            @error('email_confirmation')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
          <div class="input-box">
            <span class="details">Building Name / Number</span>
            <input type="text" placeholder="Building Name / Number" name="building" value="{{old('building')}}">
            @error('building')
            <span class="text-danger">{{$message}}</span>
            @enderror
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
            <span class="details">Area</span>
            <input type="text" name="area" placeholder="Area" value="{{old('area')}}">
            @error('area')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        
        <div class="input-box">
            <span class="details">City</span>
            <input type="text" name="city" placeholder="City" value="{{old('city')}}">
            @error('city')
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
            <input type="password" name="password" placeholder="Area" value="{{old('password')}}"
            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Password must contain at least 8 characters, including UPPER/lowercase and numbers."/>
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
