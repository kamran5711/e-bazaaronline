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
    /* border-radius: 65px 0px 0px 65px; */
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
                                <select name="type" class="rounded-left pl-3" style="border: none;" id="">
                                    <option value="store">Store &nbsp;</option>
                                    <option value="product">Product &nbsp;</option>
                                </select>
                                <input type="text" name="search" class="btn-group1 search-box-top"
                                    placeholder="Your Favorite Products are a Click Away Search for" required  value="{{$search}}">
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
    </div>
</section>
<section class="main-block" style=" padding: 33px 0;" >
    <div class="container"  >
        <div class="row justify-content-center">
           <pre style="font-size:19px; color:black; font-family: Arial, sans-serif;">1.Beauty and Health Products    2.Mobile Phones   3.Computers and Laptops  4.Smart Watches</pre>
           <pre style="font-size:19px; color:black; font-family: Arial, sans-serif;"> 5.Clothing  6.Sports Products  7.Home Products   8.Books   9.Kids Toys and Game & Much More</pre>
             
          <div class="col-md-12">
                <div class="styled-heading">
                    <h3>Results for "{{ $search }}"</h3>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            @if($companies->count()>0)
            @foreach($companies as $value)
            <div class="col-md-3">
                <div class="card" style="height: 430px;">
                    <img width="100" height="250" class="card-img-top"
                        src="{{ asset('products/images/users/'.$value->image) }}?text=Image cap" alt="{{$value->name}}">
                    <div class="card-body" style="overflow: hidden;text-overflow: ellipsis;-webkit-line-clamp: 4;
                   display: -webkit-box;-webkit-box-orient: vertical;">
                        <h4 class="card-title text-primary " style="text-transform:uppercase">{{$value->name}}</h4>
                        @if($value->short_description)
                        <p class="card-text" style="height: 50px;"> {!! substr(strip_tags($value->short_description), 0,
                            70) !!}
                            ... </p>
                        @else
                        <p class="card-text">No description </p>
                        @endif
                        <a href="{{$value->domain}}" class="btn btn-primary form-control" target="_blank">Visit
                            Business </a>
                    </div>
                </div><br></br>
            </div>
            @endforeach
            @else
            <center>
                <div class="col-md-4">
                    <img class="card-img-top" src="https://xpertspak.com/images/sorry.jpeg" alt="No results found">
                            
                </div>
                <div class="col-md-8">
                <h5 class="card-title" style="text-transform:uppercase">No results found for "{{$search}}"</h5>
                    <p>Please Check Another Products - We are very sorry for inconvenience this may have caused.</p>
                    <!--- <button class="btn btn-primary" onclick="$('#search').focus();">Search Now</button>--->
                     <a href="{{url('/')}}" class="btn btn-primary" target="_blank">Search Now </a>
                </div>
            <center>
            @endif
        </div>
        <div>
            
            <h3 class="text-center" style=" margin-top: 100px;">A Convenient Place to Buy Your Products from Your Favourite Shop <br> Just Follow the Easy Steps<br>
                <div class="elementor-image">
                    <img width="61" height="4"
                        src="https://www.unitedsol.net/wp-content/uploads/2021/04/after-tittle.png"
                        class="attachment-large size-large" alt="after-tittle" loading="lazy">
                </div>
            </h3><br>
        </div>
        <div class="card-deck">
            <div class="card">
                <img class="card-img-top" height="150"
                    src="images/ebazar_search.png"
                    alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">Search a Shop or Bussiness</h5>
                    <p class="card-text">
                        On <a href="https://softechbusinessservices.com"> Ebazar </a> you can search any of your desired e-shop to buy your favorite products.</p>
                </div>
               
            </div>
            <div class="card">
                <img class="card-img-top"
                    src="images/ebazar_select.png"
                    height="150" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">Select Your Products or Services</h5>
                    <p class="card-text">
                        Selece your most favroite Products as many as you want to buy and these products will be add to your cart.</p>
                </div>
               
            </div>
            <div class="card">
                <img class="card-img-top"
                    src="images/ebazar_order.png"
                    height="150" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">Place Your Order</h5>
                    <p class="card-text">
                        After searching and selecting your product most you can order them easily on a single click.</p>
                </div>
               
            </div>
        </div>
    </div>
</section>
@endsection