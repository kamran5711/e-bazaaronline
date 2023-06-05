@extends('frontend.layouts.master')
{{-- @section('title', 'E-BAZAARONLINE || HOME PAGE') --}}
@section('main-content')
    <style>
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
            /* padding: 0; */

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
    <!-- Slider Area -->
    <section class="hero-slider" style="height: 0px;">
        <!-- Single Slider -->
        <!--/ End Single Slider -->

    </section>
    @if ($banners->count() > 0)
        <section id="Gslider" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                @foreach ($banners as $key => $banner)
                    <li data-target="#Gslider" data-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}">
                    </li>
                @endforeach
            </ol>
            <div class="carousel-inner" role="listbox">
                @foreach ($banners as $key => $banner)
                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                        <img class="images-slide "  src="{{ asset('products/images/banners/' . $banner->photo) }}"
                            alt="{{ $banner->title }}">
                        <div class="carousel-caption d-none d-md-block text-left">
                            @if($banner->title != "")
                                <h1 class="text-capitalize">{{ $banner->title }}</h1>
                            @endif
                            @if($banner->description != "")
                                <p>{{ $banner->description }}</p>
                            @endif
                            
                            <a class="btn btn-lg ws-btn wow fadeInUpBig slide_button"
                                href="{{ route('product-grids', $last_slug) }}" role="button">Shop Now<i
                                    class="far fa-arrow-alt-circle-right"></i></i></a>
                        </div>
                    </div>
                @endforeach
            </div>
            {{-- <a class="carousel-control-prev" href="#Gslider" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#Gslider" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a> --}}
        </section>
    @endif


    <!--/ End Slider Area -->
    <!-- Start Product Area -->
    <div class="product-area">
        <div class="container mb-5">
            <div class="row mt-5">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Trending Items</h2>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="product-info">
                            <div class="nav-main mb-3">
                                @php
                                    $all_new_products = $new_products;
                                    $categories = $new_products->groupBy('category_id');
                                    $new_products = $categories;
                                @endphp
                                {{-- <ul class="nav nav-pills" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="pill" href="#tab_all_products">All Products</a>
                                    </li>
                                    @foreach ($categories as $item)
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="pill" href="#tab_{{ $item->first()->category_id }}">{{ $item->first()->category->title }}</a>
                                        </li>
                                    @endforeach
                                </ul> --}}
                                <style>
                                    .btn:hover, .btn.active {
                                        background:#F7941D !important; color:rgb(255, 255, 255)!important;
                                    }
                                    .btn {
                                        background: none !important; color:black;
                                    }
                                </style>
                                <ul class="nav nav-tabs filter-tope-group" role="tablist">
                                    <li class="nav-item">
                                        <button class="btn active" data-toggle="pill" href="#tab_all_products">All Products</button>
                                    </li>
                                    @foreach ($categories as $item)
                                        <li class="nav-item">
                                            <button class="btn" data-toggle="pill" href="#tab_{{ $item->first()->category_id }}">{{ $item->first()->category->title }}</button>
                                        </li>
                                    @endforeach
                                </ul>


                                <!-- Tab Nav -->
                                {{-- <ul class="nav nav-tabs filter-tope-group" id="myTab" role="tablist">
                                    @if ($categories)
                                        <button class="btn" style="background:#F7941D;; color:black;"
                                            data-filter="*">
                                            All Products
                                        </button>
                                        @foreach ($categories as $key => $cat)
                                            @if (count($cat->products) > 0)
                                                <button class="btn" style="background:none;color:black;"
                                                    data-filter="category__{{ $cat->id }}">
                                                    {{ $cat->title }}
    
                                                </button>
                                            @endif
                                        @endforeach
                                    @endif
                                </ul> --}}
                                <!--/ End Tab Nav -->

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab panes -->
                <div class="tab-content">
                    <!-- Start Single Tab -->
                    @foreach ($categories as $new_products) 
                        <div id="tab_{{ $new_products->first()->category_id }}" class="tab-pane">
                            <div class="row">
                                @foreach ($new_products as $key => $product)
                                    <div class="col-sm-6 col-xs-12 col-md-3 mt-3 product_{{ $product->id }} .category__{{ $product->category_id }}">
                                        <div class="card-shadow">
                                            <form action="{{ route('add-to-cart-ajax') }}" method="POST" onsubmit="return addToCartAjax('{{ $product->id }}')" id="form_{{ $product->id }}">
                                                {{ csrf_field() }}
                                                <div class="single-product">
                                                    <input type="hidden" name="store_id" value="{{ $product->store_id }}" />
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}" />                        
                                                    <div class="product-img">
                                                        <div>
                                                            <a
                                                                href="{{ URL($last_slug.'/product-detail', $product->slug) }}">
                                                                <img class="img img-responsive"
                                                                    src="{{ asset('images/products/' . $product->photo) }}"
                                                                    alt="{{ $product->photo }} image">                        
                                                                {{-- <img class="hover-img" src="{{ asset('images/products/' . $photo[0]) }}" alt="{{ $photo[0] }} image"> --}}
                                                                @if ($product->productStock->count() <= 0)
                                                                    <span class="m-1 out-of-stock">Sold Out</span>
                                                                @elseif($product->condition == 'new')
                                                                    <span class="m-1 new">New</span>
                                                                @elseif($product->condition == 'hot')
                                                                    <span class="m-1 hot">Hot</span>
                                                                @else
                                                                    <span class="m-1 price-dec">{{ $product->discount }}%
                                                                        Off</span>
                                                                @endif
                                                            </a> 
                                                        </div>
                                                        <div class="button-head">
                                                            <div class="product-action mr-5">
                                                                {{-- <a data-toggle="modal" data-target="#{{ $product->id }}"
                                                                    title="Quick View" href="#"><i
                                                                        class=" ti-eye"></i><span>Quick
                                                                        Shop</span></a>
                                                                <a title="Wishlist"
                                                                    href="{{ route('add-to-wishlist', '$product->slug') }}?k={{ request()->get('k') }}"
                                                                    class="wishlist" data-id="{{ $product->id }}"><i
                                                                        class=" ti-heart "></i><span>Add to
                                                                        Wishlist</span></a> --}}
                                                            </div>
                                                            <div class="product-action-2" style="bottom:15px">
                                                                <button type="submit" name="btn_add_to_cart"
                                                                    class="btn-warning btn-sm min" title="Add to cart" id="cartBtn_{{ $product->id }}">Add to
                                                                    cart</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div>&nbsp;</div>
                                                    <div class="product-content">
                                                        <h3 class="mr-5"><a title="{{ $product->title }}" href="{{ URL($last_slug . '/' . 'product-detail' . '/' . $product->slug) }}">{{ ( strlen($product->title) > 30 ) ? substr($product->title, 0, 30) . '...' : $product->title }}</a>
                                                        </h3>
                                                        <div class="product-price">
                                                            @php
                                                                $after_discount = $product->price - ($product->price * $product->discount) / 100;
                                                            @endphp
                                                            <span class="{{ ($after_discount < $product->price || !$after_discount == $product->price ) ? 'text-success' : 'text-dark' }}">{{ number_format($after_discount, 2) }}</span>
                                                            @if ($after_discount < $product->price || !$after_discount == $product->price)
                                                                <del class="text-danger pl-2">{{ number_format($product->price, 2) }}</del>
                                                            @endif
                                                            @if ($product->discount)
                                                                <span class="float-right discount-wrapper">{{ $product->discount }}% off</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <table>
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
                                                    <tr>
                                                        <td>
                                                            <label>Sizes :</label>
                                                        </td>
                                                        <td>
                                                            <select name="size_id" class="pull-right"
                                                                style="display: none;">
                                                                @foreach ($sizes as $ps)
                                                                    <option value="{{ $ps[0]->size->id }}">
                                                                        {{ $ps[0]->size->title }} </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    @endif
                                                    @if($color_title)
                                                    @php
                                                        $colors = $product->productStock->groupBy('color_id');
                                                    @endphp
                                                    <tr>
                                                        <td>
                                                            <label>Variations :</label>
                                                        </td>
                                                        <td>
                                                            <select name='choice_id' class="pull-right"
                                                                style="display: none;">
                                                                @foreach ($colors as $ps)
                                                                    <option value="{{ $ps[0]->color->id }}">
                                                                        {{ $ps[0]->color->title }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    @endif
                                                </table>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                    {{-- all products pane  --}}
                    <div id="tab_all_products" class="tab-pane active">
                        <div class="row">
                            @foreach ($all_new_products as $key => $product)
                                <div class="col-sm-6 col-xs-12 col-md-3 mt-3 product_{{ $product->id }} .category__{{ $product->category_id }}">
                                    <div class="card-shadow">
                                        <form action="{{ route('add-to-cart-ajax') }}" method="POST" onsubmit="return addToCartAjax('{{ $product->id }}')" id="form_{{ $product->id }}">
                                            {{ csrf_field() }}
                                            <div class="single-product">
                                                <input type="hidden" name="store_id" value="{{ $product->store_id }}" />
                                                <input type="hidden" name="product_id" value="{{ $product->id }}" />                        
                                                <div class="product-img">
                                                    <div>
                                                        <a
                                                            href="{{ URL($last_slug.'/product-detail', $product->slug) }}">
                                                            <img class="img img-responsive"
                                                                src="{{ asset('images/products/' . $product->photo) }}"
                                                                alt="{{ $product->photo }} image">                        
                                                            {{-- <img class="hover-img" src="{{ asset('images/products/' . $photo[0]) }}" alt="{{ $photo[0] }} image"> --}}
                                                            @if ($product->productStock->count() <= 0)
                                                                <span class="m-1 out-of-stock">Sold Out</span>
                                                            @elseif($product->condition == 'new')
                                                                <span class="m-1 new">New</span>
                                                            @elseif($product->condition == 'hot')
                                                                <span class="m-1 hot">Hot</span>
                                                            @else
                                                                <span class="m-1 price-dec">{{ $product->discount }}%
                                                                    Off</span>
                                                            @endif
                                                        </a> 
                                                    </div>
                                                    <div class="button-head">
                                                        <div class="product-action mr-5">
                                                            {{-- <a data-toggle="modal" data-target="#{{ $product->id }}"
                                                                title="Quick View" href="#"><i
                                                                    class=" ti-eye"></i><span>Quick
                                                                    Shop</span></a>
                                                            <a title="Wishlist"
                                                                href="{{ route('add-to-wishlist', '$product->slug') }}?k={{ request()->get('k') }}"
                                                                class="wishlist" data-id="{{ $product->id }}"><i
                                                                    class=" ti-heart "></i><span>Add to
                                                                    Wishlist</span></a> --}}
                                                        </div>
                                                        <div class="product-action-2" style="bottom:15px">
                                                            <button type="submit" name="btn_add_to_cart"
                                                                class="btn-warning btn-sm min" title="Add to cart" id="cartBtn_{{ $product->id }}">Add to
                                                                cart</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>&nbsp;</div>
                                                <div class="product-content">
                                                    <h3 class="mr-5"><a title="{{ $product->title }}" href="{{ URL($last_slug . '/' . 'product-detail' . '/' . $product->slug) }}">{{ ( strlen($product->title) > 30 ) ? substr($product->title, 0, 30) . '...' : $product->title }}</a>
                                                    </h3>
                                                    <div class="product-price">
                                                        @php
                                                            $after_discount = $product->price - ($product->price * $product->discount) / 100;
                                                        @endphp
                                                        <span class="{{ ($after_discount < $product->price || !$after_discount == $product->price ) ? 'text-success' : 'text-dark' }}">{{ number_format($after_discount, 2) }}</span>
                                                        @if ($after_discount < $product->price || !$after_discount == $product->price)
                                                            <del class="text-danger pl-2">{{ number_format($product->price, 2) }}</del>
                                                        @endif
                                                        @if ($product->discount)
                                                            <span class="float-right discount-wrapper">{{ $product->discount }}% off</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <table>
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
                                                <tr>
                                                    <td>
                                                        <label>Sizes :</label>
                                                    </td>
                                                    <td>
                                                        <select name="size_id" class="pull-right"
                                                            style="display: none;">
                                                            @foreach ($sizes as $ps)
                                                                <option value="{{ $ps[0]->size->id }}">
                                                                    {{ $ps[0]->size->title }} </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                                @endif
                                                @if($color_title)
                                                @php
                                                    $colors = $product->productStock->groupBy('color_id');
                                                @endphp
                                                <tr>
                                                    <td>
                                                        <label>Variations :</label>
                                                    </td>
                                                    <td>
                                                        <select name='choice_id' class="pull-right"
                                                            style="display: none;">
                                                            @foreach ($colors as $ps)
                                                                <option value="{{ $ps[0]->color->id }}">
                                                                    {{ $ps[0]->color->title }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                                @endif
                                            </table>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    {{-- all products pane end  --}}
                </div>
                <!--/ End Single Tab -->
            </div>
        </div>
    </div>
    <!-- End Product Area -->

    <!-- End Midium Banner -->
    <!-- Start Most Popular -->
    <div class="product-area most-popular section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Hot Items</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="owl-carousel popular-slider">
                        @foreach ($hot_products as $product)
                            <div class="card-shadow m-3">
                                <form action="{{ route('add-to-cart-ajax') }}" method="POST" onsubmit="return addToCartAjax('{{ $product->id }}_hot')" id="form_{{ $product->id }}_hot">
                                        {{ csrf_field() }}
                                    <div class="single-product">
                                        <input type="hidden" name="store_id" value="{{ $product->store_id }}" />
                                        <input type="hidden" name="product_id" value="{{ $product->id }}" />
                                        <div class="product-img ">
                                            <div style="margin-bottom:-100px;">
                                                <a href="{{ URL($last_slug . '/' . 'product-detail' . '/' . $product->slug) }}">
                                                    <img class="img img-responsive"
                                                        src="{{ asset('images/products/' . $product->photo) }}"
                                                        alt="{{ $product->photo }} image" />
                                                    @if ($product->productStock->count() <= 0)
                                                    <span class="m-1 out-of-stock">Sold Out</span>
                                                    @else
                                                    <span class="m-1 out-of-stock">Hot</span>
                                                    @endif
                                                </a>
                                            </div>
                                            <div class="button-head">
                                                <div class="product-action">
                                                    {{-- <a data-toggle="modal" data-target="#{{ $product->id }}"
                                                        title="Quick View" href="#"><i
                                                            class=" ti-eye"></i><span>Quick Shop</span></a>
                                                    <a title="Wishlist"
                                                        href="{{ route('add-to-wishlist', $product->slug) }}"><i
                                                            class=" ti-heart "></i><span>Add to Wishlist</span></a> --}}
                                                </div>
                                                <div class="product-action-2" style="bottom:15px">
                                                    <button type="submit" name="btn_add_to_cart"
                                                        class="btn-warning btn-sm min" title="Add to cart" id="cartBtn_{{ $product->id }}_hot">Add to
                                                        cart</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-content pt-4 pb-1">
                                            <div class="product-price">
                                                <h3 class="mr-5"><a title="{{ $product->title }}" href="{{ URL($last_slug . '/' . 'product-detail' . '/' . $product->slug) }}">{{ ( strlen($product->title) > 30 ) ? substr($product->title, 0, 30) . '...' : $product->title }}</a>
                                                </h3>
                                                @php
                                                    $after_discount = $product->price - ($product->price * $product->discount) / 100;
                                                @endphp
                                                <span class="{{ ($after_discount < $product->price || !$after_discount == $product->price ) ? 'text-success' : 'text-dark' }}">{{ number_format($after_discount, 2) }}</span>
                                                @if ($after_discount < $product->price || !$after_discount == $product->price)
                                                    <del class="text-danger pl-2">{{ number_format($product->price, 2) }}</del>
                                                @endif
                                                @if ($product->discount)
                                                    <span class="float-right discount-wrapper">{{ $product->discount }}% off</span>
                                                @endif
                                            </div>
                                        <table>
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
                                                <tr>
                                                    <td>
                                                        <label>Sizes :</label>
                                                    </td>
                                                    <td>
                                                        <select name="size_id" class="pull-right"
                                                            style="display: none;">
                                                            @foreach ($sizes as $ps)
                                                                <option value="{{ $ps[0]->size->id }}">
                                                                    {{ $ps[0]->size->title }} </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                            @endif
                                            @if($color_title)
                                                @php
                                                    $colors = $product->productStock->groupBy('color_id');
                                                @endphp
                                                <tr>
                                                    <td>
                                                        <label>Variations :</label>
                                                    </td>
                                                    <td>
                                                        <select name='choice_id' class="pull-right"
                                                            style="display: none;">
                                                            @foreach ($colors as $ps)
                                                                <option value="{{ $ps[0]->color->id }}">
                                                                    {{ $ps[0]->color->title }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                            @endif
                                        </table>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    <!-- End Most Popular Area -->



    	<!-- Start Shop Blog  -->
	<section class="shop-blog section mt-5">
		<div class="container">
			<div class="row mb-3">
				<div class="col-12">
					<div class="section-title">
						<h2>From Our Blog</h2>
					</div>
				</div>
			</div>
			<div class="row">
                @if ($posts)
                    @foreach ($posts as $post)
                        <div class="col-md-3 col-12 mb-5">
                            <!-- Start Single Blog  -->
                            <div class="shop-single-blog">
                                <img src="{{ asset('images/posts/' . $post->photo) }}"
                                    alt="{{ $post->photo }}">
                                <div class="content">
                                    <p class="date">{{ $post->created_at->format('d M , Y. D') }}</p>
                                    <a href="{{ route('blog.detail', ['post_slug' => $post->slug, 'slug' => $last_slug]) }}" class="title">{{ Str::limit($post->title, 70, $end = '...') }}</a>
                                    <a href="{{ route('blog.detail', ['post_slug' => $post->slug, 'slug' => $last_slug]) }}" class="more-btn text-warning">Continue Reading</a>
                                </div>
                            </div>
                            <!-- End Single Blog  -->
                        </div>
                    @endforeach
                @endif
			</div>
		</div>
	</section>
    <!-- End Shop Blog  -->
    <!-- Start Shop Services Area -->
    <section class="shop-services section home mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-rocket"></i>
                        <h4>Free shiping</h4>
                        <p> Dlivery Charges To Be Advised</p>
                    </div>
                    <!-- End Single Service -->
                </div>
                <div class="col-md-3 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-reload"></i>
                        <h4>Free Return</h4>
                        <p>Within 30 days returns</p>
                    </div>
                    <!-- End Single Service -->
                </div>
                <div class="col-md-3 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-lock"></i>
                        <h4>Secure Payment</h4>
                        <p>100% secure payment</p>
                    </div>
                    <!-- End Single Service -->
                </div>
                <div class="col-md-3 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-tag"></i>
                        <h4>Best Peice</h4>
                        <p>Guaranteed price</p>
                    </div>
                    <!-- End Single Service -->
                </div>
            </div>
        </div>
    </section>
    <!-- End Shop Services Area -->
    @include('frontend.layouts.newsletter')
    <!-- Modal -->
    @if ($new_products)
        @foreach ($new_products as $key => $product)
            <div class="modal fade" id="{{ $product->id }}" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    class="ti-close" aria-hidden="true"></span></button>
                        </div>
                        <form action="{{ route('add-to-cart', $product->id) }}" method="POST" class="mt-4">
                            {{ csrf_field() }}
                            <div class="modal-body">
                                <div class="row no-gutters">
                                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                        <!-- Product Slider -->
                                        <div class="product-gallery">
                                            <div class="quickview-slider-active" height="100%">
                                                @php
                                                    $photo = explode(',', $product->photo);
                                                    // dd($photo);
                                                @endphp
                                                @foreach ($photo as $data)
                                                    <div class="single-slider">
                                                        <img src="{{ asset('images/products/' . $data) }}"
                                                            alt="{{ $data }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <!-- End Product slider -->
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                        <div class="quickview-content">
                                            <h2>{{ $product->title }}</h2>
                                            <div class="quickview-ratting-review">
                                                <div class="quickview-ratting-wrap">
                                                    <div class="quickview-ratting">
                                                        @php
                                                            $rate = DB::table('product_reviews')
                                                                ->where('product_id', $product->id)
                                                                ->avg('rate');
                                                            $rate_count = DB::table('product_reviews')
                                                                ->where('product_id', $product->id)
                                                                ->count();
                                                        @endphp
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            @if ($rate >= $i)
                                                                <i class="yellow fa fa-star"></i>
                                                            @else
                                                                <i class="fa fa-star"></i>
                                                            @endif
                                                        @endfor
                                                    </div>
                                                    <a href="#"> ({{ $rate_count }} customer review)</a>
                                                </div>
                                                <div class="quickview-stock">
                                                    @if ($product->stock > 0)
                                                        <span><i class="fa fa-check-circle-o"></i> {{ $product->stock }}
                                                            in stock</span>
                                                    @else
                                                        <span><i class="fa fa-times-circle-o text-danger"></i>
                                                            {{ $product->stock }} out
                                                            stock</span>
                                                    @endif
                                                </div>
                                            </div>
                                            @php
                                                $after_discount = $product->price - ($product->price * $product->discount) / 100;
                                            @endphp
                                            <h3><small><del
                                                        class="text-muted">{{ number_format($product->price, 2) }}</del></small>
                                                {{ number_format($after_discount, 2) }} </h3>
                                            <div class="quickview-peragraph">
                                                <p>{!! html_entity_decode($product->summary) !!}</p>
                                            </div>
                                            <input type="hidden" value="{{ $product->id }}" name="product_id" />
                                            @if ($product->size_option == 1)
                                                @php
                                                    $sizes = DB::table('sizes')
                                                        ->where('product_id', $product->id)
                                                        ->where('deleted_flag', 0)
                                                        ->get();
                                                    if ($sizes) {
                                                        $sizes = $sizes;
                                                    } else {
                                                        $sizes = null;
                                                    }
                                                @endphp
                                                <div class="size">
                                                    <div class="row">
                                                        <div class="col-lg-6 col-12">
                                                            <h5 class="title">Size</h5>
                                                            <select name="size_id">
                                                                @foreach ($sizes as $size)
                                                                    <option value="{{ $size->id }}">
                                                                        {{ $size->title }} </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    @else
                                                        <input type="hidden" value="0" name="size_id" />
                                            @endif
                                            @if ($product->choice_option == 1)
                                                @php
                                                    $choices = null;
                                                    $choices = DB::table('choices')
                                                        ->where('product_id', $product->id)
                                                        ->where('deleted_flag', 0)
                                                        ->get();
                                                    if ($choices) {
                                                        $choices = $choices;
                                                    } else {
                                                        $choices = null;
                                                    }
                                                @endphp
                                                <div class="col-lg-6 col-12">
                                                    <h5 class="title">Color</h5>
                                                    <select name='choice_id'>
                                                        @foreach ($choices as $choice)
                                                            <option value="{{ $choice->id }}">
                                                                {{ $choice->color_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @else
                                                <input type="hidden" value="0" name="choice_id" />
                                            @endif
                                            <div class="quantity"><br>
                                                <div class="input-group">
                                                    <div class="button minus">
                                                        <button type="button" class="btn btn-primary btn-number"
                                                            disabled="disabled" data-type="minus" data-field="quant[1]">
                                                            <i class="ti-minus"></i>
                                                        </button>
                                                    </div>
                                                    <input type="hidden" name="slug" value="{{ '$product->slug' }}">
                                                    <input type="text" name="quant[1]" class="input-number" data-min="1"
                                                        data-max="1000" value="1">
                                                    <div class="button plus">
                                                        <button type="button" class="btn btn-primary btn-number"
                                                            data-type="plus" data-field="quant[1]">
                                                            <i class="ti-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!--/ End Input Order -->
                                            </div>
                                            <div class="add-to-cart"><br>
                                                <button type="submit" class="btn">Add to cart</button>
                                                {{-- <a href="{{ route('add-to-wishlist', '$product->slug') }}"
                                                    class="btn min"><i class="ti-heart"></i></a> --}}
                                            </div>
                                            {{-- <div class="default-social">
                                                <!-- ShareThis BEGIN -->
                                                <div class="sharethis-inline-share-buttons"></div><!-- ShareThis END -->
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                </form>
            </div>
            </div>
            </div>
        @endforeach
    @endif
    <!-- Modal end -->
@endsection
@push('styles')
    <style>
        /* Banner Sliding */
        #Gslider .carousel-inner {
            background: whitesmoke;
           
        }

        #Gslider .carousel-inner {
            height: 550px;
        }

     
        @media only screen and (max-width: 767px) {
            #Gslider .carousel-inner{
                height: 200px;
                background: whitesmoke;
            }
           
            #Gslider .carousel-inner img {
            height: 200px;
            object-fit: contain;
            width: 100% !important;
            opacity: .8;
        }
           

            .carousel-indicators .active {
                position: relative;
                top: 70px;
            }
        }
    
        #Gslider .carousel-inner img {
            height: 550px;
            object-fit: contain;
            width: 100% !important;
            opacity: .8;
        }

        /* #Gslider .carousel-inner .carousel-caption {
            bottom: 60%;
        } */

        #Gslider .carousel-inner .carousel-caption h1 {
            font-size: 50px;
            font-weight: bold;
            line-height: 100%;
            color: #F7941D;
        }

        #Gslider .carousel-inner .carousel-caption p {
            font-size: 18px;
            color: black;
            margin: 28px 0 28px 0;
        }

        #Gslider .carousel-indicators {
            bottom: 60px;
        }

    </style>
@endpush
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    @push('scripts')
<script>
        var message_wrapper = document.getElementById('cartFormResponse');
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function refresh_cart_items_view() {
            $("html, body").animate({ scrollTop: "0" });
            $.ajax({
                type: 'get',
                url: "{{ route('load-cart-info-view') }}",
                success:function(data) {
                    $("#cart_info").html(data);
                }
            });
        }

        function addToCartAjax(formId) {
            var formValues= $('#form_'+formId).serialize();
            var actionUrl = $('#form_'+formId).attr("action");
            $("#cartBtn_" + formId).html('adding to cart...').addClass('btn-info').removeClass('btn-primary').prop('disabled', true);
            $.ajax({
                method:'POST',
                url: "{{ route('add-to-cart-ajax') }}",
                data: formValues,
                success:function(data) {
                   if(data.error == false)
                        message_wrapper.innerHTML = `<div class="alert alert-success w-100 mb-3 ml-3 mr-3" id="success-alert">
                                                <button type="button" class="close" data-dismiss="alert">x</button>
                                                <strong>Success! </strong> ${data.message}.
                                            </div>`;
                        $("#success-alert").fadeTo(3000, 500).slideUp(500, function() {
                        $("#success-alert").slideUp(500);
                    });
                    window.refresh_cart_items_view();
                },
                error:function(error) {
                    message_wrapper.innerHTML = `<div class="alert alert-danger w-100 mb-3 ml-3 mr-3" id="danger-alert">
                                                <button type="button" class="close" data-dismiss="alert">x</button>
                                                <strong>Error! </strong> ${error.responseJSON.message}.
                                            </div>`;
                    $("#danger-alert").fadeTo(3000, 500).slideUp(500, function() {
                    $("#danger-alert").slideUp(500);
                    });
                    window.refresh_cart_items_view();
                }
            });
            setTimeout(() => {
                $("#cartBtn_" + formId).html('Add to cart').removeClass('btn-info').addClass('btn-primary').prop('disabled', false);
            }, 3000);
            return false;
        }
    </script>

    <script>
        /*==================================================================
                                                                                                                                    [ Isotope ]*/
        var $topeContainer = $('.isotope-grid');
        var $filter = $('.filter-tope-group');
        // filter items on button click
        $filter.each(function() {
            $filter.on('click', 'button', function() {
                var filterValue = $(this).attr('data-filter');
                $topeContainer.isotope({
                    filter: filterValue
                });
            });
        });
        // init Isotope
        $(window).on('load', function() {
            var $grid = $topeContainer.each(function() {
                $(this).isotope({
                    itemSelector: '.isotope-item',
                    layoutMode: 'fitRows',
                    percentPosition: true,
                    animationEngine: 'best-available',
                    masonry: {
                        columnWidth: '.isotope-item'
                    }
                });
            });
        });
        var isotopeButton = $('.filter-tope-group button');
        $(isotopeButton).each(function() {
            $(this).on('click', function() {
                for (var i = 0; i < isotopeButton.length; i++) {
                    $(isotopeButton[i]).removeClass('how-active1');
                }
                $(this).addClass('how-active1');
            });
        });
    </script>
    <script>
        function cancelFullScreen(el) {
            var requestMethod = el.cancelFullScreen || el.webkitCancelFullScreen || el.mozCancelFullScreen || el
                .exitFullscreen;
            if (requestMethod) { // cancel full screen.
                requestMethod.call(el);
            } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
                var wscript = new ActiveXObject("WScript.Shell");
                if (wscript !== null) {
                    wscript.SendKeys("{F11}");
                }
            }
        }

        function requestFullScreen(el) {
            // Supports most browsers and their versions.
            var requestMethod = el.requestFullScreen || el.webkitRequestFullScreen || el.mozRequestFullScreen || el
                .msRequestFullscreen;
            if (requestMethod) { // Native full screen.
                requestMethod.call(el);
            } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
                var wscript = new ActiveXObject("WScript.Shell");
                if (wscript !== null) {
                    wscript.SendKeys("{F11}");
                }
            }
            return false
        }
    </script>
@endpush
