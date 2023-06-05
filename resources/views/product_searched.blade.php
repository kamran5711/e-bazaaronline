@extends('layouts.main')
@section('content')

{{-- <link rel="stylesheet" href="{{asset('frontend/css/style.css')}}"> --}}
    <style>
        .search-box-top {
            margin-left:1px;
            border: none;
        }

        .btn-form {
            background: #EE4540;
        }
        .btn-form:hover{
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

        /* above style must be reduced  */

        .single-product .product-img a span.hot {
            background-color: #f63e1d;
            display: inline-block;
            font-size: 11px;
            color: rgb(255, 255, 255);
            right: 20px;
            top: 20px;
            padding: 1px 16px;
            font-weight: 700;
            border-radius: 0;
            text-align: center;
            position: absolute;
            text-transform: uppercase;
            border-radius: 30px;
            height: 26px;
            line-height: 25px;
        }
        .slide_heading {
            background: #00000059;
            text-shadow: 2px 2px 0px white;
            padding: 12px;
            width: fit-content;
        }

        div.carousel-caption p {
            /* background: #00000059; */
            color: white !important;
            text-shadow: 2px 2px 9px black;
            padding: 5px;
            width: fit-content;
            font-size: 22px !important;
        }

        

        .single-product .product-img {
            min-height: 255px;
        }


        #img_set {
            background-attachment: cover;
            margin-bottom: -100px;
        }

        #size_set {
            background-attachment: cover;
            height: 350px;

        }

        .siz_img {
            height: 265px;
        }
        .single-product .product-content .product-price span {
            font-size: 15px;
            font-weight: 500;
            color: #EE4540;
            margin-left: 20px;
        }

        label {
            display: inline-block;
            margin-bottom: 0.5rem;
            background: transparent;
            color: #510A32;
            margin-left: 20px;
        }

        .nice-select{
            font-size: 11px;
            border-color: #510A32;
        }


        .single-product .product-content h3 a {
            font-size: 14px;
            font-weight: 500;
            color: gray;
            margin-left: 20px;
        }

        .btn-warning{
            background-color: #510A32;
            color: white;
            border-color:#510A32;
        }

        .btn-warning:hover{
            background-color: #EE4540;
            border-color:#EE4540;
        }

        .single-product {
            margin-top: 10px;
        }

        .single-product .button-head {
            background: #fff;
            display: inline-block;
            height: 40px;
            /* width: 100px;
            bottom: -50px; */
            width: 100%;
            bottom: 0px;
            position: absolute;
            left: 20px;
            z-index: 9;
            height: 50px;
            line-height: 50px;
            -webkit-transition: all 0.4s ease;
            -moz-transition: all 0.4s ease;
            transition: all 0.4s ease;
        }


        .single-product .product-img {
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        #size_set {
            background-attachment: cover;
            height: 283px;
            /* margin-bottom: -100px; */
        }

        .single-product .product-img a img {
            width: 100%;
            padding: 20px;
        }

        .single-product .product-img a span.price-dec {
            background-color: #EE4540;
		
            display: inline-block;
            font-size: 11px;
            color: #fff;
            right: 86px;
            top: 21px;
            padding: 1px 16px;
            font-weight: 700;
            border-radius: 0;
            text-align: center;
            position: absolute;
            text-transform: uppercase;
            border-radius: 30px;
            height: 26px;
            line-height: 25px;
        }

        .single-product .product-content {
            margin-top: -29px;
        }

        .shop-blog .shop-single-blog .content {
            padding: 0;

        }

        .single-product .product-img .product-action a span{
            background: #EE4540 !important;
            color: #fff !important;
        }


        .p-card {      
               margin-right: 0px;
                margin-top: 20px;
                border-radius: 5px;
                border: 1px solid lightgrey;

            }

            
        .card-shadow {
            box-shadow: -1px 2px 5px 1px  hsl(0, 0%, 70%);
            -webkit-box-shadow: -1px 2px 5px 1px  hsl(0, 0%, 70%);
            -moz-box-shadow: -1px 2px 5px 1px  hsl(0, 0%, 70%);
            background-color: white; 
            height: 421px;
        }
        .discount-wrapper {
            background: rgb(134, 163, 207);
            color: white !important;
            border-radius: 3px;
            padding: 2px 15px!important;
            margin-right: 15px;
            font-size: 10px !important;
            font-style: italic;
            font-weight: 400 !important;
            line-height: 15px;
            margin-top: 2px;
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
                                            <option value="store">Store &nbsp;</option>
                                            <option value="product" selected>Product &nbsp;</option>
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
    <section class="main-block">
        <div class="container">
            <div class="row mb-5">
                <!-- Start Single Tab -->
                @if ($products)
                    @foreach ($products as $key => $product)
                    @php $product_list = $product; $product = $product->first(); $found_products = $product_list->count(); @endphp
                    <div class="col-sm-6 col-xs-12 col-md-4 col-lg-4 mb-3 mt-3 product_{{ $product->id }} .category__{{ $product->category_id }}">
                        <form
                            action="{{ URL( $product->store->slug . '/' . 'product-searched') }}" method="POST" id="form_{{$product->id}}">
                            {{ csrf_field() }}
                            <div class="card">
                                <img class="card-img-top" src="{{ asset('images/stores/' . $product->store->image) }}" alt="Card image cap">
                                <div class="card-body">
                                    <h6 class="card-title text-info">
                                        {{(strlen($product->store->name) > 30 )?substr($product->store->name, 0, 30).'...':$product->store->name }} 
                                        <span style="font-size:10px;">{{" found " . $found_products . " products"}}</span>
                                    </h6>
                                    <p class="card-text">{{ (strlen($product->store->short_description) > 120 )?substr($product->store->short_description, 0, 120).'...':$product->store->short_description }}</p>
                                </div>
                                <ul class="list-group list-group-flush">
                                  <li class="list-group-item font-weight-bold">{{ $product->title }}</li>
                                  <li class="list-group-item">
                                    @php
                                            $after_discount = $product->price - ($product->price * $product->discount) / 100;
                                        @endphp
                                        Price: <span class="{{ ($after_discount < $product->price || !$after_discount == $product->price ) ? 'text-success' : 'text-dark' }}">{{ number_format($after_discount, 2) }}</span>
                                        @if ($after_discount < $product->price || !$after_discount == $product->price)
                                            <del class="text-danger pl-2">{{ number_format($product->price, 2) }}</del>
                                        @endif
                                        @if ($product->discount)
                                            <span class="float-right discount-wrapper">{{ $product->discount }}% off</span>
                                        @endif
                                  </li>

                                    @php
                                        $color_title = $size_title = null;
                                        if($product->productStock->count() > 0){
                                            $color_title = optional(@$product->productStock[0])->color->title;
                                            $size_title = optional(@$product->productStock[0])->size->title;
                                        }
                                    @endphp
                                    @if($size_title)
                                        @php
                                            $sizes = $product->productStock->groupBy('size_id');
                                        @endphp
                                        <li class="list-group-item">
                                            <input type="hidden" value="{{ $product->id }}" name="product_id" />
                                            <input type="hidden" name="store_id" value="{{ $product->store_id }}" />
                                            <input type="hidden" name="last_slug" value="{{ $product->store->slug }}">
                                            @foreach ($product_list as $p_l)
                                                <input type="hidden" name="product_ids[]" value="{{ $p_l->id }}" />
                                            @endforeach
                                            <label class="ml-0">Sizes :</label>
                                            <select name="size_id" class="float-right p-2" >
                                                @foreach ($sizes as $ps)
                                                    <option value="{{ $ps[0]->size->id }}">
                                                        {{ $ps[0]->size->title }} </option>
                                                @endforeach
                                            </select>
                                        </li>
                                    @endif

                                    @if($color_title)
                                        @php
                                            $colors = $product->productStock->groupBy('color_id');
                                        @endphp
                                        <li class="list-group-item">
                                            <label class="ml-0">Variations :</label>
                                            <select name='choice_id' class="float-right p-2" >
                                                @foreach ($colors as $ps)
                                                    <option value="{{ $ps[0]->color->id }}">
                                                        {{ $ps[0]->color->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </li>
                                    @endif
                                </ul>
                                <div class="card-body text-center">
                                  <a href="javascript:void(0);" class="card-link" onclick="document.getElementById('form_{{$product->id}}').submit();">Visit shop and view related products</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    @endforeach
                    <!--/ End Single Tab -->
                @endif
        </div>

            {{-- @if ($categories->count() > 0)
                <div class="col-md-10" style="display: none;">
                    <div class="styled-heading">
                        <h3>Recently Searched Items</h3>
                    </div>
                </div>
                <div class="row" style="display: none;">
                    @foreach ($categories as $value)
                        <div class="col-2"> --}}
                            {{-- <a href="{{route('get.all.search',$value->id)}}" style="text-decoration: none;" target="_blank"> --}}
                            {{-- <p style="display:flex; justify-content:center; font-size:13px;">{{ $value->name }}</p>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif --}}
            </div>
        </div>
    </section>
@endsection
