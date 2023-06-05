@extends('layouts.main')
@section('content')
    <style>
        .box-top:hover .heading-top {
            text-shadow: 2px 2px 9px #00000073;
        }

        .heading-top {
            color: whitesmoke !important;
            font-size: 55px;
            font-weight: 400;
            text-shadow: 2px 2px 9px #000000a3;
        }

        .sub-heading-top {
            color: white !important;
            text-shadow: 2px 2px 5px #2a2929;
            font-weight: 300;
        }

        .btn-top {
            border-radius: 0px 65px 65px 0px;
        }

        h3 {
            margin-left: 150px;
            font-size: 17px;
            margin-bottom: 0.5rem;
            font-weight: 300;
            line-height: 1.1;
            color: inherit;
            color: gray;
            /* font-family: Arial, sans-serif; */
        }

        h2 {
            font-size: 25px;
            margin-top: 20px;
            font-family: inherit;
            font-weight: 400;
            line-height: 1.1;
            color: inherit;
        }

        .box-top {

            border-radius: 82px;
            margin-top: 99px;
            padding: 1px 0px 1px 1px;
        }

        .btn-top {
            border-radius: 0px 10px 10px 0px;
        }

        .search-box-top {
            border-radius: 10px 0px 0px 10px;
            border: none;
        }

        .btn-form {
            background: #EE4540;
        }
        .btn-form:hover{
            background: #510A32;
        }
        p {
            font-size: 13px;
            height: 60px;
        }

        .copyright ul li a {
            color: white;
            font-size: 16px;
            padding: 0 10px;
            opacity: 0.6;
            -webkit-transition: 0.3s;
            -o-transition: 0.3s;
            transition: 0.3s;
        }

        .copyright p {
            font-size: 15px;
            font-weight: 400;
            color: #ccc;
            margin: 0;
        }

        .btn {
            background: #EE4540;
            border-color: #EE4540;
        }

        .btn:hover{
            background: #510A32;
            border-color: #510A32;
        }

        .dark-bg {
            background: #510A32;
          
        }

        @media screen and (max-width:425px) {

            .search-box-top,
            .btn-top {
                border-radius: 30px 30px 30px 30px !important;
            }

            .box-top {
                padding: 20px 7px 2px 9px;
                margin-bottom: 13px;
            }
        }

        .slider {
            height: 100vh;
            background-image: linear-gradient(to right bottom, rgba(255, 51, 51, 0.6), rgba(30, 108, 217, 0.6)), url('images/1.3.jpg');
            background-size: cover;
            background-position: top;
            position: relative;

        }

    </style>
    <section class="d-flex align-items-center">
    {{-- <section class="slider d-flex align-items-center"> --}}
        <div class="container-fluid ">
            <div class="row d-flex justify-content-center ">
                <div class="col-md-12 ">
                    <div class="slider-title_box">
                        {{-- <div class="row">
                            <div class="col-md-12">
                                <div class="slider-content_wrap box-top">
                                    <h1 class="heading-top">E-bazaar, A Marketplace for Your Online Presence</h1>
                                    <h5 class="sub-heading-top">No website No problem - Let The Good Times Begin</h5>

                                </div>
                            </div>
                        </div> --}}

                        <div class="row d-flex justify-content-center" style="margin-top:120px;">
                            <div class="col-md-7" id="bodyData">
                                <form class="form-wrap mt-4" action="">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <select name="type" class="rounded-left pl-3" id="">
                                            <option value="store" selected>Store &nbsp;</option>
                                            <option value="product">Product &nbsp;</option>
                                        </select>
                                        <input type="text" name="search" class="btn-group1 search-box-top border border-dark"
                                            placeholder="Type to search for any store..." required value="{{ request()->search }}">
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
    <section class="main-block" style=" padding: 33px 0;">
        <div class="container">
            {{-- <div class="row text-secondary mt-2 mb-4">
                <div class="col-md-3 col-sm-6 p-2">
                    Beauty and Health Products
                </div>
                <div class="col-md-3 col-sm-6 p-2">
                    Mobile Phones
                </div>
                <div class="col-md-3 col-sm-6 p-2">
                    Computers and Laptops
                </div>
                <div class="col-md-3 col-sm-6 p-2">
                    Smart Watches
                </div>
                <div class="col-md-3 col-sm-6 p-2">
                    Clothing
                </div>
                <div class="col-md-3 col-sm-6 p-2">
                    Sports Products
                </div>
                <div class="col-md-3 col-sm-6 p-2">
                    Home Products
                </div>
                <div class="col-md-3 col-sm-6 p-2">
                    Books
                </div>
                <div class="col-md-3 col-sm-6 p-2">
                    Kids Toys and Game & Much More
                </div>
            </div> --}}
            <div class="row">
                <div class="col-md-12">
                    @if ($companies->count() > 0)
                        @foreach ($companies as $value)
                            <div class="col-md-3">
                                <div class="card" style="height: 430px;">
                                    <img width="100" height="250" class="card-img-top" src="{{ asset('images/stores') . '/' . $value->image  }}"
                                        alt="{{ $value->name }}">
                                    <div class="card-body"
                                        style="overflow: hidden;text-overflow: ellipsis;-webkit-line-clamp: 4;
                                                                                        display: -webkit-box;-webkit-box-orient: vertical;">
                                        <h4 class="card-title text-primary " style="text-transform:uppercase;font-size:15px;">
                                            {{ $value->name }}</h4>
                                        @if ($value->short_description)
                                            <p class="card-text" style="height: 50px;">
                                                {!! Str::limit($value->short_description, 80, $end = '...') !!}</p>
                                        @else
                                            <p class="card-text">No description </p>
                                        @endif
                                        {{-- <a href="{{$value->domain}}" class="btn btn-primary form-control" target="_blank">Visit
                                Business </a> --}}
                                        <a href="{{ url('store') . '/' . $value->slug }}"
                                            class="btn btn-primary form-control btn">Visit
                                            Bussiness</a>

                                    </div>
                                </div><br>
                            </div>
                        @endforeach
                    {{-- @else
                        <div class="col-md-12">
                        <h2 class="text-warning text-center">There is no stores in database yet!</h2>
                        </div>
                    @endif --}}
                    @else
                            <div class="col-md-4">
                                <img class="card-img-top" src="https://xpertspak.com/images/sorry.jpeg"
                                    alt="No results found">

                            </div>
                            <div class="col-md-8">
                                <h5 class="card-title" style="text-transform:uppercase">No results found for
                                    "{{ $search }}"</h5>
                                <p>Please Check Another Store - We are very sorry for inconvenience this may have caused.</p>
                                <!--- <button class="btn btn-primary" onclick="$('#search').focus();">Search Now</button>--->
                                <a href="{{ url('/') }}" class="btn btn-primary" target="_blank">Search Now </a>
                            </div>
                    @endif
                </div>
            </div>

            @if ($categories->count() > 0)
                <div class="col-md-10" style="display: none;">
                    <div class="styled-heading">
                        <h3>Recently Searched Items</h3>
                    </div>
                </div>
                <div class="row" style="display: none;">
                    @foreach ($categories as $value)
                        <div class="col-2">
                            {{-- <a href="{{route('get.all.search',$value->id)}}" style="text-decoration: none;" target="_blank"> --}}
                            <p style="display:flex; justify-content:center; font-size:13px;">{{ $value->name }}</p>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
            {{-- <div>
                <h2 class="text-center" style=" margin-top: 70px;">A Convenient Place to Buy Your Products from Your
                    Favourite Shop <br> Just Follow the Easy Steps<br>
                    <div class="elementor-image">
                        <img width="61" height="4"
                            src="https://www.unitedsol.net/wp-content/uploads/2021/04/after-tittle.png"
                            class="attachment-large size-large" alt="after-tittle" loading="lazy">
                    </div>
                </h2><br />
            </div>
            <div class="card-deck">
                <div class="card">
                    <img class="card-img-top" height="150" src="images/ebazar_search.png" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Search a Shop or Business</h5>
                        <p class="card-text">
                            On <a href="https://softechbusinessservices.com"> Ebazar </a> you can search any of your desired
                            e-shop to buy your favorite products.</p>
                    </div>

                </div>
                <div class="card">
                    <img class="card-img-top" src="images/ebazar_select.png" height="150" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Select Your Products or Services</h5>
                        <p class="card-text">
                            Selece your most favroite Products as many as you want to buy and these products will be add to
                            your cart.</p>
                    </div>

                </div>
                <div class="card">
                    <img class="card-img-top" src="images/ebazar_order.png" height="150" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Place Your Order</h5>
                        <p class="card-text">
                            After searching and selecting your product most you can order them easily on a single click.</p>
                    </div>

                </div> --}}
            </div>
        </div>
    </section>
@endsection
