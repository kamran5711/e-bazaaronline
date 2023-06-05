<header class="header shop">
    <style>
        ul span.label-default {
            border: 1px solid;
            padding: 1px 2px;
            border-radius: 4px;
        }
        

        .header.shop .header-inner {
            background: #EE4540;
            opacity: 0.9;
        }

        .header.sticky .header-inner {
            color: black;
            background: whitesmoke;
        }

        .header.shop .nav li.active a {
            color: white;
            background: #C72C41;
        }

        .header.shop .nav li a:hover{
            background:#510A32;
        }

        .header.shop .nav li {
            margin-right: 30px;
            position: relative;
            float: none;
        }

        .header.shop .list-main li i{
            color: #C72C41;
        }

        .header.shop .top-left .list-main li i{
            color: #C72C41;
        }

        .header.shop .search-bar .btnn {
            height: 50px;
            background: #EE4540;
            opacity: 0.9;
            line-height: 45px;
            width: 67px;
            text-align: center;
            font-size: 18px;
            color: #fff;
            position: absolute;
            right: -2px;
            top: -1px;
            border: none;
            border-radius: 0 5px 5px 0;
            -webkit-transition: all 0.4s ease;
            -moz-transition: all 0.4s ease;
            transition: all 0.4s ease;
        }

        .header.shop .search-bar .btnn:hover{
           background: #510A32;
        }

    </style>
    <!-- Topbar -->
    <div class="topbar">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-12">
                    <!-- Top Left -->
                    <div class="top-left">
                        <ul class="list-main">
                            @php
                                $user = \App\User::with(['address' => function($query){
                                    $query->with(['country', 'state', 'city']);
                                }])->findOrFail(auth()->user()->id);
                                // dd($user);
                            @endphp
                            <li><i class="ti-headphone-alt"></i>{{ $user->phone }}</li>
                            <li><i class="ti-email"></i>{{ $user->email }}</li>
                        </ul>
                    </div>
                    <!--/ End Top Left -->
                </div>
                @php $home_url = '/'; @endphp
                <div class="col-lg-6 col-md-12 col-12">
                    <!-- Top Right -->
                    <div class="right-content">
                        <ul class="list-main">
                            {{-- <li><i class="ti-location-pin"></i> <a
                                href="{{ route('order.track', $home_url) }}">Track Order</a>
                            </li> --}}
                            {{-- -<li><i class="ti-alarm-clock"></i> <a href="#"></a></li>- --}}
                            @auth
                                <li><i class="ti-power-off"></i> <a href="{{ route('logout') }}">Logout</a></li>
                            @else
                                <li><i class="ti-power-off"></i><a
                                        href="{{ route('login') }}">Login /</a> <a
                                        href="{{ URL('user/register') }}">Register</a>
                                </li>
                            @endauth

                            <li>
                                @if (count(session('cart') ? : []) > 0)
                                @php
                                    $firstKey = array_key_first(session('cart'));
                                    $product_id = explode("_", $firstKey);
                                    $product = \App\Models\Product::with('store')->where('id', $product_id[0])->first();
                                    $store = $product->store;
                                    $home_url = $store->slug;
                                @endphp
                                    <div class="sinlge-bar shopping">
                                        <a href="javascript:void(0)"
                                            class="single-icon"><img src="{{ asset('products/cart.jpg') }}"
                                                style="height: 35px; weight: 50px;" alt="cart.jpg"> <span
                                                class="total-count">{{ count(session('cart') ?: []) }}</span></a>
                                        <!-- Shopping Item -->
                                        <div class="shopping-item">
                                            <div class="dropdown-cart-header">
                                                <span>{{ count(session('cart') ?: []) }} Items</span>
                                                {{-- <a href="{{ URL('/' . $store->slug . '/cart') }}">View
                                                    Cart</a> --}}
                                                <a href="{{ URL('/' . $store->slug . '/checkout') }}">View
                                                    Cart</a>
                                            </div>
                                            <ul class="shopping-list text-center">
                                                @php
                                                $sub_amount = 0;
                                            //    dd(session()->all());
                                                 @endphp 
                                                @if (session('cart'))
                                                    @foreach (session('cart') as $key => $val)
                                                        @php
                                                        if (str_contains($key, '_')) {
                                                                                                                                                                                                                                                                                                            
                                                        $get_product = explode('_', $key);
                                                        }
                                                        $cart = DB::table('products')
                                                        ->where('id', $get_product[0])
                                                        ->first();
                                                        $sale_price = $cart->price;
                                                        if ($cart->discount > 0) {
                                                        $sale_price = $sale_price - ($sale_price * $cart->discount) / 100;
                                                        }
                                                        $sub_amount = $sale_price * round($val['quantity']);
                                                        $get_size = DB::table('sizes')
                                                        ->where('id', $get_product[1])
                                                        ->first();
                                                        $get_choice = DB::table('colors')
                                                        ->where('id', $get_product[2])
                                                        ->first();
                                                        if (session('coupon')) {
                                                        $sub_amount = $sub_amount - session('coupon')['value'];
                                                        }

                                                        @endphp 
                                                        <li style="width: 270px;">
                                                            <a href="{{ URL( '/' . $store->slug . '/cart-delete'.'/'.$key)}}"
                                                                class="remove" title="Remove this item"><i
                                                                    class="fa fa-remove"></i></a>
                                                            <a class="cart-img" href="#"><img
                                                                    src="{{ asset('images/products/' . $cart->photo) }}"
                                                                    alt="{{ $cart->photo }}"></a>
                                                            <h4><a href="{{ URL( $store->slug .'/'. 'product-detail' . '/' . $cart->slug) }}"
                                                                    target="_blank">{{ $cart->title }}</a></h4>
                                                            <span class='label-default'>{{ $get_size->title }}</span>
                                                            <span class='label-default'>{{ $get_choice->title }}</span>
                                                            <p class="quantity">{{ $val['quantity'] }} x -
                                                                <span
                                                                    class="amount">{{ number_format($sale_price, 2) }}</span>
                                                            </p>
                                                        </li>
                                                    @endforeach
                                                @else
                                                    No products in your cart currently.<br><br><a
                                                        href="{{ route('product-grids') }}"
                                                        class="btn-warning btn-sm">Continue shopping</a>
                                                @endif
                                            </ul>
                                            <div class="bottom">
                                                <div class="total">
                                                    <span>Total</span>
                                                    <span class="total-aomunt">
                                                        {{ number_format(session('cart_total'), 2) }}</span>
                                                    <!---<span class="order_subtotal" data-price="{{ Helper::totalCartPrice() }}">{{ number_format(session('cart_total'), 2) }}</span>---->
                                                </div>
                                                @auth
                                                    @if (count(session('cart') ? : []) > 0)
                                                        {{-- <a href="{{url('/' . $store->slug . '/checkout')}}"
                                                            class="btn animate">Checkout</a> --}}
                                                        <a href="{{url('/' . $store->slug . '/cart')}}"
                                                                class="btn animate">Checkout</a>
                                                    @else
                                                        <del><a class="btn animate">Checkout</a></del>
                                                    @endif
                                                @else
                                                    @if (count(session('cart') ?: []) > 0)
                                                        <a href="{{ url('/'. $store->slug . '/user/logincheckout')}}"
                                                            class="btn animate">Checkout</a>
                                                    @else
                                                        <del><a class="btn animate">Checkout</a></del>
                                                    @endif
                                                @endauth
                                            </div>
                                        </div>
                                        <!--/ End Shopping Item -->
                                    </div>
                                @endif
                            </li>

                            {{-- <li class="app-logo">logo</li> --}}
                        </ul>
                    </div>
                    <!-- End Top Right -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Topbar -->
    
    <!-- Header Inner -->
    <div class="header-inner">
        <div class="container">
            <div class="cat-nav-head">
                <div class="row">
                    <div class="col-lg-12 col-12">
                        <div class="menu-area" style="display: flex; justify-content:center;">
                            <!-- Main Menu -->
                            <nav class="navbar navbar-expand-lg">
                                <div class="navbar-collapse">
                                    <div class="nav-inner">
                                        <ul class="nav main-menu menu navbar-nav">
                                            <li>
                                                <a href="{{ URL($home_url) }}">Home</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('customer.index') }}">
                                                    {{-- <i class="ti-truck"></i> --}}
                                                    Orders
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{route('customer.reviews')}}">
                                                    Reviews
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{route('customer.comments')}}">
                                                    Comments
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{route('customer.profile')}}">
                                                    Profile
                                                </a>
                                            </li>
                                            {{-- <li class="{{ Request::path() == 'home' ? 'active' : '' }}"><a
                                                    href="{{url('/store'. '/' .$last_slug)}}">Home</a>
                                            </li>
                                            <li class="{{ Request::path() == 'about-us' ? 'active' : '' }}">
                                                <a href="{{url('/'.$last_slug.'/about-us')}}">About Us</a>
                                            </li>
                                            <li class="{{ (Request::path() == 'product-grids' || Request::path() == 'product-lists') ? 'active' : '' }}"><a
                                                    href="{{ url('/'.$last_slug.'/product-grids')}}">Products</a><span
                                                    class="new">New</span></li>
                                            <li>
                                                <a href="javascript:void(0);">Category<i class="ti-angle-down"></i></a>
                                                <ul class="dropdown">
                                                    @foreach($categories as $cat_info)
                                                        <li>
                                                            <a href="{{ route('product-cat', $cat_info->id) }}"><?php //echo $cat_info->title; ?></a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                            <li class="{{ Request::path() == 'blog' ? 'active' : '' }}"><a
                                                    href="{{url('/'.$last_slug.'/blog')}}">Blog</a>
                                            </li>
                                            @if (\Auth::check())
                                                <li class="{{ Request::path() == 'contact-us' ? 'active' : '' }}"><a
                                                        href="{{ url('/'.$last_slug.'/contact-us') }}">Contact Us</a></li>
                                            @else
                                                <li class="{{ Request::path() == 'contact' ? 'active' : '' }}"><a
                                                        href="{{ route('login') }}">Contact Us</a></li>
                                            @endif --}}
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                            <!--/ End Main Menu -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ End Header Inner -->

    {{-- end --}}
</header>
