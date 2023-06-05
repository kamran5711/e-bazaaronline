@extends('frontend.layouts.master')

@section('title', 'E-SHOP || PRODUCT PAGE')
@section('page-title', 'PRODUCTS PAGE')
@section('main-content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{ url('/') }}">Home<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0)">Product List</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <style>
            .filter_button {
  background: #ee4540;
  color: white;
}

.shop .nice-select .list li:hover {
  background: #ee4540;
  color: #fff;
}

.shop .range .ui-slider-handle.ui-state-default.ui-corner-all {
  background: #510a32;
  color: #510a32;
  cursor: pointer;
}

.shop .range #slider-range {
  background: #510a32;
  color: #510a32;
}

.shop .range #slider-range .ui-slider-range {
  background: white;
}

.shop-sidebar .categor-list li a:hover {
  color: #510a32;
}

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

.single-product .product-content .product-price span {
  font-size: 15px;
  font-weight: 500;
  color: #ee4540;
  margin-left: 20px;
}

label {
  display: inline-block;
  margin-bottom: 0.5rem;
  background: transparent;
  color: #510a32;
  margin-left: 20px;
}

.nice-select {
  font-size: 11px;
  border-color: #510a32;
}

.single-product .product-content h3 a {
  font-size: 14px;
  font-weight: 500;
  color: gray;
  margin-left: 20px;
}

.btn-warning {
  background-color: #510a32;
  color: white;
  border-color: #510a32;
}

.btn-warning:hover {
  background-color: #ee4540;
  border-color: #ee4540;
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

.single-product .product-img a img {
  width: 100%;
  padding: 20px;
}

.single-product .product-img a span.price-dec {
  background-color: #ee4540;

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

/* .single-product:hover .button-head {
            bottom: 0;
            width: 85%;
        } */

.shop-blog .shop-single-blog .content {
  padding: 0;
}

.single-product .product-img .product-action a span {
  background: #ee4540 !important;
  color: #fff !important;
}

.p-card {
  margin-right: 0px;
  margin-top: 20px;
  border-radius: 5px;
  border: 1px solid lightgrey;
}

.card-shadow {
  box-shadow: -1px 2px 5px 1px hsl(0, 0%, 70%);
  -webkit-box-shadow: -1px 2px 5px 1px hsl(0, 0%, 70%);
  -moz-box-shadow: -1px 2px 5px 1px hsl(0, 0%, 70%);
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
    <!-- Product Style -->

    @php
        $storeAndUrl = Helper::getStoreAndUrlBySlug();
        $store_slug = $last_slug = $storeAndUrl['last_slug'];
        $store = $storeAndUrl['store'];
        $store_id = $store->id;
    @endphp
    <section class="product-area shop-sidebar shop section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-12">
                    <div class="shop-sidebar">
                        <form action="{{ route('shop.filter') }}" method="post">
                            <input type="hidden" name="store_id" value="{{ $store_id }}" />
                            <input type="hidden" name="store_slug" value="{{Route::getCurrentRoute()->slug}}" />
                            <input type="hidden" name="prev_url" value="product-grids" />
                            @csrf
                            <!-- Single Widget -->
                            <div class="single-widget category">
                                <h3 class="title">Categories</h3>
                                <ul class="categor-list">
                                    @if (count($categories) > 0)
                                        <li>
                                            @foreach ($categories as $cat_info)
                                                @if ($cat_info->sub_categories->count() > 0)
                                        <li><a
                                                href="{{ url('/'. $last_slug. '/product-category'. '/' . $cat_info->id) }}">{{ $cat_info->title }}</a>
                                            <ul>
                                                @foreach ($cat_info->sub_categories as $sub_menu)
                                                    <li><a
                                                            href="{{ route('product-sub-category', [$last_slug, $sub_menu->id]) }}">{{ $sub_menu->title }}</a>
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
                                        <div id="slider-range" data-min="{{ $min_price }}" data-max="{{ $max_price }}"></div>
                                        <div class="product_filter">
                                            <button type="submit" class="filter_button" onclick="applyPriceRangeFilter()">Filter</button>
                                            <div class="label-input">
                                                <span>Range:</span>
                                                <input style="" type="text" id="amount" readonly />
                                                <input type="hidden" name="price_range" id="price_range" value="{{ (!empty($_GET['price'])) ? $_GET['price'] : ''}}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <script>
                                function applyPriceRangeFilter() {
                                    var price_range = document.getElementById('price_range'); 
                                    if(price_range.value == '')
                                        price_range.value = "<?php echo $min_price. '-' .$max_price; ?>";
                                    // debugger;
                                }
                            </script>

                            <!--/ End Shop By Price -->
                            <!-- Single Widget -->
                            <div class="single-widget recent-post">
                                <h3 class="title">Recent post</h3>
                                {{-- {{dd($recent_products)}} --}}
                                @foreach ($recent_products as $recent_product)
                                    <!-- Single Post -->

                                    <div class="single-post first">
                                        <div class="image">
                                            <img src="{{ asset('images/products/' . $recent_product->photo) }}"
                                                alt="{{ $recent_product->title }} image">
                                        </div>
                                        <div class="content">
                                            <h5><a href="{{ URL( $last_slug .'/'. 'product-detail' . '/' . $recent_product->slug) }}">{{ $recent_product->title }}</a>
                                            </h5>
                                            @php
                                                $org = $recent_product->price - ($recent_product->price * $recent_product->discount) / 100;
                                            @endphp
                                            <p class="price"><del
                                                    class="text-muted">{{ number_format($recent_product->price, 2) }}</del>
                                                {{ number_format($org, 2) }} </p>

                                        </div>
                                    </div>
                                    <!-- End Single Post -->
                                @endforeach
                            </div>
                            <!--/ End Single Widget -->
                            <!-- Single Widget -->
                            <div class="single-widget category">
                                <h3 class="title">Brands</h3>
                                <ul class="categor-list">
                                    @foreach ($brands as $brand)
                                        <li><a
                                                href="{{ route('product-brand', ['slug'=> $last_slug, 'id'=> $brand->id])}}">{{ $brand->title }}</a>
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
                                            <option value="20" @if (!empty($_GET['show']) && $_GET['show'] == '20') selected @endif>20</option>
                                            <option value="50" @if (!empty($_GET['show']) && $_GET['show'] == '50') selected @endif>50</option>
                                            <option value="100" @if (!empty($_GET['show']) && $_GET['show'] == '100') selected @endif>100</option>
                                            <option value="250" @if (!empty($_GET['show']) && $_GET['show'] == '250') selected @endif>250</option>
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
                                    <li class="active"><a href="javascript:void(0)"><i
                                                class="fa fa-th-large"></i></a></li>
                                    {{-- <li><a href="{{ route('product-lists') }}"><i
                                                class="fa fa-th-list"></i></a></li> --}}
                                </ul>
                            </div>
                            <!--/ End Shop Top -->
                        </div>
                    </div>
                    </form>
                    <div class="row mb-5">
                        {{-- {{$products}} --}}
                        @if (count($products) > 0)
                            @foreach ($products as $key => $product)
                                <div class="col-sm-6 col-xs-12 col-md-4 col-lg-4 mt-3 product_{{ $product->id }}">
                                    <div class="card-shadow">
                                        <form
                                            action="{{ route('add-to-cart', $product->id) }}" method="POST">
                                            {{ csrf_field() }}
                                                <div class="single-product">
                            
                                                    <div class="product-img">
                                                        <div>
                                                            <a
                                                                href="{{ URL($last_slug.'/product-detail', $product->slug) }}">
                                                                <img class="img img-responsive"
                                                                    src="{{ asset('images/products/' . $product->photo) }}"
                                                                    alt="{{ $product->photo }} image">                        
                                                                {{-- <img class="hover-img" src="{{ asset('images/products/' . $photo[0]) }}" alt="{{ $photo[0] }} image"> --}}
                                                                @if ($product->productStock->sum('stock') <= 0)
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
                                                                {{-- <a data-toggle="modal" data-target="#{{ $product->id }}" title="Quick View" href="javascript:void(0)">
                                                                    <i class=" ti-eye"></i><span>Quick Shop</span></a>
                                                                <a title="Wishlist"
                                                                    href="{{ route('add-to-wishlist', '$product->slug') }}?k={{ request()->get('k') }}"
                                                                    class="wishlist" data-id="{{ $product->id }}"><i
                                                                        class=" ti-heart "></i><span>Add to
                                                                        Wishlist</span></a> --}}
                                                            </div>
                                                            <div class="product-action-2">
                                                                <button type="submit" name="btn_add_to_cart"
                                                                    class="btn-warning btn-sm min" title="Add to cart">Add to
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
                                                <input type="hidden" value="{{ $product->id }}" name="product_id" />
                                                <table>
                                                    @php
                                                        $color_title = $size_title = null;
                                                        if($product->productStock->sum('stock') > 0){
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
                        @else
                            <h4 class="text-warning" style="margin:100px auto;">There are no products.</h4>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-md-12 justify-content-center d-flex">
                            {{-- {{ $products->appends($_GET)->links() }} --}}
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
                        <form action="{{ route('add-to-cart', $product->id) }}" method="POST" class="mt-4">
                            {{ csrf_field() }}
                            <div class="modal-body">
                                <div class="row no-gutters">
                                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                        <!-- Product Slider -->
                                        <div class="product-gallery">
                                            <div class="quickview-slider-active" height="100%">
                                                <div class="single-slider">
                                                    <img src="{{ asset('images/products/' . $product->photo) }}"
                                                        alt="{{ $product->photo }}" class="img-fluid">
                                                </div>
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
                                                    <a href="javascript:void(0)"> ({{ $rate_count }} customer review)</a>
                                                </div>
                                                <div class="quickview-stock">
                                                    @if ($product->stock > 0)
                                                        <span><i class="fa fa-check-circle-o"></i> {{ $product->stock }}
                                                            in
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
                                            <input type="hidden" value="{{ $product->id }}" name="product_id" />
                                            @if ($product->size_option == 1)
                                                @php
                                                    $sizes = null;
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
                                                    <input type="hidden" name="slug" value="{{ $product->slug }}">
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
                                                {{-- <a href="{{ route('add-to-wishlist', $product->slug) }}"
                                                    class="btn min"><i class="ti-heart"></i></a> --}}
                                            </div>
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
