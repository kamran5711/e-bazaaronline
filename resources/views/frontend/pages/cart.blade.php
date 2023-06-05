@extends('frontend.layouts.master')
@section('title','Cart Page')
@section('page-title','E-BAZAAR || Cart page')
@section('main-content')
<style>
.label-option{
	border: 1px solid;
    border-radius: 4px;
    padding: 1px 3px;
}

</style>
	@php
		$storeAndUrl = Helper::getStoreAndUrlBySlug();
		$last_slug = $storeAndUrl['last_slug'];
		$store = $storeAndUrl['store'];
		$store_id = $store->id;
	@endphp
	<!-- Breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="bread-inner">
						<ul class="bread-list">
							<li><a href="{{('home')}}">Home<i class="ti-arrow-right"></i></a></li>
							<li class="active"><a href="">Cart</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Breadcrumbs -->
			
	<!-- Shopping Cart -->
	<div class="shopping-cart section">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<!-- Shopping Summery -->
					<table class="table shopping-summery">
						<thead>
							<tr class="main-hading">
								<th>PRODUCT</th>
								<th>NAME</th>
								<th>STORE</th>
								<th class="text-center">UNIT PRICE</th>
								<th class="text-center">QUANTITY</th>
								<th class="text-center">TOTAL</th> 
								<th class="text-center"><i class="ti-trash remove-icon"></i></th>
							</tr>
						</thead>
						<tbody id="cart_item_list">
							<form action="{{route('cart.update')}}" method="POST">
								@csrf
								@if(session('cart') && !empty(session('cart')))
									@foreach(session('cart') as $key => $val)
                                    @php if (str_contains($key,'_'))
                                    $get_product = explode('_',$key);
                                    $cart = DB::table('products')->where('id', $get_product[0])->first();
									// print_r($cart); die;
                                    $sale_price = $cart->price;
                                    if($cart->discount>0)
                                    $sale_price=($sale_price-($sale_price*($cart->discount)/100));
                                    $sub_amount=($sale_price*$val['quantity']);
                                    $get_size = DB::table('sizes')->where('id', $get_product[1])->first();
                                    $get_choice = DB::table('colors')->where('id', $get_product[2])->first();
									$store = DB::table('stores')->where('id', $cart->store_id)->first();
									// dd($store);

                                    @endphp
										<tr>
											<td class="image" data-title="No"><img src="{{ asset('images/products/'.$cart->photo )}}" alt="{{$cart->photo}}"></td>
											<td class="product-des" data-title="Description">
												<p class="product-name"><a class="mb-2" href="{{ URL( $last_slug .'/'. 'product-detail' . '/' . $cart->slug)}}" target="_blank">
												{{ $cart->title}}
													</a><br />
													<span class='label-option'>
														{{ $get_size->title }}
													</span>
                                                <span class='label-option ml-2'>
													{{ $get_choice->title }}
												</span>
											</td>
											<td class="text-center">
												<a href="{{ URL( 'store' . '/' . $store->slug)}}" class="text-info">
													{{ $store->name }}
												</a>
												<br />
												<span>
													{{ $store->email }}
												</span>
												<br />
												<span>
													{{ $store->phone }}
												</span>
											</td>
											<td class="price" data-title="Price"><span>{{number_format($sale_price, 2)}}</span></td>
											<td class="qty" data-title="Qty">
												<!-- Input Order -->
									<div class="input-group">
										<div class="button minus">
											<button type="button"
												onclick="var result = document.getElementById('sst_{{$cart->id . $key}}'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 1 ) result.value--;console.log(result.value); return false;"
												class="btn btn-primary btn-number" data-type="minus"
												data-field="quant[{{$val['quantity']}}]">
												<i class="ti-minus"></i>

											</button>
										</div>
										<input type="text" name="quant[{{$key}}]" class="input-number" data-min="1"
											data-max="100" id="sst_{{$cart->id . $key}}" value="{{$val['quantity']}}">
										<input type="hidden" name="qty_id[]" value="{{$key}}">
										<div class="button plus">
											<button type="button"
												onclick="var result = document.getElementById('sst_{{$cart->id . $key}}'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
												class="btn btn-primary btn-number" data-type="plus"
												data-field="quant[{{$val['quantity']}}]">
												<i class="ti-plus"></i>
											</button>
										</div>
									</div>
									<!--/ End Input Order -->
											</td>
											<td class="total-amount cart_single_price" data-title="Total"><span class="money">{{number_format($sub_amount,2)}}</span></td>
											
											<td class="action" data-title="Remove"><a href="{{url('/'.$last_slug.'/cart-delete'.'/'.$key)}}"><i class="ti-trash remove-icon"></i></a></td>
										</tr>
									@endforeach
									<track>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td class="float-right">
											<button class="btn float-right" type="submit">Update</button>
										</td>
									</track>
								@else 
										<tr>
											<td align="center" colspan="6">
												There are no products in your cart currently.<br><br><a href="{{ url('/'.$last_slug.'/product-grids')}}" class="btn-warning btn-lg">Continue shopping</a>
											</td>
										</tr>
								@endif
								
							</form>
						</tbody>
					</table>
					<!--/ End Shopping Summery -->
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<!-- Total Amount -->
					<div class="total-amount">
						<div class="row">
							<div class="col-lg-8 col-md-5 col-12">
								<div class="left">
									<div class="coupon">
									<form action="{{ route('coupon-store') }}" method="POST">
											@csrf
											<input name="code" placeholder="Enter Your Coupon">
											<button class="btn">Apply</button>
										</form>
									</div>
									{{-- <div class="checkbox">`
										@php 
											$shipping=DB::table('shippings')->where('status','active')->limit(1)->get();
										@endphp
										<label class="checkbox-inline" for="2"><input name="news" id="2" type="checkbox" onchange="showMe('shipping');"> Shipping</label>
									</div> --}}
								</div>
							</div>
							<div class="col-lg-4 col-md-7 col-12">
								<div class="right">
									<ul>
	
										<li class="order_subtotal" data-price="{{Helper::totalCartPrice()}}">Cart Sub Total<span>{{number_format(session('cart_total'),2)}}</span></li>
										{{-- <div id="shipping">
											<li class="shipping">
												Shipping
													<div class="form-select">
														<span>To be discussed <br> over the phone</span>
													</div>
											</li>
										</div> <br> --}}
										<!--- To be discussed over the phone --->
										@php $total_coupons_price = 0; @endphp
										@if(session()->has('coupons'))
											@foreach(Session::get('coupons') as $coupon)
												@php 
													$total_coupons_price += $coupon['value'];
												@endphp
												<li class="coupon_price" title="{{ $coupon['store_name']}}" data-price="{{ $coupon['value']}}">{{$coupon['store_name']}}'s Coupon <span>{{$coupon['value']}}</span></li>
											@endforeach
										@endif
										@php
											$total_amount = session('cart_total');
											if(session()->has('coupons')){
												$total_amount = $total_amount - $total_coupons_price;
											}
										@endphp
										<li class="last" id="order_total_price">You Pay<span>{{number_format($total_amount,2)}}</span></li>
									</ul>
									@if(auth::check())
									<div class="button5">
										<a href="{{url('/'.$last_slug.'/checkout')}}" class="btn">Checkout</a>
										<a href="{{url('/'.$last_slug.'/product-grids')}}" class="btn">Continue shopping</a>
									</div>
									@else
                                       <div class="button5">
										<a href="{{url('/'. $last_slug. '/user/logincheckout')}}" class="btn">Checkout</a>
										<a href="{{url('/'.$last_slug.'/product-grids')}}" class="btn">Continue shopping</a>
									</div>
									@endif
								</div>
							</div>
						</div>
					</div>
					<!--/ End Total Amount -->
				</div>
			</div>
		</div>
	</div>
	<!--/ End Shopping Cart -->
			
	<!-- Start Shop Services Area  -->
	<section class="shop-services section">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-6 col-12">
					<!-- Start Single Service -->
					<div class="single-service">
						<i class="ti-rocket"></i>
						<h4>Free shiping</h4>
						<p>Dlivery Charges To Be Advised</p>
					</div>
					<!-- End Single Service -->
				</div>
				<div class="col-lg-3 col-md-6 col-12">
					<!-- Start Single Service -->
					<div class="single-service">
						<i class="ti-reload"></i>
						<h4>Free Return</h4>
						<p>Within 30 days returns</p>
					</div>
					<!-- End Single Service -->
				</div>
				<div class="col-lg-3 col-md-6 col-12">
					<!-- Start Single Service -->
					<div class="single-service">
						<i class="ti-lock"></i>
						<h4>Sucure Payment</h4>
						<p>100% secure payment</p>
					</div>
					<!-- End Single Service -->
				</div>
				<div class="col-lg-3 col-md-6 col-12">
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
	<!-- End Shop Newsletter -->
	
	<!-- Start Shop Newsletter  -->
	@include('frontend.layouts.newsletter')
	<!-- End Shop Newsletter -->
	
	
	
	<!-- Modal -->
        {{-- <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="ti-close" aria-hidden="true"></span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row no-gutters">
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <!-- Product Slider -->
									<div class="product-gallery">
										<div class="quickview-slider-active">
											<div class="single-slider">
												<img src="images/modal1.jpg" alt="#">
											</div>
											<div class="single-slider">
												<img src="images/modal2.jpg" alt="#">
											</div>
											<div class="single-slider">
												<img src="images/modal3.jpg" alt="#">
											</div>
											<div class="single-slider">
												<img src="images/modal4.jpg" alt="#">
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
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia iste laborum ad impedit pariatur esse optio tempora sint ullam autem deleniti nam in quos qui nemo ipsum numquam.</p>
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
												<button type="button"
												onclick=" var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;"
												class="btn btn-primary btn-number" data-type="minus"
												data-field="quant[{{$val['quantity']}}]">
												<i class="ti-minus"></i>
											</button>

											</div>
											<input type="text" name="quant[{{$key}}]" class="input-number" data-min="1"
											data-max="100" id="sst" value="{{$val['quantity']}}">
										<input type="hidden" name="qty_id[]" value="{{$key}}">
											<!-- <input type="text" name="quant[1]" class="input-number"  data-min="1" data-max="1000" value="1"> -->
											
											<div class="button plus">
												<button type="button"
													onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
													class="btn btn-primary btn-number" data-type="plus"
													data-field="quant[{{$val['quantity']}}]">
													<i class="ti-plus"></i>
												</button>
											</div>
										</div>
										<!--/ End Input Order -->
									</div>
									<div class="add-to-cart">
										<a href="#" class="btn">Add to cart</a>
										<a href="#" class="btn min"><i class="ti-heart"></i></a>
										<a href="#" class="btn min"><i class="fa fa-compress"></i></a>
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
        </div> --}}
        <!-- Modal end -->
	
@endsection
@push('styles')
	<style>
		li.shipping{
			display: inline-flex;
			width: 100%;
			font-size: 14px;
		}
		li.shipping .input-group-icon {
			width: 100%;
			margin-left: 10px;
		}
		.input-group-icon .icon {
			position: absolute;
			left: 20px;
			top: 0;
			line-height: 40px;
			z-index: 3;
		}
		.form-select {
			height: 30px;
			width: 100%;
		}
		.form-select .nice-select {
			border: none;
			border-radius: 0px;
			height: 40px;
			background: #f6f6f6 !important;
			padding-left: 45px;
			padding-right: 40px;
			width: 100%;
		}
		.list li{
			margin-bottom:0 !important;
		}
		.list li:hover{
			background:#F7941D !important;
			color:white !important;
		}
		.form-select .nice-select::after {
			top: 14px;
		}
	</style>
@endpush
@push('scripts')
	<script src="{{asset('frontend/js/nice-select/js/jquery.nice-select.min.js')}}"></script>
	<script src="{{ asset('frontend/js/select2/js/select2.min.js') }}"></script>
	<script>
		$(document).ready(function() { $("select.select2").select2(); });
  		$('select.nice-select').niceSelect();
	</script>
	<script>
		$(document).ready(function(){
			$('.shipping select[name=shipping]').change(function(){
				let cost = parseFloat( $(this).find('option:selected').data('price') ) || 0;
				let subtotal = parseFloat( $('.order_subtotal').data('price') ); 
				let coupon = parseFloat( $('.coupon_price').data('price') ) || 0; 
				// alert(coupon);
				$('#order_total_price span').text('$'+(subtotal + cost-coupon).toFixed(2));
			});

		});

	</script>

@endpush