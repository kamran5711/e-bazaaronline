@if (count(session('cart') ? : []) > 0)
@php
    $firstKey = array_key_first(session('cart'));
    $product_id = explode("_", $firstKey);
    $product = \App\Models\Product::with('store')->where('id', $product_id[0])->first();
    $store = $product->store;
    $home_url = $store->slug;
@endphp
{{-- {{ session('cart') ? count(session('cart')) : '' }} --}}
    <div class="sinlge-bar shopping">
        {{-- <a href="{{ URL('/cart') }}"
            class="single-icon"><img src="{{ asset('products/cart.jpg') }}"
                style="height: 35px; weight: 50px;" alt="cart.jpg"> <span
                class="total-count">{{ count(session('cart') ?: []) }}</span>
        </a> --}}
        <a href="javascript:void(0)" class="single-icon">
            <span class="total-count float-right" style="margin-bottom: -13px; position: relative;">{{ count(session('cart') ?: []) }}</span>
            <img src="{{ asset('products/cart.jpg') }}" style="height: 35px; weight: 50px;" alt="cart.jpg">
        </a>
        <!-- Shopping Item -->
        <div class="shopping-item">
            <div class="dropdown-cart-header">
                <span>{{ count(session('cart') ?: []) }} Items</span>
                {{-- <a href="{{ URL('/' . $store->slug . '/cart') }}">View
                    Cart</a> --}}
                <a href="{{ URL('/' . $store->slug . '/cart') }}">View Cart</a>
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
                                class="remove remove-from-cart" id="{{$key}}" title="Remove this item"><i
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
                    <span>Total &nbsp;</span>
                    @php $total_coupons_price = 0; @endphp
                    @if(session()->has('coupons'))
                        @foreach(Session::get('coupons') as $coupon)
                            @php 
                                $total_coupons_price += $coupon['value'];
                            @endphp
                        @endforeach
                    @endif
                    @php
                        $total_amount = session('cart_total');
                        if(session()->has('coupons')){
                            $total_amount = $total_amount - $total_coupons_price;
                        }
                    @endphp

                    <span class="total-aomunt float-right">
                        {{ number_format($total_amount, 2) }}</span>
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
                        <a href="{{ url('/'. $store->slug . '/user/logincheckout') }}"
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

    <script>
        var message_wrapper = document.getElementById('cartFormResponse');
        setTimeout(() => {
            $(".remove-from-cart").click(function(e) {
                var id = this.id;
                var url = '{{ route("cart-delete-ajax", ":id") }}';
                url = url.replace(':id', id);
                $.ajax({
                    type: 'get',
                    url: url,
                    success:function(data) {
                        message_wrapper.innerHTML = `<div class="alert alert-success w-100 mb-3 ml-3 mr-3" id="success-alert">
                                                    <button type="button" class="close" data-dismiss="alert">x</button>
                                                    <strong>Success! </strong> ${data.message}.
                                                </div>`;
                                                $("#success-alert").fadeTo(3000, 500).slideUp(500, function() {
                        $("#success-alert").slideUp(500);
                    });
                        refresh_cart_items_view();
                    }
                });
                return false
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
        }, 1500);
    </script>