@extends('layouts.main')
@section('content')
<style>
.box-top{
    box-shadow: 1px 4px 7px 1px #00000091;
    background: #00000038;
    border-radius: 82px; 
    margin-top: 99px;
     padding: 1px 0px 1px 1px; 
}
.box-top:hover{
    box-shadow: 1px 4px 7px 1px #ff3a6d91;
    background: #ffffff85;
}
.box-top:hover .sub-heading-top{
    color: #000 !important;
    text-shadow: 2px 2px 5px #7c6565;
}
.box-top:hover .heading-top{
    text-shadow: 2px 2px 9px #00000073;
}
.heading-top{
    color: #ff3a6d;
    font-size: 55px;
    font-weight: 600;
    text-shadow: 2px 2px 9px #000000a3;
}
.sub-heading-top{
    color: #ffffff !important;
    text-shadow: 2px 2px 5px #2a2929;
    font-weight: 300;
}
.sub-heading{
    margin-left: 479px;
    color:  #ff3a6d; !important;
    text-shadow: 2px 2px 5px #2a2929;
    font-weight: 300;
}
.search-box-top{
    border-radius: 65px 0px 0px 65px;
    border: 1px solid #ff3a6d;
}
.btn-top{
    border-radius: 0px 65px 65px 0px;
}
@media screen and (max-width:425px){
    .search-box-top,.btn-top{
        border-radius: 65px 65px 65px 65px !important;
    }
    .box-top{
        padding: 20px 7px 2px 9px;
        margin-bottom: 13px;
    }
}
.slider { 
  background: url('../images/6.png') no-repeat;
  background-size: cover;
 min-height: 600px;
  }
</style>


<section class="slider d-flex align-items-center" >
    <div class="container-fluid ">
        <div class="row d-flex justify-content-center ">
            <div class="col-md-12 " >
                <div class="slider-title_box">
                    <div class="row">
                <div class="col-md-12"> 
                            <div class="slider-content_wrap box-top">
                                <h1 class="heading-top">E-bazar, A Portal for Your Online Presence</h1>
                                <h5 class="sub-heading-top">No website No problem - Let The Good Times Begin</h5>
                            
                            </div>
                        </div>
                    </div>
                  
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-10" id="bodyData">
                            <form class="form-wrap mt-4" action="">
                            
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <input type="text" name="search" class="btn-group1 search-box-top"
                                        placeholder=" Your Favorite Products are a Click Away Search for" required>
                                    <button type="submit" class="btn-form btn-top"><span
                                        class="icon-magnifier search-icon"></span>SEARCH<i
                                        class="pe-7s-angle-right"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<section class="main-block">
    <div class="container">
        <div class="row justify-content-center">
          <pre style="font-size:19px; color:black; font-family: Arial, sans-serif;">1.Beauty and Health Products    2.Mobile Phones   3.Computers and Laptops  4.Smart Watches</pre>
          <pre style="font-size:19px; color:black; font-family: Arial, sans-serif;"> 5.Clothing  6.Sports Products  7.Home Products   8.Books   9.Kids Toys and Game & Much More</pre>
                       
            <div class="col-md-5">
                <div class="styled-heading">
                    <h3>Search Bussiness</h3>
                </div>
            </div>
        </div>
        <div class="row">
            @if($searchShops->count()>0)
            @foreach($searchShops as $value)
            <div class="col-md-3">
                <div class="card" style="height: 430px;">
                    <img width="100" height="250" class="card-img-top"
                        src="{{ asset('products/images/users/'.$value->image) }}?text=Image cap" alt="{{$value->name}}">
                    <div class="card-body" style="overflow: hidden;text-overflow: ellipsis;-webkit-line-clamp: 4;
                   display: -webkit-box;-webkit-box-orient: vertical;">
                        <h4 class="card-title text-primary " style="text-transform:uppercase">{{$value->name}}</h4>
                        @if($value->short_description)
                        <p class="card-text" style="height: 50px;"> {{Str::limit($value->short_description, 80, $end='...')}}</p>
                        @else
                        <p class="card-text">No description </p>
                        @endif
                        <a href="{{$value->domain}}" class="btn btn-primary form-control" target="_blank">Visit
                            Bussiness </a>
                    </div>
                </div><br><br>
            <div class="text-right">{{ $searchShops->links() }}</div>
            </div>
            @endforeach
            @else
            <div class="col-md-4">
                <div class="card">
                    <img width="100" height="150" class="card-img-top"
                        src="{{ asset('products/images/users/not_found.jpg') }}?text=Image cap" alt="">
                    <div class="card-body" style="overflow: hidden;text-overflow: ellipsis;-webkit-line-clamp: 4;
                   display: -webkit-box;-webkit-box-orient: vertical;">
                        <h4 class="card-title text-primary " style="text-transform:uppercase"></h4>
                        <a href="https://imrans13.sg-host.com" class="btn btn-primary" target="_blank">Visit Bussiness
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>

       
    </div>
</section>
@endsection