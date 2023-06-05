@extends('frontend.layouts.master')
@section('title','E-SHOP || Register Page')
@section('main-content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }
    .containerr {
        max-width: 1000px;
        margin-bottom: 3%;
        margin-top: 3%;
        margin-left: 10%;
        margin-right: 10%;
        width: 80%;
        background-color: whitesmoke;
        padding: 43px 30px;
        border-radius: 5px;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.15);
    }
    .containerr .title {
        font-size: 25px;
        font-weight: 500;
        position: relative;
    }
    .containerr .title::before {
        content: "";
        position: absolute;
        /* left: 0; */
        bottom: 0;
        height: 3px;
        width: 30px;
        border-radius: 5px;
        background: linear-gradient(135deg, #71b7e6, #9b59b6);
    }
    .content form .user-details {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        margin: 20px 0 12px 0;
    }
    form .user-details .input-box {
        margin-bottom: 15px;
        width: calc(100% / 2 - 20px);
    }
    form .input-box span.details {
        display: block;
        font-weight: 500;
        margin-bottom: 5px;
    }
    .user-details .input-box input {
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
    .user-details .input-box input:valid {
        border-color: #0000003d;
    }
    form .gender-details .gender-title {
        font-size: 20px;
        font-weight: 500;
    }
    form .category {
        display: flex;
        width: 80%;
        margin: 14px 0;
        justify-content: space-between;
    }
    form .category label {
        display: flex;
        align-items: center;
        cursor: pointer;
    }
    form .category label .dot {
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
    #dot-3:checked ~ .category label .three {
        background: #9b59b6;
        border-color: #d9d9d9;
    }
    form input[type="radio"] {
        display: none;
    }
    form .btnRegister {
        height: 45px;
        /* margin: 35px 0 */
    }
    form .btnRegister button {
        height: 100%;
        width: 100%;
        border-radius: 5px;
        border: none;
        color: white;
        font-size: 18px;
        font-weight: 300;
        letter-spacing: 1px;
        cursor: pointer;
        transition: all 0.3s ease;
        background: #757575;
        /* background: linear-gradient(135deg, #71b7e6, #9b59b6); */
    }
    form .button input:hover {
        /* transform: scale(0.99); */
        background: #fd7e14;
        /* background: linear-gradient(-135deg, #71b7e6, #9b59b6); */
    }
    /* .......... */
    form .button {
        height: 45px;
        /* margin: 35px 0 */
    }
    form .button input {
        height: 100%;
        width: 100%;
        border-radius: 5px;
        border: none;
        color: white;
        font-size: 18px;
        font-weight: 300;
        letter-spacing: 1px;
        cursor: pointer;
        transition: all 0.3s ease;
        background: #757575;
        /* background: linear-gradient(135deg, #71b7e6, #9b59b6); */
    }
    form .button input:hover {
        /* transform: scale(0.99); */
        background: #fd7e14;
        /* background: linear-gradient(-135deg, #71b7e6, #9b59b6); */
    }
    @media (max-width: 584px) {
        .container {
            max-width: 100%;
        }
        form .user-details .input-box {
            margin-bottom: 15px;
            width: 100%;
        }
        form .category {
            width: 100%;
        }
        .content form .user-details {
            max-height: 300px;
            overflow-y: scroll;
        }
        .user-details::-webkit-scrollbar {
            width: 5px;
        }
    }
    @media (max-width: 459px) {
        .container .content .category {
            flex-direction: column;
        }
    }
</style>
<div class="containerr">
    <div class="title text-center">Login</div>
    <div class="content">
        <form class="form" method="post" action="{{route('login.submit')}}">
            @csrf
            <div class="user-details">
                <div class="input-box col-md-6">
                    <span class="details">Email</span>
                    <input type="text" name="email" value="{{old('email')}}" placeholder="Enter email" autofocus="1">
                    @error('email')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="input-box col-md-6">
                    <span class="details">Password</span>
                    <input type="hidden" name="store_id" value="{{request()->get('k')}}">
                    <input type="password" name="password" placeholder="Enter password" value="{{old('password')}}">
                    @error('password')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="checkbox col-md-6">
                    <label class="checkbox-inline" for="2">
                        <input name="news" id="2" type="checkbox">Remember me</label>
                </div>
            </div>
            <div class="row" style="margin-left:15px;">
                <div class="button col-md-4" >
                    <input type="submit" value="Login">
                </div>
                <div class="button col-md-4">
                    <input type="button" value="Forgot Your Password?"
                           onclick="window.location.href='{{ route('forget.password.get') }}'">
                </div>
            </div>
        </form>
    </div>
</div>
</div>
@endsection
