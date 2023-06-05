@extends('frontend.layouts.master')
@section('title', 'E-SHOP || PRODUCT PAGE')
@section('page-title', 'PRODUCTS PAGE')
@section('main-content')
    <!-- Breadcrumbs -->

    <style>
        .nice-select {
            -webkit-tap-highlight-color: transparent;
            background-color: #fff;
            border-radius: 5px;
            border: solid 1px #e8e8e8;
            box-sizing: border-box;
            clear: both;
            cursor: pointer;
            display: block;
            float: left;
            font-family: inherit;
            font-size: 12px;
            font-weight: normal;
            height: 42px;
            line-height: 27px;
            outline: none;
            padding-left: 18px;
            padding-right: 30px;
            position: relative;
            text-align: left !important;
            -webkit-transition: all 0.2s ease-in-out;
            transition: all 0.2s ease-in-out;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            white-space: nowrap;
            width: auto;
            margin-bottom: 16px;
        }


        .nice-select:after {
            border-bottom: 2px solid #999;
            border-right: 2px solid #999;
            content: '';
            display: block;
            height: 8px;
            margin-top: -4px;
            pointer-events: none;
            position: absolute;
            right: 12px;
            top: 47%;
            -webkit-transform-origin: 66% 66%;
            -ms-transform-origin: 66% 66%;
            transform-origin: 66% 66%;
            -webkit-transform: rotate(45deg);
            -ms-transform: rotate(45deg);
            transform: rotate(45deg);
            -webkit-transition: all 0.15s ease-in-out;
            transition: all 0.15s ease-in-out;
            width: 8px;
        }


        .shop-list .list-content {
           margin-top: 50px;
           margin-left: 39px;
        }

        .single-product .product-img {
           
            position: relative;
            overflow: hidden;
            cursor: pointer;
            height: 200px;
            width: 190px;
     }

        .col-lg-8,
        .col-md-7,
        .col-12 {
            position: relative;
            width: 100%;
            min-height: 1px;
            padding-right: 15px;
            padding-left: 15px;
            margin-top: -4px;
        }

        

        table {
            margin: 0 0 2.5em;
            margin-top: 10px;
            width: 100%;

        }

        .single-product .product-img a img {
            height: 206px;
            width: 300px;
        }

        .single-product .product-img a span.price-dec {
            background-color: #f6931d;
            display: inline-block;
            font-size: 11px;
            color: #fff;
            right: 10px;
            top: 1px;
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

        .shop .view-mode li.active a, .shop .view-mode li:hover a {
         background: #EE4540;
         color: #fff;
         border-color: transparent;
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

        .shop-sidebar .single-post .content h5 a {
    color: #222;
    font-weight: 500;
    font-size: 12px;
    font-weight: 500;
    display: block;
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
           
        }

        .nice-select{
            font-size: 11px;
            border-color: #510A32;
        }


        .single-product .product-content h3 a {
            font-size: 14px;
            font-weight: 500;
            color: gray;
         
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

        .single-product .product-img .product-action a span{
            background: #EE4540 !important;
            color: #fff !important;
        }

        .shop-list .list-content .btn:hover{
   
         color: white;
         background:#510A32;
   
        }

        .shop .nice-select .list li:hover {
          background: #EE4540;
          color: #fff;
       }

       .filter_button{
        background: #EE4540;
        color: white;
       }

       .shop .range .ui-slider-handle.ui-state-default.ui-corner-all {
    background: #510A32;
    color: #510A32;
    cursor: pointer;
}

.shop .range #slider-range{
    background: #510A32;
    color: #510A32;
}

.shop .range #slider-range .ui-slider-range {
  
    background: white;
   
}

.shop-sidebar .categor-list li a:hover{
    color: #510A32;
}


    </style>
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{ 'home' }}?k={{ request()->get('k') }}">Home<i
                                        class="ti-arrow-right"></i></a></li>

                            <li class="active"><a href="javascript:void(0);">Shop List</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->
    <!-- Product Style 1 -->
    <section class="product-area shop-sidebar shop-list shop section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-12">
                    <div class="shop-sidebar">
                        <form action="{{ route('shop.filter') }}" method="POST">
                            <input type="hidden" name="store_id" value="{{ request()->get('k') }}">

                            @csrf
                            <!-- Single Widget -->
                            <div class="single-widget category">
                                <h3 class="title">Categories</h3>
                                <ul class="categor-list">
                                    @php
                                        // $category = new Category();
                                        $store_id = request()->has('k') ? Crypt::decrypt(request()->get('k')) : 0;
                                        $menu = App\Models\Category::getAllParentWithChild($store_id);
                                    @endphp
                                    @if ($menu)
                                        <li>
                                            @foreach ($menu as $cat_info)
                                                @if ($cat_info->child_cat->count() > 0)
                                        <li><a
                                                href="{{ url('/'. $last_slug. '/product-category'. '/' . $cat_info->id) }}">{{ $cat_info->title }}</a>
                                            <ul>
                                                @foreach ($cat_info->child_cat as $sub_menu)
                                                    <li><a
                                                            href="{{ route('product-sub-cat', [$last_slug, $sub_menu->id]) }}">{{ $sub_menu->title }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @else
                                        <li><a
                                                href="{{ url('/'. $last_slug. '/product-category'. '/' . $cat_info->id) }}">{{ $cat_info->title }}</a>
                                        </li>
                                    @endif
                                    @endforeach
                                    </li>
                                    @endif
                                    {{-- @foreach (Helper::productCategoryList('products') as $cat)
                             @if ($cat->is_parent == 1)
                           <li><a href="{{route('product-cat',$cat->slug)}}">{{$cat->title}}</a></li>
                                @endif
                                @endforeach --}}
                                </ul>
                            </div>
                            <!--/ End Single Widget -->
                            <!-- Shop By Price -->
                            <div class="single-widget range">
                                <h3 class="title">Shop by Price</h3>
                                <div class="price-filter">
                                    <div class="price-filter-inner">
                                        @php
                                            $max = DB::table('products')->max('price');
                                            // dd($max);
                                        @endphp
                                        <div id="slider-range" data-min="0" data-max="{{ $max }}"></div>
                                        <div class="product_filter">
                                            <button type="submit" class="filter_button">Filter</button>
                                            <div class="label-input">
                                                <span>Range:</span>
                                                <input style="" type="text" id="amount" readonly />
                                                <input type="hidden" name="price_range" id="price_range"
                                                    value="@if (!empty($_GET['price'])) {{ $_GET['price'] }} @endif" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!--/ End Shop By Price -->
                            <!-- Single Widget -->
                            <div class="single-widget recent-post">
                                <h3 class="title">Recent post</h3>
                                {{-- {{dd($recent_products)}} --}}
                                @foreach ($recent_products as $product)
                                    <!-- Single Post -->
                                    @php
                                        $photo = explode(',', $product->photo);
                                    @endphp
                                    <div class="single-post first">
                                        <div class="image">
                                            <img src="{{ asset('products/images/products/' . $photo[0]) }}"
                                                alt="{{ $photo[0] }}">
                                        </div>
                                        <div class="content">
                                            <h5><a
                                                    href="{{ route('product-detail', $product->slug) }}?k={{ request()->get('k') }}">{{ $product->title }}</a>
                                            </h5>
                                            @php
                                                $org = $product->price - ($product->price * $product->discount) / 100;
                                            @endphp
                                            <p class="price"><del
                                                    class="text-muted">{{ number_format($product->price, 2) }}</del>
                                                {{ number_format($org, 2) }} </p>
                                        </div>
                                    </div>
                                    <!-- End Single Post -->
                                @endforeach
                            </div>
                            <!-- Single Widget -->
                            <div class="single-widget category">
                                <h3 class="title">Brands</h3>
                                <ul class="categor-list">
                                    @php
                                        $brands = DB::table('brands')
                                            ->where('store_id', $store_id)
                                            ->orderBy('title', 'ASC')
                                            ->where('status', 'active')
                                            ->get();
                                    @endphp
                                    @foreach ($brands as $brand)
                                        <li><a
                                                href="{{ route('product-brand', ['slug'=> $last_slug, 'id'=> $brand->id])}}">{{ $brand->title }} 123</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <!--/ End Single Widget -->
                    </div>
                </div>
                <div class="col-lg-9 col-md-8 col-12">
                    <div class="row">
                        <div class="col-12">
                            <!-- Shop Top -->
                            <div class="shop-top">
                                <div class="shop-shorter">
                                    <div class="single-shorter">
                                        <label>Show :</label>
                                        <select class="show" name="show" onchange="this.form.submit();">
                                            <option value="">Default</option>
                                            <option value="9" @if (!empty($_GET['show']) && $_GET['show'] == '9') selected @endif>
                                                09</option>
                                            <option value="15" @if (!empty($_GET['show']) && $_GET['show'] == '15') selected @endif>15</option>
                                            <option value="21" @if (!empty($_GET['show']) && $_GET['show'] == '21') selected @endif>21</option>
                                            <option value="30" @if (!empty($_GET['show']) && $_GET['show'] == '30') selected @endif>30</option>
                                        </select>
                                    </div>
                                    <div class="single-shorter">
                                        <label>Sort By :</label>
                                        <select class='sortBy' name='sortBy' onchange="this.form.submit();">
                                            <option value="">Default</option>
                                            <option value="title" @if (!empty($_GET['sortBy']) && $_GET['sortBy'] == 'title') selected @endif>Name
                                            </option>
                                            <option value="price" @if (!empty($_GET['sortBy']) && $_GET['sortBy'] == 'price') selected @endif>Price
                                            </option>
                                            <option value="category" @if (!empty($_GET['sortBy']) && $_GET['sortBy'] == 'category') selected @endif>
                                                Category</option>
                                            <option value="brand" @if (!empty($_GET['sortBy']) && $_GET['sortBy'] == 'brand') selected @endif>Brand
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <ul class="view-mode">
                                    <li><a href="{{ route('product-grids') }}?k={{ request()->get('k') }}"><i
                                                class="fa fa-th-large"></i></a></li>
                                    <li class="active"><a href="javascript:void(0)"><i
                                                class="fa fa-th-list"></i></a>
                                    </li>
                                </ul>
                            </div>
                            <!--/ End Shop Top -->
                        </div>
                    </div>
                    </form>
                    <div class="row">
                        @if (count($products))
                            @foreach ($products as $product)
                                {{-- {{$product}} --}}
                                <!-- Start Single List -->
                                <form action="{{ route('add-to-cart', $product->id) }}" method="POST">
                                    {{ csrf_field() }}
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-6 col-sm-6">
                                                <div class="single-product boxx">
                                                    <div class="product-img">
                                                        <a
                                                            href="{{ route('product-detail', $product->slug) }}?k={{ request()->get('k') }}">
                                                            @php
                                                                $photo = explode(',', $product->photo);
                                                                // dd($photo);
                                                            @endphp
                                                            <img class="default-img"
                                                                src="{{ asset('products/images/products/' . $photo[0]) }}"
                                                                alt="{{ $photo[0] }}" class="img-fluid"
                                                                style="width: 85%;">
                                                            <!-- <img class="hover-img" src="{{ $photo[0] }}" alt="{{ $photo[0] }}"> -->
                                                            @if ($product->stock <= 0)
                                                                <span class="out-of-stock">Sold Out</span>
                                                            @elseif($product->condition == 'new')
                                                                <span class="new">New</span
                                                                @elseif($product->condition == 'hot') <span
                                                                    class="hot">Hot</span>
                                                            @else
                                                                <span class="price-dec">{{ $product->discount }}%
                                                                    Off</span>
                                                            @endif
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-8 col-md-6 col-12">
                                                <div class="list-content">
                                                    <div class="product-content">
                                                        <div class="product-price" style="display:flex; color:red">
                                                            @php
                                                                $after_discount = $product->price - ($product->price * $product->discount) / 100;
                                                            @endphp
                                                            <span>{{ number_format($after_discount, 2) }}</span>
                                                            <del
                                                                style="margin-left:40px;">{{ number_format($product->price, 2) }}</del>
                                                        </div>
                                                        <h3 class="title"><a
                                                                href="{{ route('product-detail', $product->slug) }}?k={{ request()->get('k') }}">{{ $product->title }}</a>
                                                        </h3>
                                                    </div>
                                                    <input type="hidden" name="slug" value="{{ $product->slug }}">
                                                    <input type="hidden" name="quant[1]" class="input-number" data-min="1"
                                                        data-max="1000" value="1" id="quantity">
                                                    <input type="hidden" value="{{ $product->id }}" name="product_id" />
                                                    <table>
                                                        <tr>
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
                                                                <td>
                                                                    <label>Sizes :</label>
                                                                </td>
                                                                <td>
                                                                    <select name="size_id" class="pull-right"
                                                                        style="display: none;">
                                                                        @foreach ($sizes as $size)
                                                                            <option value="{{ $size->id }}">
                                                                                {{ $size->title }} </option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                            @else
                                                                <td><input type="hidden" value="0" name="size_id" /></td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if ($product->choice_option == 1)
                                                                @php
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
                                                                <td>
                                                                    <label>Variations :</label>
                                                                </td>
                                                                <td>
                                                                    <select name='choice_id' style="display: none;">
                                                                        @foreach ($choices as $choice)
                                                                            <option value="{{ $choice->id }}">
                                                                                {{ $choice->color_name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                            @else
                                                                <td><input type="hidden" value="0" name="choice_id" /></td>
                                                            @endif
                                                        </tr>
                                                    </table>

                                                    <!-- <a href="javascript:void(0)" class="btn cart" data-id="{{ $product->id }}">Buy Now!</a> -->
                                                    <button type="submit" class="btn" class="btn cart"
                                                        style="margin-top: -30px;">Buy Now!</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!-- End Single List -->
                            @endforeach
                        @else
                            <h4 class="text-warning" style="margin:100px auto;">There are no products.</h4>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-md-12 justify-content-center d-flex">
                            {{-- {{$products->appends($_GET)->links()}} --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End Product Style 1  -->
    <!-- Modal -->
    @if ($products)
        @foreach ($products as $key => $product)
            <div class="modal fade" id="{{ $product->id }}" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    class="ti-close" aria-hidden="true"></span></button>
                        </div>
                        <div class="modal-body">
                            <div class="row no-gutters">
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                    <!-- Product Slider -->
                                    <div class="product-gallery">
                                        <div class="quickview-slider-active">
                                            @php
                                                $photo = explode(',', $product->photo);
                                                // dd($photo);
                                            @endphp
                                            @foreach ($photo as $data)
                                                <div class="single-slider">
                                                    <img src="{{ asset('products/images/products/' . $data) }}"
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
                                                    <span><i class="fa fa-check-circle-o"></i> {{ $product->stock }} in
                                                        stock</span>
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
                                        @if ($product->size)
                                            <div class="size">
                                                <h4>Size</h4>
                                                <ul>
                                                    @php
                                                        $sizes = explode(',', $product->size);
                                                        // dd($sizes);
                                                    @endphp
                                                    @foreach ($sizes as $size)
                                                        <li><a href="#" class="one">{{ $size }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        <form action="{{ route('single-add-to-cart') }}" method="POST">
                                            @csrf
                                            <div class="quantity">
                                                <!-- Input Order -->
                                                <div class="input-group">
                                                    <div class="button minus">
                                                        <button type="button" class="btn btn-primary btn-number"
                                                            disabled="disabled" data-type="minus" data-field="quant[1]">
                                                            <i class="ti-minus"></i>
                                                        </button>
                                                    </div>
                                                    <input type="hidden" name="slug"
                                                        value="{{ $product->slug }}?k={{ request()->get('k') }}">
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
                                            <div class="add-to-cart">
                                                <button type="submit" class="btn">Add to cart</button>
                                                {{-- <a href="{{ route('add-to-wishlist', $product->slug) }}"
                                                    class="btn min"><i class="ti-heart"></i></a> --}}
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
    <!-- Modal end -->
@endsection
@push('styles')
    <style>
        .pagination {
            display: inline-flex;
        }

        .filter_button {
            /* height:20px; */
            text-align: center;
            background: #F7941D;
            padding: 8px 16px;
            margin-top: 10px;
            color: white;
        }

    </style>
@endpush
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    {{-- <script>
$('.cart').click(function(){
var quantity=1;
var pro_id=$(this).data('id');
$.ajax({
url:"{{route('add-to-cart')}}",
    type:"POST",
    data:{
    _token:"{{csrf_token()}}",
    quantity:quantity,
    pro_id:pro_id
    },
    success:function(response){
    console.log(response);
    if(typeof(response)!='object'){
    response=$.parseJSON(response);
    }
    if(response.status){
    swal('success',response.msg,'success').then(function(){
    document.location.href=document.location.href;
    });
    }
    else{
    swal('error',response.msg,'error').then(function(){
    // document.location.href=document.location.href;
    });
    }
    }
    })
    });
    </script> --}}
    <script>
        $(document).ready(function() {
            /*----------------------------------------------------*/
            /*  Jquery Ui slider js
            /*----------------------------------------------------*/
            if ($("#slider-range").length > 0) {
                const max_value = parseInt($("#slider-range").data('max')) || 500;
                const min_value = parseInt($("#slider-range").data('min')) || 0;
                const currency = $("#slider-range").data('currency') || '';
                let price_range = min_value + '-' + max_value;
                if ($("#price_range").length > 0 && $("#price_range").val()) {
                    price_range = $("#price_range").val().trim();
                }

                let price = price_range.split('-');
                $("#slider-range").slider({
                    range: true,
                    min: min_value,
                    max: max_value,
                    values: price,
                    slide: function(event, ui) {
                        $("#amount").val(currency + ui.values[0] + " -  " + currency + ui.values[1]);
                        $("#price_range").val(ui.values[0] + "-" + ui.values[1]);
                    }
                });
            }
            if ($("#amount").length > 0) {
                const m_currency = $("#slider-range").data('currency') || '';
                $("#amount").val(m_currency + $("#slider-range").slider("values", 0) +
                    "  -  " + m_currency + $("#slider-range").slider("values", 1));
            }
        })
    </script>
@endpush
