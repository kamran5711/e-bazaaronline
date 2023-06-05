<header class="header shop">
    <style>
        ul span.label-default {
            border: 1px solid;
            padding: 1px 2px;
            border-radius: 4px;
        }
        

        .header.shop .header-inner {
            background: #EE4540;
            /* opacity: 0.9; */
            opacity: 1;
            position: relative;
            z-index: 9;
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
                                $getStoreAndUrlBySlug = Helper::getStoreAndUrlBySlug();
                                $store = $getStoreAndUrlBySlug['store'];
                                $last_slug = $getStoreAndUrlBySlug['last_slug'];
                                $store_id = $store->id;
                            @endphp
                            <li><i class="ti-headphone-alt"></i>{{ !is_null($store) ? $store->phone : '' }} </li>
                            <li><i class="ti-email"></i> {{ !is_null($store) ? $store->email : '' }} </li>
                        </ul>
                    </div>
                    <!--/ End Top Left -->
                </div>
                <div class="col-lg-6 col-md-12 col-12">
                    <!-- Top Right -->
                    <div class="right-content">
                        <ul class="list-main">
                            <li><i class="ti-location-pin"></i> <a
                                    href="{{ route('order.track', $last_slug) }}">Track Order</a>
                            </li>
                            {{-- -<li><i class="ti-alarm-clock"></i> <a href="#"></a></li>- --}}
                            @auth
                                @switch(auth()->user()->role_id)
                                    @case(1)
                                        <li><i class="ti-user"></i> <a href="{{ url('superadmin/') }}">Dashboard</a></li>
                                        @break
                                    @case(2)
                                    <li><i class="ti-user"></i> <a href="{{ url('admin/') }}">Dashboard</a></li>
                                        @break
                                    @default
                                    <li><i class="ti-user"></i> <a href="{{ url('customer/') }}">Dashboard</a></li>
                                @endswitch 
                                <li><i class="ti-power-off"></i> <a href="{{ route('logout') }}">Logout</a></li>
                            @else
                                <li><i class="ti-power-off"></i><a
                                        href="{{ route('login') }}">Login /</a> <a
                                        href="{{ URL($last_slug .'/user/register') }}">Register</a>
                                </li>
                            @endauth

                            <li id="cart_info">
                                @include('frontend.layouts.cart-info-view')
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

    <div class="middle-inner">
        <div class="container">
            <div class="row">
                <div class="col-md-2 col-12">
                </div>
                <div class="col-md-8 col-12">
                    <div class="search-bar-top">
                        <div class="search-bar">
                            @php 
                                $categories = App\Models\Category::where('store_id', $store->id)->where('status', 'active')->get(['id', 'title']);
                            @endphp
                            <style>
                                ul.list {
                                    z-index: 15 !important;
                                }
                            </style>
                            <select form="product-search-form" name="category_id">
                                <option selected="selected" value="">All Category</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                                @endforeach

                            </select>

                            <form method="POST" action="{{ route('search.product', [$last_slug])}}" id="product-search-form">
                                @csrf
                                <input name="search" placeholder="Search Products Here....." type="search" required class="form-control">
                                <input type="hidden" name="store_id" value="{{ $store_id }}" />
                                <input type="hidden" name="store_url" value="{{ $last_slug }}" />
                                <button class="btnn" type="submit"><i class="ti-search"></i></button>
                            </form>

                        </div>
                    </div>

                </div>
                <div class="col-md-2 col-12"></div>
            </div>
        </div>
    </div>
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
                                            <li class="{{ Request::path() == 'home' ? 'active' : '' }}"><a
                                                    href="{{url('/store'. '/' .$last_slug)}}">Home</a>
                                            </li>
                                            <li class="{{ Request::path() == 'about-us' ? 'active' : '' }}">
                                                {{-- <a href="{{ route('about-us', ['slug', $last_slug]) }}">About Us</a> --}}
                                                <a href="{{url('/'.$last_slug.'/about-us')}}">About Us</a>
                                            </li>
                                            <li class="{{ (Request::path() == 'product-grids' || Request::path() == 'product-lists') ? 'active' : '' }}"><a
                                                    href="{{ url('/'.$last_slug.'/product-grids')}}">Products</a><span
                                                    class="new">New</span></li>
                                            <li>
                                                <a href="javascript:void(0);">Category<i class="ti-angle-down"></i></a>
                                                <ul class="dropdown">
                                                    @foreach($categories as $cat_info)
                                                        {{-- @if( $cat_info->sub_categories->count() > 0 ) --}}
                                                        <li>
                                                            <a href="{{ url('/'.$last_slug. '/product-category'. '/' . $cat_info->id) }}"><?php echo $cat_info->title; ?></a>
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
                                            @endif
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
