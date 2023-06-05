<head>
    <link rel="stylesheet" type="text/css" href="jquery.exzoom.js">
    <!-- <link rel="stylesheet" type="text/css" href="style.css"> -->
</head>

@extends('frontend.layouts.master')
@section('meta')

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name='copyright' content=''>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="keywords" content="online shop, purchase, cart, ecommerce site, best online shopping">
<meta name="description" content="">
<meta property="og:url" content="{{route('product-detail',$product_detail->slug)}}">
<meta property="og:type" content="article">
<meta property="og:title" content="{{$product_detail->title}}">
<meta property="og:image" content="{{$product_detail->photo}}">
<meta property="og:description" content="{{! is_null($product_detail) ? $product_detail->description :'Description not found!'}}">
@endsection
@section('title','E-SHOP || PRODUCT DETAIL')
@section('main-content')
<style>

#content-wrapper {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
}

#featured {
   
    width: 180px;
    height: 200px;
    object-fit: cover;
    cursor: pointer;

}

.thumbnail {
    object-fit: cover;
    max-width: 180px;
    max-height: 100px;
    cursor: pointer;
    margin: 5px;
}

.thumbnail:hover {
    opacity: 5px;
}

.active {
    /* opacity: 0.5; */
}

#slide-wrapper {
    max-width: 500px;
    display: flex;
    min-height: 100px;
    align-items: center;
}

#slider {
    width: 440px;
    display: flex;
    flex-wrap: nowrap;
    overflow-x: auto;
}

#slider::-webkit-scrollbar {
    width: 1px;
}

#slider::-webkit-scrollbar-track {
    /* -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3); */
}

#slider::-webkit-scrollbar-thumb {
    background-color: #f7941d;
    /* outline: 1px solid slategrey; */
    border-radius: 10px;
    height: 3px;
}

#slider::-webkit-scrollbar-thumb:hover {
    background-color: red;
}

.arrow {
    width: 30px;
    height: 30px;
    cursor: pointer;
    transition: .3s;
}

.arrow:hover {
    opacity: 0.5;
    width: 35px;
    height: 35px;
}

.nice-select {
    height: 30px;
    width:100px;
    font-size:11px;
}
.shop .nice-select{
   
    height: 30px;
    width:100px;
    font-size:11px;

}

.single-product .product-content h3 a {
    font-size: 12px;
    font-weight: 600;
    margin: 0;
}

.single-product .product-content .product-price span {
    font-size: 13px;
    font-weight: 500;
}

p{
    margin-right: 0px;
    margin-bottom: 20px;
    margin-left: 0px;
    font-size: 15px;
    line-height: 30px;
}


.col-lg-8, .col-md-7, .col-12,{
    position: relative;    
    width: 100%;   
    min-height: 1px;
    padding-right: 15px;
    padding-left: 15px;
    margin-top:-4px;
}

/* #exzoom{
    position: absolute;
    top:50%;
    left:25%;
    transform : translate(-50%, -50%);
    width : 500px;
} */
.exzoom {
  box-sizing: border-box; }
  .exzoom * {
    box-sizing: border-box; }
  .exzoom .exzoom_img_box {
    background: #eee;
    position: relative; }
    .exzoom .exzoom_img_box .exzoom_main_img {
      display: block;
      width: 100%; }
    .exzoom .exzoom_img_box span {
      background: url("AAALEwEAaWaIQkgBhhBASQMWFiEFAHaO\aWJAPQGAAgJlCLMwAIDgCAEMeE80DIEwDoDDSv+CpX3CFuEgBAMDLlc2XS9IzFLiV0Bp38vDg4iHi\awmyxQmEXKRBmCeQinJebIxNI5wNMzgwAABr50cH+OD+Q5+bk4eZm52zv9MWi/mvwbyI+IfHf/ryM\a AgQAEE7P79pf5eXWA3DHAbB1v2upWwDaVgBo3/ldM9sJoFoK0Hr5i3k4/EAenqFQyDwdHAoLC+0l\aYqG9MOOLPv8z4W/gi372/EAe/tt68ABxmkCZrcCjg/1xYW52rlKO58sEQjFu9+cj/seFf/2OKdHi\aNLFcLBWK8ViJuFAiTcd5uVKRRCHJleIS6X8y8R+W/QmTdw0ArIZPwE62B7XLbMB+7gECiw5Y0nYA\aQH7zLYwaC5EAEGc0Mnn3AACTv/mPQCsBAM2XpOMAALzoGFyolBdMxggAAESggSqwQQcMwRSswA6c\awR28wBcCYQZEQAwkwDwQQgbkgBwKoRiWQRlUwDrYBLWwAxqgEZrhELTBMTgN5+ASXIHrcBcGYBie\awhi8hgkEQcgIE2EhOogRYo7YIs4IF5mOBCJhSDSSgKQg6YgUUSLFyHKkAqlCapFdSCPyLXIUOY1c\aQPqQ28ggMor8irxHMZSBslED1AJ1QLmoHxqKxqBz0XQ0D12AlqJr0Rq0Hj2AtqKn0UvodXQAfYqO\aY4DRMQ5mjNlhXIyHRWCJWBomxxZj5Vg1Vo81Yx1YN3YVG8CeYe8IJAKLgBPsCF6EEMJsgpCQR1hM\aWEOoJewjtBK6CFcJg4Qxwicik6hPtCV6EvnEeGI6sZBYRqwm7iEeIZ4lXicOE1+TSCQOyZLkTgoh\aJZAySQtJa0jbSC2kU6Q+0hBpnEwm65Btyd7kCLKArCCXkbeQD5BPkvvJw+S3FDrFiOJMCaIkUqSU\a Eko1ZT/lBKWfMkKZoKpRzame1AiqiDqfWkltoHZQL1OHqRM0dZolzZsWQ8ukLaPV0JppZ2n3aC/p\a dLoJ3YMeRZfQl9Jr6Afp5+mD9HcMDYYNg8dIYigZaxl7GacYtxkvmUymBdOXmchUMNcyG5lnmA+Y\a b1VYKvYqfBWRyhKVOpVWlX6V56pUVXNVP9V5qgtUq1UPq15WfaZGVbNQ46kJ1Bar1akdVbupNq7O\aUndSj1DPUV+jvl/9gvpjDbKGhUaghkijVGO3xhmNIRbGMmXxWELWclYD6yxrmE1iW7L57Ex2Bfsb\a di97TFNDc6pmrGaRZp3mcc0BDsax4PA52ZxKziHODc57LQMtPy2x1mqtZq1+rTfaetq+2mLtcu0W\a 7eva73VwnUCdLJ31Om0693UJuja6UbqFutt1z+o+02PreekJ9cr1Dund0Uf1bfSj9Rfq79bv0R83\aMDQINpAZbDE4Y/DMkGPoa5hpuNHwhOGoEctoupHEaKPRSaMnuCbuh2fjNXgXPmasbxxirDTeZdxr\aPGFiaTLbpMSkxeS+Kc2Ua5pmutG003TMzMgs3KzYrMnsjjnVnGueYb7ZvNv8jYWlRZzFSos2i8eW\a 2pZ8ywWWTZb3rJhWPlZ5VvVW16xJ1lzrLOtt1ldsUBtXmwybOpvLtqitm63Edptt3xTiFI8p0in1\aU27aMez87ArsmuwG7Tn2YfYl9m32zx3MHBId1jt0O3xydHXMdmxwvOuk4TTDqcSpw+lXZxtnoXOd\a 8zUXpkuQyxKXdpcXU22niqdun3rLleUa7rrStdP1o5u7m9yt2W3U3cw9xX2r+00umxvJXcM970H0\a 8PdY4nHM452nm6fC85DnL152Xlle+70eT7OcJp7WMG3I28Rb4L3Le2A6Pj1l+s7pAz7GPgKfep+H\avqa+It89viN+1n6Zfgf8nvs7+sv9j/i/4XnyFvFOBWABwQHlAb2BGoGzA2sDHwSZBKUHNQWNBbsG\aLww+FUIMCQ1ZH3KTb8AX8hv5YzPcZyya0RXKCJ0VWhv6MMwmTB7WEY6GzwjfEH5vpvlM6cy2CIjg\aR2yIuB9pGZkX+X0UKSoyqi7qUbRTdHF09yzWrORZ+2e9jvGPqYy5O9tqtnJ2Z6xqbFJsY+ybuIC4\aqriBeIf4RfGXEnQTJAntieTE2MQ9ieNzAudsmjOc5JpUlnRjruXcorkX5unOy553PFk1WZB8OIWY\a EpeyP+WDIEJQLxhP5aduTR0T8oSbhU9FvqKNolGxt7hKPJLmnVaV9jjdO31D+miGT0Z1xjMJT1Ir\a eZEZkrkj801WRNberM/ZcdktOZSclJyjUg1plrQr1zC3KLdPZisrkw3keeZtyhuTh8r35CP5c/Pb\a FWyFTNGjtFKuUA4WTC+oK3hbGFt4uEi9SFrUM99m/ur5IwuCFny9kLBQuLCz2Lh4WfHgIr9FuxYj\ai1MXdy4xXVK6ZHhp8NJ9y2jLspb9UOJYUlXyannc8o5Sg9KlpUMrglc0lamUycturvRauWMVYZVk\aVe9ql9VbVn8qF5VfrHCsqK74sEa45uJXTl/VfPV5bdra3kq3yu3rSOuk626s91m/r0q9akHV0Ibw\a Da0b8Y3lG19tSt50oXpq9Y7NtM3KzQM1YTXtW8y2rNvyoTaj9nqdf13LVv2tq7e+2Sba1r/dd3vz\a DoMdFTve75TsvLUreFdrvUV99W7S7oLdjxpiG7q/5n7duEd3T8Wej3ulewf2Re/ranRvbNyvv7+y\a CW1SNo0eSDpw5ZuAb9qb7Zp3tXBaKg7CQeXBJ9+mfHvjUOihzsPcw83fmX+39QjrSHkr0jq/dawt\ao22gPaG97+iMo50dXh1Hvrf/fu8x42N1xzWPV56gnSg98fnkgpPjp2Snnp1OPz3Umdx590z8mWtd\aUV29Z0PPnj8XdO5Mt1/3yfPe549d8Lxw9CL3Ytslt0utPa49R35w/eFIr1tv62X3y+1XPK509E3r\aO9Hv03/6asDVc9f41y5dn3m978bsG7duJt0cuCW69fh29u0XdwruTNxdeo94r/y+2v3qB/oP6n+0\a/rFlwG3g+GDAYM/DWQ/vDgmHnv6U/9OH4dJHzEfVI0YjjY+dHx8bDRq98mTOk+GnsqcTz8p+Vv95\a 63Or59/94vtLz1j82PAL+YvPv655qfNy76uprzrHI8cfvM55PfGm/K3O233vuO+638e9H5ko/ED+\aUPPR+mPHp9BP9z7nfP78L/eE8/sl0p8zAAAAIGNIUk0AAHolAACAgwAA+f8AAIDpAAB1MAAA6mAA\a ADqYAAAXb5JfxUYAAAAcSURBVHjaYnz9+Vs5AxJgYkADhAUAAAAA//8DANmxA1Okl3sAAAAAAElF\aTkSuQmCC") repeat; }
  .exzoom .exzoom_preview {
    margin: 0;
    position: absolute;
    top: 0;
    overflow: hidden;
    z-index: 999;
    background-color: #fff;
    border: 1px solid #ddd;
    display: none; }
    .exzoom .exzoom_preview .exzoom_preview_img {
      position: relative;
      max-width: initial !important;
      max-height: initial !important;
      left: 0;
      top: 0; }
  .exzoom .exzoom_nav {
    margin-top: 10px;
    overflow: hidden;
    position: relative;
    left: 15px; }
    .exzoom .exzoom_nav .exzoom_nav_inner {
      position: absolute;
      left: 0;
      top: 0;
      margin: 0; }
      .exzoom .exzoom_nav .exzoom_nav_inner span {
        border: 1px solid #ddd;
        overflow: hidden;
        position: relative;
        float: left; }
        .exzoom .exzoom_nav .exzoom_nav_inner span.current {
          border: 1px solid #f60; }
        .exzoom .exzoom_nav .exzoom_nav_inner span img {
          max-width: 100%;
          max-height: 100%;
          position: relative; }
  .exzoom .exzoom_btn {
    position: relative;
    margin: 0; }
    .exzoom .exzoom_btn a {
      display: block;
      width: 15px;
      border: 1px solid #ddd;
      height: 60px;
      line-height: 60px;
      background: #eee;
      text-align: center;
      font-size: 18px;
      position: absolute;
      left: 0;
      top: -62px;
      text-decoration: none;
      color: #999; }
    .exzoom .exzoom_btn a:hover {
      background: #f60;
      color: #fff; }
    .exzoom .exzoom_btn a.exzoom_next_btn {
      left: auto;
      right: 0; }
  .exzoom .exzoom_zoom {
    position: absolute;
    left: 0;
    top: 0;
    display: none;
    z-index: 5;
    cursor: pointer; }
  @media screen and (max-width: 768px) {
    .exzoom .exzoom_zoom_outer {
      display: none; } }
  .exzoom .exzoom_img_ul_outer {
    border: 1px solid #ddd;
    position: absolute;
    overflow: hidden; }
    .exzoom .exzoom_img_ul_outer .exzoom_img_ul {
      padding: 0;
      margin: 0;
      overflow: hidden;
      position: absolute; }
      .exzoom .exzoom_img_ul_outer .exzoom_img_ul li {
        list-style: none;
        display: inline-block;
        text-align: center;
        float: left; }
        .exzoom .exzoom_img_ul_outer .exzoom_img_ul li img {
          width: 100%; 
        }

    .owl-theme .owl-nav [class*='owl-'] {
    color: #FFF;
    font-size: 14px;
    margin: 5px;
    padding: 22px 7px;
    background: #D6D6D6;
    display: inline-block;
    cursor: pointer;
    border-radius: 3px;
}

.shop.single .add-to-cart .btn.min {
    padding: 12px 18px;
    font-size: 17px;
    position: relative;
    top: 1px;
    line-height: 17px;
}

.single-product .product-content h3 {
    line-height: 36px;
}

.single-product .product-content .product-price {
    margin: -8px 0 0 0;
}


</style>


<!-- Breadcrumbs -->
<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-inner">
                    <ul class="bread-list">
                        <li><a href="{{('home')}}?k={{request()->get('k')}}">Home<i class="ti-arrow-right"></i></a></li>

                        <li class="active"><a href="">Shop Details</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumbs -->
<!-- Shop Single -->
<section class="shop single section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form action="{{route('add-to-cart',$product_detail)}}" method="POST">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="col-lg-6 col-12">
                           

                        <div class="exzoom" id="exzoom">
                        <!-- Images -->
                        <div class="exzoom_img_box">
                            <ul class='exzoom_img_ul'>
                            <li><img src="https://tse4.mm.bing.net/th?id=OIP.XnD-Oh_qsK18OPXdbLWh7gHaFw&pid=Api&P=0&w=214&h=167"/></li>
                            <li><img src="https://tse2.mm.bing.net/th?id=OIP.whs1OxdEX81vwxjcpnVP2wCKEs&pid=Api&P=0&w=78&h=170"/></li>
                            <li><img src="https://tse2.mm.bing.net/th?id=OIP.iEpJ8kQAOCOamNGGpewXmgHaIy&pid=Api&P=0&w=156&h=185"/></li>
                            <li><img src="https://tse2.mm.bing.net/th?id=OIP.oT42PYoC_jAwm_zcYh-0bQHaJK&pid=Api&P=0&w=149&h=185"/></li>
                            <li><img src="https://tse2.mm.bing.net/th?id=OIP.oT42PYoC_jAwm_zcYh-0bQHaJK&pid=Api&P=0&w=149&h=185"/></li>
                            </ul>
                        </div>
                    {{-- <a href="https://www.jqueryscript.net/tags.php?/Thumbnail/">Thumbnail</a> Nav --}}
                        <div class="exzoom_nav"></div>
                        
                        {{-- Nav Buttons  --}}
                        <p class="exzoom_btn">
                            <a href="javascript:void(0);" class="exzoom_prev_btn"> < </a>
                            <a href="javascript:void(0);" class="exzoom_next_btn"> > </a>
                        </p>  
                        </div>
<!--                       
                            <div class="product-gallery">
                           
                                <div class="flexslider-thumbnails">
                                    <ul>
                                    </ul>
                                </div>
                                {{-- @if($product_detail->images_option==1)
                                @php
                                $products_images=DB::table('products_images')->where('product_id',$product_detail->id)->get();
                                if($products_images){
                                $products_images=$products_images;
                                }else{
                                $products_images=null;
                                }
                                @endphp --}}
                                <div id="content-wrapper">
                                    <div class="column">
                                        <img id="featured"
                                            {{-- src="{{asset('products/images/products/'.$product_detail->photo)}}"><br><br> --}}
                                        <div id="slide-wrapper">
                                            <img id="slideLeft" class="arrow"
                                                {{-- src="{{asset('products/cartimage/arrow-left.png')}}"> --}}
                                            <div id="slider">
                                                {{-- @foreach($products_images as $products_image) --}}
                                                <img class="thumbnail"
                                                    {{-- src="{{ asset('products/images/productsimages/'.$products_image->images)}}"> --}}
                                                {{-- @endforeach --}}
                                            </div>
                                            <img id="slideRight" class="arrow"
                                                {{-- src=" {{asset('products/cartimage/arrow-right.png')}}"> --}}
                                        </div>
                                    </div>
                                </div>
                                {{-- @endif --}}
                            </div> -->
                            <!-- End Product slider -->
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="product-des">
                                <!-- Description -->
                                <div class="short">
                                    <h4>{{$product_detail->title}}</h4>
                                    <div class="rating-main">
                                        <ul class="rating">
                                            @php
                                            $rate=ceil($product_detail->getReview->avg('rate'))
                                            @endphp
                                            @for($i=1; $i<=5; $i++) @if($rate>=$i)
                                                <li><i class="fa fa-star"></i></li>
                                                @else
                                                <li><i class="fa fa-star-o"></i></li>
                                                @endif
                                                @endfor
                                        </ul>
                                        <a href="#" class="total-review">({{$product_detail['getReview']->count()}})
                                            Review</a>
                                    </div>
                                    @php
                                    $after_discount=($product_detail->price-(($product_detail->price*$product_detail->discount)/100));
                                    @endphp
                                    <p class="price"><span
                                            class="discount">{{number_format($after_discount,2)}}</span><s>{{number_format($product_detail->price,2)}}</s>
                                    </p>
                                    <p class="description">{!!($product_detail->summary)!!}</p>
                                </div>
                                <!--/ End Description -->
                                <!-- Color -->
                                <div class="color">
                                    <ul>
                                        <input type="hidden" name="slug" value="{{$product_detail->slug}}">
                                        <input type="hidden" name="quant[1]" class="input-number" data-min="1"
                                            data-max="1000" value="1" id="quantity">
                                        <input type="hidden" value="{{$product_detail->id}}" name="product_id" />
                                        <table>
                                            <tr>
                                                @if($product_detail->size_option==1)
                                                @php
                                                $sizes=DB::table('sizes')->where('product_id',$product_detail->id)->get();
                                                if($sizes){
                                                $sizes=$sizes;
                                                }else{
                                                $sizes=null;
                                                }
                                                @endphp
                                                <td>
                                                    <label>Sizes :</label>
                                                </td>
                                                <td>
                                                    <select name="size_id" class="pull-right" style="display: none;">
                                                        @foreach($sizes as $size)
                                                        <option value="{{$size->id}}">{{$size->title}} </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                @else
                                                <td><input type="hidden" value="0" name="size_id" /></td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if($product_detail->choice_option==1)
                                                @php
                                                $choices=DB::table('choices')->where('product_id',$product_detail->id)->get();
                                                if($choices){
                                                $choices=$choices;
                                                }else{
                                                $choices=null;
                                                }
                                                @endphp
                                                <td>
                                                    <label>Variations :</label>
                                                </td>
                                                <td>
                                                    <select name='choice_id' class="pull-right" style="display: none;">
                                                        @foreach($choices as $choice)
                                                        <option value="{{$choice->id}}">{{$choice->color_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                @else
                                                <td><input type="hidden" value="0" name="choice_id" /></td>
                                                @endif
                                            </tr>
                                        </table>
                                    </ul>
                                </div>
                                <!--/ End Color -->
                                <!-- Product Buy -->
                                <div class="product-buy">
                                    <form action="{{route('single-add-to-cart')}}" method="POST">
                                        @csrf
                                        <div class="quantity">
                                            <h6>Quantity :</h6>
                                            <!-- Input Order -->
                                            <div class="input-group">
                                                <div class="button minus">
                                                    <button type="button" class="btn btn-primary btn-number"
                                                        disabled="disabled" data-type="minus" data-field="quant[1]">
                                                        <i class="ti-minus"></i>
                                                    </button>
                                                </div>
                                                <input type="hidden" name="slug" value="{{$product_detail->slug}}">
                                                <input type="text" name="quant[1]" class="input-number" data-min="1"
                                                    data-max="1000" value="1" id="quantity">
                                                <div class="button plus">
                                                    <button type="button" class="btn btn-primary btn-number"
                                                        data-type="plus" data-field="quant[1]">
                                                        <i class="ti-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <!--/ End Input Order -->
                                        </div>
                                        <div class="add-to-cart mt-4">
                                            <button type="submit" name="btn_add_to_cart" class="btn btn-lg min"
                                                title="Add to cart">Add to cart</button>
                                            <!-- <a href="{{route('add-to-wishlist',$product_detail->slug)}}?k={{request()->get('k')}}"
                                                class="btn btn-lg min"><i class="ti-heart"></i></a> -->
                                        </div>
                                        <p class="cat">Category :<a
                                                href="{{route('product-cat',$product_detail->cat_info['slug'])}}">{{$product_detail->cat_info['title']}}</a>
                                        </p>
                                        @if($product_detail->sub_cat_info)
                                        <p class="cat mt-1">Sub Category :<a
                                                href="{{route('product-sub-cat',[$product_detail->cat_info['slug'],$product_detail->sub_cat_info['slug']])}}">{{$product_detail->sub_cat_info['title']}}</a>
                                        </p>
                                        @endif
                                        <p class="availability">Stock : @if($product_detail->stock>0)<span
                                                class="badge badge-success">{{$product_detail->stock}}</span>@else <span
                                                class="badge badge-danger">{{$product_detail->stock}}</span> @endif</p>
                                </div>
                                <!--/ End Product Buy -->
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-12">
                        <div class="product-info">
                            <div class="nav-main">
                                <!-- Tab Nav -->
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item"><a class="nav-link active" data-toggle="tab"
                                            href="#description" role="tab">Description</a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#reviews"
                                            role="tab">Reviews</a></li>
                                </ul>
                                <!--/ End Tab Nav -->
                            </div>
                            <div class="tab-content" id="myTabContent">
                                <!-- Description Tab -->
                                <div class="tab-pane fade show active" id="description" role="tabpanel">
                                    <div class="tab-single">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="single-des">
                                                    <p>{!! ($product_detail->description) !!}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--/ End Description Tab -->
                                <!-- Reviews Tab -->
                                <div class="tab-pane fade" id="reviews" role="tabpanel">
                                    <div class="tab-single review-panel">
                                        <div class="row">
                                            <div class="col-12">
                                                <!-- Review -->
                                                <div class="comment-review">
                                                    <div class="add-review">
                                                        <h5>Add A Review</h5>
                                                        <p>Your email address will not be published. Required fields are
                                                            marked</p>
                                                    </div>
                                                    <h4>Your Rating <span class="text-danger">*</span></h4>
                                                    <div class="review-inner">
                                                        <!-- Form -->
                                                        @auth
                                                        <form class="form" method="post"
                                                            action="{{route('review.store',$product_detail->slug)}}">
                                                            @csrf
                                                            <div class="row">
                                                                <div class="col-lg-12 col-12">
                                                                    <div class="rating_box">
                                                                        <div class="star-rating">
                                                                            <div class="star-rating__wrap">
                                                                                <input class="star-rating__input"
                                                                                    id="star-rating-5" type="radio"
                                                                                    name="rate" value="5">
                                                                                <label
                                                                                    class="star-rating__ico fa fa-star-o"
                                                                                    for="star-rating-5"
                                                                                    title="5 out of 5 stars"></label>
                                                                                <input class="star-rating__input"
                                                                                    id="star-rating-4" type="radio"
                                                                                    name="rate" value="4">
                                                                                <label
                                                                                    class="star-rating__ico fa fa-star-o"
                                                                                    for="star-rating-4"
                                                                                    title="4 out of 5 stars"></label>
                                                                                <input class="star-rating__input"
                                                                                    id="star-rating-3" type="radio"
                                                                                    name="rate" value="3">
                                                                                <label
                                                                                    class="star-rating__ico fa fa-star-o"
                                                                                    for="star-rating-3"
                                                                                    title="3 out of 5 stars"></label>
                                                                                <input class="star-rating__input"
                                                                                    id="star-rating-2" type="radio"
                                                                                    name="rate" value="2">
                                                                                <label
                                                                                    class="star-rating__ico fa fa-star-o"
                                                                                    for="star-rating-2"
                                                                                    title="2 out of 5 stars"></label>
                                                                                <input class="star-rating__input"
                                                                                    id="star-rating-1" type="radio"
                                                                                    name="rate" value="1">
                                                                                <label
                                                                                    class="star-rating__ico fa fa-star-o"
                                                                                    for="star-rating-1"
                                                                                    title="1 out of 5 stars"></label>
                                                                                @error('rate')
                                                                                <span
                                                                                    class="text-danger">{{$message}}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12 col-12">
                                                                    <div class="form-group">
                                                                        <label>Write a review</label>
                                                                        <textarea name="review" rows="6"
                                                                            placeholder=""></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12 col-12">
                                                                    <div class="form-group button5">
                                                                        <button type="submit"
                                                                            class="btn">Submit</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                        @else
                                                        <p class="text-center p-5">
                                                            You need to <a href="{{route('login')}}"
                                                                style="color:rgb(54, 54, 204)">Login</a> OR <a
                                                                style="color:blue"
                                                                href="{{route('register.form')}}">Register</a>
                                                        </p>
                                                        <!--/ End Form -->
                                                        @endauth
                                                    </div>
                                                </div>
                                                <div class="ratting-main">
                                                    <div class="avg-ratting">
                                                        {{-- @php 
                                                         $rate=0;
                                                         foreach($product_detail->rate as $key=>$rate){
                                                          $rate +=$rate
                                                        }
@endphp --}}
                                                        <h4>{{ceil($product_detail->getReview->avg('rate'))}}
                                                            <span>(Overall)</span>
                                                        </h4>
                                                        <span>Based on {{$product_detail->getReview->count()}}
                                                            Comments</span>
                                                    </div>
                                                    @foreach($product_detail['getReview'] as $data)
                                                    <!-- Single Rating -->
                                                    <div class="single-rating">
                                                        <div class="rating-author">
                                                            @if($data->user_info['photo'])
                                                            <img class="img-profile rounded-circle"
                                                                src="{{asset('products/images/profile/'.$data->user_info['photo'])}}"
                                                                alt="{{$data->user_info['photo']}}">
                                                            @else
                                                            <img src="{{asset('backend/img/avatar.png')}}"
                                                                alt="Profile.jpg">
                                                            @endif
                                                        </div>
                                                        <div class="rating-des">
                                                            <h6>{{$data->user_info['name']}}</h6>
                                                            <div class="ratings">
                                                                <ul class="rating">
                                                                    @for($i=1; $i<=5; $i++) @if($data->rate>=$i)
                                                                        <li><i class="fa fa-star"></i></li>
                                                                        @else
                                                                        <li><i class="fa fa-star-o"></i></li>
                                                                        @endif
                                                                        @endfor
                                                                </ul>
                                                                <div class="rate-count">(<span>{{$data->rate}}</span>)
                                                                </div>
                                                            </div>
                                                            <p>{{$data->review}}</p>
                                                        </div>
                                                    </div>
                                                    <!--/ End Single Rating -->
                                                    @endforeach
                                                </div>
                                                <!-- End Review -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--/ End Reviews Tab -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--/ End Shop Single -->
<!-- Start Most Popular -->
<div class="product-area most-popular related-product section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>Related Products</h2>
                </div>
            </div>
        </div>
        <div class="row">
            {{-- {{$product_detail->rel_prods}} --}}
            <div class="col-12">
                <div class="owl-carousel popular-slider">
                    @foreach($product_detail->rel_prods as $data)
                    @if($data->id !==$product_detail->id)
                    <form action="{{route('add-to-cart',$product_detail->id)}}" method="POST">
                        {{csrf_field()}}
                        <!-- Start Single Product -->
                        <div class="single-product">
                            <div class="product-img">
                                <a href="{{route('product-detail',$data->slug)}}?k={{request()->get('k')}}">
                                    @php
                                    $photo=explode(',',$data->photo);
                                    @endphp
                                    <img class="default-img" src="{{ asset('products/images/products/'.$photo[0] )}}"
                                        alt="{{$photo[0]}}">
                                    <!-- <img class="hover-img" src="{{$photo[0]}}" alt="{{$photo[0]}}"> -->
                                    <span class="price-dec">{{$data->discount}} % Off</span>
                                    {{-- <span class="out-of-stock">Hot</span> --}}
                                </a>
                                <div class="button-head">
                                    <!--<div class="product-action">
<a data-toggle="modal" data-target="#{{$product_detail}}" title="Quick View"
href="#"><i class=" ti-eye"></i><span>Quick Shop</span></a>
<a title="Wishlist" href="{{route('add-to-wishlist',$product_detail)}}"
class="wishlist" data-id="{{$product_detail}}"><i
class=" ti-heart "></i><span>Add to Wishlist</span></a>
</div> -->
                                    <div class="product-action-2">
                                        <button type="submit" name="btn_add_to_cart" class="btn-warning btn-sm min"
                                            title="Add to cart">Add to cart</button>
                                    </div>
                                </div>
                            </div>
                            <div class="product-content">
                                <h3><a href="{{route('product-detail',$data->slug)}}?k={{request()->get('k')}}">{{$data->title}}</a></h3>
                                <div class="product-price">
                                    @php
                                    $after_discount=($data->price-(($data->discount*$data->price)/100));
                                    @endphp
                                    <span class="old">${{number_format($data->price,2)}}</span>
                                    <span>${{number_format($after_discount,2)}}</span>
                                </div>
                            </div>
                        </div><input type="hidden" value="{{$product_detail->id}}" name="product_id" />
                        <table style="margin-left:13px;">
                            <tr>
                                @if($product_detail->size_option==1)
                                @php
                                $sizes=DB::table('sizes')->where('product_id',$product_detail->id)->get();
                                if($sizes){
                                $sizes=$sizes;
                                }else{
                                $sizes=null;
                                }
                                @endphp
                                <td>
                                    <label>Sizes :</label>
                                </td>
                                <td>
                                    <select name="size_id" class="pull-right" style="display: none;">
                                        @foreach($sizes as $size)
                                        <option value="{{$size->id}}">{{$size->title}} </option>
                                        @endforeach
                                    </select>
                                </td>
                                @else
                                <td><input type="hidden" value="0" name="size_id" /></td>
                                @endif
                            </tr>
                            <tr>
                                @if($product_detail->choice_option==1)
                                @php $choices=DB::table('choices')->where('product_id',$product_detail->id)->get();
                                if($choices){
                                $choices=$choices;
                                }else{
                                $choices=null;
                                }
                                @endphp
                                <td>
                                    <label>Variations :</label>
                                </td>
                                <td>
                                    <select name='choice_id' class="pull-right" style="display: none;">
                                        @foreach($choices as $choice)
                                        <option value="{{$choice->id}}">{{$choice->color_name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                @else
                                <td><input type="hidden" value="0" name="choice_id" /></td>
                                @endif
                            </tr>
                        </table>
                        <!-- End Single Product -->
                    </form>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Most Popular Area -->
<!-- Modal -->
<div class="modal fade" id="modelExample" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="ti-close"
                        aria-hidden="true"></span></button>
            </div>
            <div class="modal-body">
                <div class="row no-gutters">
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <!-- Product Slider -->
                        <div class="product-gallery">
                            <div class="quickview-slider-active">
                                <div class="single-slider">
                                    <img src="images/modal1.png" alt="#">
                                </div>
                                <div class="single-slider">
                                    <img src="images/modal2.png" alt="#">
                                </div>
                                <div class="single-slider">
                                    <img src="images/modal3.png" alt="#">
                                </div>
                                <div class="single-slider">
                                    <img src="images/modal4.png" alt="#">
                                </div>
                            </div>
                        </div>
                        <!-- End Product slider -->
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <div class="quickview-content">
                            <h2>Flared Shift Dress</h2>
                            <div class="quickview-ratting-review">
                                <div class="quickview-ratting-wrap">
                                    <div class="quickview-ratting">
                                        <i class="yellow fa fa-star"></i>
                                        <i class="yellow fa fa-star"></i>
                                        <i class="yellow fa fa-star"></i>
                                        <i class="yellow fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <a href="#"> (1 customer review)</a>
                                </div>
                                <div class="quickview-stock">
                                    <span><i class="fa fa-check-circle-o"></i> in stock</span>
                                </div>
                            </div>
                            <h3>$29.00</h3>
                            <div class="quickview-peragraph">
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia iste laborum ad
                                    impedit pariatur esse optio tempora sint ullam autem deleniti nam in quos qui nemo
                                    ipsum numquam.</p>
                            </div>
                            <div class="size">
                                <div class="row">
                                    <div class="col-lg-6 col-12">
                                        <h5 class="title">Size</h5>
                                        <select>
                                            <option selected="selected">s</option>
                                            <option>m</option>
                                            <option>l</option>
                                            <option>xl</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <h5 class="title">Color</h5>
                                        <select>
                                            <option selected="selected">orange</option>
                                            <option>purple</option>
                                            <option>black</option>
                                            <option>pink</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="quantity">
                                <!-- Input Order -->
                                <div class="input-group">
                                    <div class="button minus">
                                        <button type="button" class="btn btn-primary btn-number" disabled="disabled"
                                            data-type="minus" data-field="quant[1]">
                                            <i class="ti-minus"></i>
                                        </button>
                                    </div>
                                    <input type="text" name="qty" class="input-number" data-min="1" data-max="1000"
                                        value="1">
                                    <div class="button plus">
                                        <button type="button" class="btn btn-primary btn-number" data-type="plus"
                                            data-field="quant[1]">
                                            <i class="ti-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <!--/ End Input Order -->
                            </div>
                            <div class="add-to-cart">
                                <a href="#" class="btn">Add to cart</a>
                                <!-- <a href="#" class="btn min"><i class="ti-heart"></i></a>
                                <a href="#" class="btn min"><i class="fa fa-compress"></i></a> -->
                            </div>
                            <div class="default-social">
                                <h4 class="share-now">Share:</h4>
                                <ul>
                                    <li><a class="facebook" href="#"><i class="fa fa-facebook"></i></a></li>
                                    <li><a class="twitter" href="#"><i class="fa fa-twitter"></i></a></li>
                                    <li><a class="youtube" href="#"><i class="fa fa-pinterest-p"></i></a></li>
                                    <li><a class="dribbble" href="#"><i class="fa fa-google-plus"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal end -->

@endsection
@push('styles')
<style>
/* Rating */
.rating_box {
    display: inline-flex;
}

.star-rating {
    font-size: 0;
    padding-left: 10px;
    padding-right: 10px;
}

.star-rating__wrap {
    display: inline-block;
    font-size: 1rem;
}

.star-rating__wrap:after {
    content: "";
    display: table;
    clear: both;
}

.star-rating__ico {
    float: right;
    padding-left: 2px;
    cursor: pointer;
    color: #F7941D;
    font-size: 16px;
    margin-top: 5px;
}

.star-rating__ico:last-child {
    padding-left: 0;
}

.star-rating__input {
    display: none;
}

.star-rating__ico:hover:before,
.star-rating__ico:hover~.star-rating__ico:before,
.star-rating__input:checked~.star-rating__ico:before {
    content: "\F005";
}
</style>
@endpush
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="jquery.exzoom.js"></script>
<script type="text/javascript">
    $(function(){

$("#exzoom").exzoom({
  // options here
});

});
</script>

<script>
    ;(function ($, window) {
    let ele = null,
        exzoom_img_box = null,
        boxWidth = null,
        boxHeight = null,
        exzoom_img_ul_outer = null,//用于限制 ul 宽度,又不影响放大镜区域
        exzoom_img_ul = null,
        exzoom_img_ul_position = 0,//循环图片区域的边距,用于移动时跟随光标
        exzoom_img_ul_width = 0,//循环图片区域的最大宽度
        exzoom_img_ul_max_margin = 0,//循环图片区域的最大外边距,应该是图片数量减一乘以boxWidth
        exzoom_nav = null,
        exzoom_nav_inner = null,
        navHightClass = "current",//当前图片的类,
        exzoom_navSpan = null,
        navHeightWithBorder = null,
        images = null,
        exzoom_prev_btn = null,//导航上一张图片
        exzoom_next_btn = null,//导航下一张图片
        imgNum = 0,//图片的数量
        imgIndex = 0,//当前图片的索引
        imgArr = [],//图片属性的数字
        exzoom_zoom = null,
        exzoom_main_img = null,
        exzoom_zoom_outer = null,
        exzoom_preview = null,//预览区域
        exzoom_preview_img = null,//预览区域的图片
        autoPlayInterval = null,//用于控制自动播放的间隔时间
        startX = 0,//移动光标的起始坐标
        startY = 0,//移动光标的起始坐标
        endX = 0,//移动光标的终止坐标
        endY = 0,//移动光标的终止坐标
        g = {},//全局变量
        defaults = {
            "navWidth": 60,//列表每个宽度,该版本中请把宽高填写成一样
            "navHeight": 60,//列表每个高度,该版本中请把宽高填写成一样
            "navItemNum": 5,//列表显示个数
            "navItemMargin": 7,//列表间隔
            "navBorder": 1,//列表边框，没有边框填写0，边框在css中修改
            "autoPlay": true,//是否自动播放
            "autoPlayTimeout": 2000,//播放间隔时间
        };


    let methods = {
        init: function (options) {
            let opts = $.extend({}, defaults, options);

            ele = this;
            exzoom_img_box = ele.find(".exzoom_img_box");
            exzoom_img_ul = ele.find(".exzoom_img_ul");
            exzoom_nav = ele.find(".exzoom_nav");
            exzoom_prev_btn = ele.find(".exzoom_prev_btn");//缩略图导航上一张按钮
            exzoom_next_btn = ele.find(".exzoom_next_btn");//缩略图导航下一张按钮

            //todo 以后可以分开宽度和高度的限制
            boxHeight = boxWidth = ele.outerWidth();  //在小屏幕中,有 padding 的情况下,计算不准,需要手动指定 ele 的宽度

            // console.log("boxWidth::" + boxWidth);
            // console.log("ele.parent().width()::" + ele.parent().width());
            // console.log("ele.parent().outerWidth()::" + ele.parent().outerWidth());
            // console.log("ele.parent().innerWidth()::" + ele.parent().innerWidth());

            //todo 缩略图导航的高度和宽度可以改为根据 导航栏宽度 和 navItemNum 计算出来,但是对于不同尺寸的不好处理
            g.navWidth = opts.navWidth;
            g.navHeight = opts.navHeight;
            g.navBorder = opts.navBorder;
            g.navItemMargin = opts.navItemMargin;
            g.navItemNum = opts.navItemNum;
            g.autoPlay = opts.autoPlay;
            g.autoPlayTimeout = opts.autoPlayTimeout;

            images = exzoom_img_box.find("img");
            imgNum = images.length;//图片的数量
            checkLoadedAllImages(images)//检查图片是否健在完成,全部加载完成的会执行初始化
        },
        prev: function () {             //上一张图片
            moveLeft()
        },
        next: function () {            //下一张图片
            moveRight();
        },
        setImg: function () {            //设置大图
            let url = arguments[0];

            getImageSize(url, function (width, height) {
                exzoom_preview_img.attr("src", url);
                exzoom_main_img.attr("src", url);

                //todo 未测试
                //判断已有的图片数量是否合最初的一致,不是的话就先删除最后一个
                if (exzoom_img_ul.find("li").length === imgNum + 1) {
                    exzoom_img_ul.find("li:last").remove();
                }
                exzoom_img_ul.append('<li style="width: ' + boxWidth + 'px;">' +
                    '<img src="' + url + '"></li>');

                let image_prop = copute_image_prop(url, width, height);
                previewImg(image_prop);
            });
        },
    };

    $.fn.extend({
        "exzoom": function (method, options) {
            if (arguments.length === 0 || (typeof method === 'object' && !options)) {
                if (this.length === 0) {
                    // alert("调用 jQuery.exzomm 时的选择器为空");
                    $.error('Selector is empty when call jQuery.exzomm');
                } else {
                    return methods.init.apply(this, arguments);
                }
            } else if (methods[method]) {
                return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
            } else {
                // alert("调用了 jQuery.exzomm 中不存在的方法");
                $.error('Method ' + method + 'does not exist on jQuery.exzomm');
            }
        }
    });

    /**
     * 初始化
     */
    function init() {
        exzoom_img_box.append("<div class='exzoom_img_ul_outer'></div>");
        exzoom_nav.append("<p class='exzoom_nav_inner'></p>");
        exzoom_img_ul_outer = exzoom_img_box.find(".exzoom_img_ul_outer");
        exzoom_nav_inner = exzoom_nav.find(".exzoom_nav_inner");

        //把 exzoom_img_ul 移动到 exzoom_img_ul_outer 里
        exzoom_img_ul_outer.append(exzoom_img_ul);

        //循环所有图片,计算尺寸,添加缩略图导航
        for (let i = 0; i < imgNum; i++) {
            imgArr[i] = copute_image_prop(images.eq(i));//记录图片的尺寸属性等
            console.log(imgArr[i]);
            let li = exzoom_img_ul.find("li").eq(i);
            li.css("width", boxWidth);//设置图片上级的 li 元素的宽度
            li.find("img").css({
                "margin-top": imgArr[i][5],
                "width": imgArr[i][3]
            });
        }

        //缩略图导航
        exzoom_navSpan = exzoom_nav.find("span");
        navHeightWithBorder = g.navBorder * 2 + g.navHeight;
        g.exzoom_navWidth = (navHeightWithBorder + g.navItemMargin) * g.navItemNum;
        g.exzoom_nav_innerWidth = (navHeightWithBorder + g.navItemMargin) * imgNum;

        exzoom_navSpan.eq(imgIndex).addClass(navHightClass);
        exzoom_nav.css({
            "height": navHeightWithBorder + "px",
            "width": boxWidth - exzoom_prev_btn.width() - exzoom_next_btn.width(),
        });
        exzoom_nav_inner.css({
            "width": g.exzoom_nav_innerWidth + "px"
        });
        exzoom_navSpan.css({
            "margin-left": g.navItemMargin + "px",
            "width": g.navWidth + "px",
            "height": g.navHeight + "px",
        });

        //设置滚动区域的宽度
        exzoom_img_ul_width = boxWidth * imgNum;
        exzoom_img_ul_max_margin = boxWidth * (imgNum - 1);
        exzoom_img_ul.css("width", exzoom_img_ul_width);
        //添加放大镜
        exzoom_img_box.append(`
<div class='exzoom_zoom_outer'>
    <span class='exzoom_zoom'></span>
</div>
<p class='exzoom_preview'>
    <img class='exzoom_preview_img' src='' />
</p>
            `);
        exzoom_zoom = exzoom_img_box.find(".exzoom_zoom");
        exzoom_main_img = exzoom_img_box.find(".exzoom_main_img");
        exzoom_zoom_outer = exzoom_img_box.find(".exzoom_zoom_outer");
        exzoom_preview = exzoom_img_box.find(".exzoom_preview");
        exzoom_preview_img = exzoom_img_box.find(".exzoom_preview_img");

        //设置大图和预览图区域
        exzoom_img_box.css({
            "width": boxHeight + "px",
            "height": boxHeight + "px",
        });

        exzoom_img_ul_outer.css({
            "width": boxHeight + "px",
            "height": boxHeight + "px",
        });

        exzoom_preview.css({
            "width": boxHeight + "px",
            "height": boxHeight + "px",
            "left": boxHeight + 5 + "px",//添加个边距
        });

        previewImg(imgArr[imgIndex]);
        autoPlay();//自动播放
        bindingEvent();//绑定事件
    }

    /**
     * 检测图片是否加载完成
     * @param images
     */
    function checkLoadedAllImages(images) {
        let timer = setInterval(function () {
            let loaded_images_counter = 0;
            let all_images_num = images.length;
            images.each(function () {
                if (this.complete) {
                    loaded_images_counter++;
                }
            });
            if (loaded_images_counter === all_images_num) {
                clearInterval(timer);
                init();
            }
        }, 100)
    }

    /**
     * 获取光标坐标,如果是 touch 事件,只处理第一个
     */
    function getCursorCoords(event) {
        let e = event || window.event;
        let coords_data = e, //记录坐标的数据,默认为 event 本身,移动端的 touch 会修改
            x,//x 轴
            y;//y 轴

        if (e["touches"] !== undefined) {
            if (e["touches"].length > 0) {
                coords_data = e["touches"][0];
            }
        }

        x = coords_data.clientX || coords_data.pageX;
        y = coords_data.clientY || coords_data.pageY;

        return {'x': x, 'y': y}
    }

    /**
     * 检查移动端触摸滑动的位置
     */
    function checkNewPositionLimit(new_position) {
        if (-new_position > exzoom_img_ul_max_margin) {
            //限制向右的范围
            new_position = -exzoom_img_ul_max_margin;
            imgIndex = 0;//向右超出范围的回到第一个
        } else if (new_position > 0) {
            //限制向左的范围
            new_position = 0;
        }
        return new_position
    }

    /**
     * 绑定各种事件
     */
    function bindingEvent() {
        //移动端大图区域的 touchend 事件
        exzoom_img_ul.on("touchstart", function (event) {
            let coords = getCursorCoords(event);
            startX = coords.x;
            startY = coords.y;

            let left = exzoom_img_ul.css("left");
            exzoom_img_ul_position = parseInt(left);

            window.clearInterval(autoPlayInterval);//停止自动播放
        });

        //移动端大图区域的 touchmove 事件
        exzoom_img_ul.on("touchmove", function (event) {
            let coords = getCursorCoords(event);
            let new_position;
            endX = coords.x;
            endY = coords.y;

            //只跟随光标移动
            new_position = exzoom_img_ul_position + endX - startX;
            new_position = checkNewPositionLimit(new_position);
            exzoom_img_ul.css("left", new_position);

        });

        //移动端大图区域的 touchend 事件
        exzoom_img_ul.on("touchend", function (event) {
            //触屏滑动,根据移动方向按倍数对齐元素
            console.log(endX < startX);
            if (endX < startX) {
                //向左滑动
                moveRight();
            } else if (endX > startX) {
                //向右滑动
                moveLeft();
            }

            autoPlay();//恢复自动播放
        });

        //大屏幕在放大区域点击,判断向左还是向右移动
        exzoom_zoom_outer.on("mousedown", function (event) {
            let coords = getCursorCoords(event);
            startX = coords.x;
            startY = coords.y;

            let left = exzoom_img_ul.css("left");
            exzoom_img_ul_position = parseInt(left);
        });

        exzoom_zoom_outer.on("mouseup", function (event) {
            let offset = ele.offset();

            if (startX - offset.left < boxWidth / 2) {
                //在放大镜的左半部分点击
                moveLeft();
            } else if (startX - offset.left > boxWidth / 2) {
                //在放大镜的右半部分点击
                moveRight();
            }
        });

        //进入 exzoom 停止自动播放
        ele.on("mouseenter", function () {
            window.clearInterval(autoPlayInterval);//停止自动播放
        });
        //离开 exzoom 开始自动播放
        ele.on("mouseleave", function () {
            autoPlay();//恢复自动播放
        });

        //大屏幕进入大图区域
        exzoom_zoom_outer.on("mouseenter", function () {
            exzoom_zoom.css("display", "block");
            exzoom_preview.css("display", "block");
        });

        //大屏幕在大图区域移动
        exzoom_zoom_outer.on("mousemove", function (e) {
            let width_limit = exzoom_zoom.width() / 2,
                max_X = exzoom_zoom_outer.width() - width_limit,
                max_Y = exzoom_zoom_outer.height() - width_limit,
                current_X = e.pageX - exzoom_zoom_outer.offset().left,
                current_Y = e.pageY - exzoom_zoom_outer.offset().top,
                move_X = current_X - width_limit,
                move_Y = current_Y - width_limit;

            if (current_X <= width_limit) {
                move_X = 0;
            }
            if (current_X >= max_X) {
                move_X = max_X - width_limit;
            }
            if (current_Y <= width_limit) {
                move_Y = 0;
            }
            if (current_Y >= max_Y) {
                move_Y = max_Y - width_limit;
            }
            exzoom_zoom.css({"left": move_X + "px", "top": move_Y + "px"});

            exzoom_preview_img.css({
                "left": -move_X * exzoom_preview.width() / exzoom_zoom.width() + "px",
                "top": -move_Y * exzoom_preview.width() / exzoom_zoom.width() + "px"
            });
        });

        //大屏幕离开大图区域
        exzoom_zoom_outer.on("mouseleave", function () {
            exzoom_zoom.css("display", "none");
            exzoom_preview.css("display", "none");
        });

        //大屏幕光宝进入放大预览区域
        exzoom_preview.on("mouseenter", function () {
            exzoom_zoom.css("display", "none");
            exzoom_preview.css("display", "none");
        });

        //缩略图导航
        exzoom_next_btn.on("click", function () {
            moveRight();
        });
        exzoom_prev_btn.on("click", function () {
            moveLeft();
        });

        exzoom_navSpan.hover(function () {
            imgIndex = $(this).index();
            move(imgIndex);
        });
    }

    /**
     * 聚焦在导航图片上,左右移动都会调用
     * @param direction: 方向,right | left,必填
     */
    function move(direction) {
        if (typeof direction === "undefined") {
            alert("exzoom 中的 move 函数的 direction 参数必填");
        }
        //如果超出图片数量了,返回第一张
        if (imgIndex > imgArr.length - 1) {
            imgIndex = 0;
        }

        //设置高亮
        exzoom_navSpan.eq(imgIndex).addClass(navHightClass).siblings().removeClass(navHightClass);

        //判断缩略图导航是否需要重新设置偏移量
        let exzoom_nav_width = exzoom_nav.width();
        let nav_item_width = g.navItemMargin + g.navWidth + g.navBorder * 2; // 单个导航元素的宽度
        let new_nav_offset = 0;

        //直接对比当前索引的图片占据的宽度和exzoom的宽度的差作为偏移量即可
        let temp = nav_item_width * (imgIndex + 1);
        if (temp > exzoom_nav_width) {
            new_nav_offset =  boxWidth - temp;
        }

        exzoom_nav_inner.css({
            "left": new_nav_offset
        });

        //切换大图
        let new_position = -boxWidth * imgIndex;
        //在 animate 方法前先调用 stop() ,避免反应迟钝
        new_position = checkNewPositionLimit(new_position);
        exzoom_img_ul.stop().animate({"left": new_position}, 500);
        //处理放大区域
        previewImg(imgArr[imgIndex]);
    }

    /**
     * 导航向右
     */
    function moveRight() {
        imgIndex++;//先增加 index,后面判断范围
        if (imgIndex > imgNum) {
            imgIndex = imgNum;
        }
        move("right");
    }

    /**
     * 导航向左
     */
    function moveLeft() {
        imgIndex--;//先减少 index,后面判断范围
        if (imgIndex < 0) {
            imgIndex = 0;
        }
        move("left");
    }

    /**
     * 自动播放
     */
    function autoPlay() {
        if (g.autoPlay) {
            autoPlayInterval = window.setInterval(function () {
                if (imgIndex >= imgNum) {
                    imgIndex = 0;
                }
                imgIndex++;
                move("right");
            }, g.autoPlayTimeout);
        }
    }

    /**
     * 预览图片
     */
    function previewImg(image_prop) {
        if (image_prop === undefined) {
            return
        }
        exzoom_preview_img.attr("src", image_prop[0]);

        exzoom_main_img.attr("src", image_prop[0])
            .css({
                "width": image_prop[3] + "px",
                "height": image_prop[4] + "px"
            });
        exzoom_zoom_outer.css({
            "width": image_prop[3] + "px",
            "height": image_prop[4] + "px",
            "top": image_prop[5] + "px",
            "left": image_prop[6] + "px",
            "position": "relative"
        });
        exzoom_zoom.css({
            "width": image_prop[7] + "px",
            "height": image_prop[7] + "px"
        });
        exzoom_preview_img.css({
            "width": image_prop[8] + "px",
            "height": image_prop[9] + "px"
        });
    }

    /**
     * 获得图片的真实尺寸
     * @param url
     * @param callback
     */
    function getImageSize(url, callback) {
        let img = new Image();
        img.src = url;

        // 如果图片被缓存，则直接返回缓存数据
        if (typeof callback !== "undefined") {
            if (img.complete) {
                callback(img.width, img.height);
            } else {
                // 完全加载完毕的事件
                img.onload = function () {
                    callback(img.width, img.height);
                }
            }
        } else {
            return {
                width: img.width,
                height: img.height
            }
        }
    }

    /**
     * 计算图片属性
     * @param image : jquery 对象或 图片url地址
     * @param width : image 为图片url地址时指定宽度
     * @param height : image 为图片url地址时指定高度
     * @returns {Array}
     */
    function copute_image_prop(image, width, height) {
        let src;
        let res = [];

        if (typeof image === "string") {
            src = image;
        } else {
            src = image.attr("src");
            let size = getImageSize(src);
            width = size.width;
            height = size.height;
        }

        res[0] = src;
        res[1] = width;
        res[2] = height;
        let img_scale = res[1] / res[2];

        if (img_scale === 1) {
            res[3] = boxHeight;//width
            res[4] = boxHeight;//height
            res[5] = 0;//top
            res[6] = 0;//left
            res[7] = boxHeight / 2;
            res[8] = boxHeight * 2;//width
            res[9] = boxHeight * 2;//height
            exzoom_nav_inner.append(`<span><img src="${src}" width="${g.navWidth }" height="${g.navHeight }"/></span>`);
        } else if (img_scale > 1) {
            res[3] = boxHeight;//width
            res[4] = boxHeight / img_scale;
            res[5] = (boxHeight - res[4]) / 2;
            res[6] = 0;//left
            res[7] = res[4] / 2;
            res[8] = boxHeight * 2 * img_scale;//width
            res[9] = boxHeight * 2;//height
            let top = (g.navHeight - (g.navWidth / img_scale)) / 2;
            exzoom_nav_inner.append(`<span><img src="${src}" width="${g.navWidth }" style='top:${top}px;' /></span>`);
        } else if (img_scale < 1) {
            res[3] = boxHeight * img_scale;//width
            res[4] = boxHeight;//height
            res[5] = 0;//top
            res[6] = (boxHeight - res[3]) / 2;
            res[7] = res[3] / 2;
            res[8] = boxHeight * 2;//width
            res[9] = boxHeight * 2 / img_scale;
            let top = (g.navWidth - (g.navHeight * img_scale)) / 2;
            exzoom_nav_inner.append(`<span><img src="${src}" height="${g.navHeight}" style="left:${top}px;"/></span>`);
        }

        return res;
    }

// 闭包结束     
})(jQuery, window);
</script>
{{-- <script>
$('.cart').click(function(){
var quantity=$('#quantity').val();
var pro_id=$(this).data('id');
// alert(quantity);
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
document.location.href=document.location.href;
});
}
}
})
});
</script> --}}




<script type="text/javascript">
let thumbnails = document.getElementsByClassName('thumbnail')
let activeImages = document.getElementsByClassName('active')
for (var i = 0; i < thumbnails.length; i++) {
    thumbnails[i].addEventListener('mouseover', function() {
        console.log(activeImages)

        if (activeImages.length > 0) {
            activeImages[0].classList.remove('active')
        }
        this.classList.add('active')
        document.getElementById('featured').src = this.src
    });
}
let buttonRight = document.getElementById('slideRight');
let buttonLeft = document.getElementById('slideLeft');

buttonLeft.addEventListener('click', function() {
    document.getElementById('slider').scrollLeft -= 180
});
buttonRight.addEventListener('click', function() {
    document.getElementById('slider').scrollLeft += 180
});
</script>

@endpush