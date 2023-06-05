{{-- <link rel="stylesheet" href="{{asset('frontend/css/style.css')}}"> --}}

<style>
.label-option{
	border: 1px solid;
    border-radius: 4px;
    padding: 1px 3px;
}


</style>

	@php
		$store_id = auth()->user()->store_id;
	@endphp
	<!-- End Breadcrumbs -->
			
	<!-- Shopping Cart -->
	<div class="shopping-cart section">
        <form action="{{route('cart.update')}}" method="POST">
            @csrf
            @if(session('cart') && !empty(session('cart')))
		<div class="">
			<div class="row">
				<div class="col-12">
                    <div class="table-responsive"></div>
					<!-- Shopping Summery -->
					<table class="table table-bordered table-sm shopping-summery ">
						<thead>
							<tr class="main-hading text-center bg-primary text-white">
								<th>Name</th>
								<th>Image</th>
								<th>Unit Price</th>
								<th>Quantity</th>
								<th>Total</th> 
								<th>Delete</th>
							</tr>
						</thead>
						<tbody id="cart_item_list">
									@foreach(session('cart') as $key => $val)
                                    @php if (str_contains($key,'_'))
                                    $get_product = explode('_',$key);
                                    $cart = DB::table('products')->where('id', $get_product[0])->first();
									// print_r($cart); die;
                                    $sale_price = $cart->price;
                                    if($cart->discount>0)
                                    $sale_price=($sale_price - ($sale_price*($cart->discount)/100));
                                    $sub_amount=($sale_price*$val['quantity']);
                                    $get_size = DB::table('sizes')->where('id', $get_product[1])->first();
                                    $get_choice = DB::table('colors')->where('id', $get_product[2])->first();
									// dd($get_choice);

                                    @endphp
										<tr class="text-center">
											<td class="product-des" data-title="Description">
												<span class="products-info" product-name="{{$cart->title}}" product-color="{{$get_choice->title}}" product-size="{{$get_size->title}}" product-price="{{$cart->price}}" product-discount="{{($cart->price * ($cart->discount)/100)}}" product-quantity="{{$val['quantity']}}"></span>
												<div class="product-name">
                                                    {{-- <a href="{{ URL( $last_slug .'/'. 'product-detail' . '/' . $cart->slug)}}" target="_blank">
												        {{ $cart->title}}
													</a><br> --}}
                                                    <div class="text-info">
                                                        {{ $cart->title}}
                                                    </div>
                                                    <span class='label-option'>
                                                        {{ $get_size->title }}
                                                    </span>
                                                    <span class='label-option ml-2'>
                                                        {{ $get_choice->title }}
                                                    </span>
                                                </div>
											</td>
											<td class="image" data-title="No"><img style="height: auto; width: 70px;" src="{{ asset('images/products/'.$cart->photo )}}" alt="{{$cart->photo}}" /></td>
											<td class="price" data-title="Price"><span>{{number_format($sale_price, 2)}}</span></td>
											<td class="qty" data-title="Qty">
												<!-- Input Order -->
									<div class="input-group justify-content-center">
										<div class="button minus mr-2">
											<button type="button"
												onclick="var result = document.getElementById('sst_{{$cart->id . $key}}'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 1 ) result.value--;console.log(result.value); return false;"
												class="btn btn-primary btn-number rounded-0" data-type="minus"
												data-field="quant[{{$val['quantity']}}]">
												<i class="ti-minus"></i>

											</button>
										</div>
										<input type="text" name="quant[{{$key}}]" class="input-number" data-min="1" style="width: 100px; text-align: center;"
											data-max="100" id="sst_{{$cart->id . $key}}" value="{{$val['quantity']}}">
										<input type="hidden" name="qty_id[]" value="{{$key}}">
										<div class="button plus ml-2">
											<button type="button"
												onclick="var result = document.getElementById('sst_{{$cart->id . $key}}'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
												class="btn btn-primary btn-number rounded-0" data-type="plus"
												data-field="quant[{{$val['quantity']}}]">
												<i class="ti-plus"></i>
											</button>
										</div>
									</div>
									<!--/ End Input Order -->
										</td>
											<td class="total-amount cart_single_price" data-title="Total"><span class="money">{{number_format($sub_amount,2)}}</span></td>
											<td class="justify-content-center"><a href="javascript:void(0)" onclick="RemoveCartItem('{{$key}}')" class="btn btn-link"><i class="ti-trash remove-icon text-danger"></i></a></td>
										</tr>
									@endforeach
									<div>
										<td colspan="5"></td>
										<td class="text-center">
											<button class="btn btn-primary rounded-0" type="submit">Update</button>
										</td>
									</div>
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
                                <form action="{{route('coupon-store')}}" method="POST" class="form-inline">
                                    {{-- @csrf
                                    <div class="form-group mb-2">
                                        <input name="code" class="form-control rounded-0" placeholder="Enter Your Coupon">
                                    </div>
                                    <button class="btn btn-primary rounded-0 p-1">Apply Coupon</button> --}}
                                </form>
                                <form action="{{route('coupon-store')}}" method="POST" class="form-inline">
                                    @csrf
									<input type="hidden" name="onlyStoreId" value="{{ auth()->user()->store_id }}" />
                                    <input type="text" name="code" class="form-control rounded-0" placeholder="Enter Your Coupon">
                                    <button class="btn btn-primary rounded-0 ml-3">Apply Coupon</button>
                                </form>
							</div>
							<div class="col-lg-4 col-md-7 col-12">
								<div class="right">
									<ul>
										<li class="order_subtotal" data-price="{{Helper::totalCartPrice()}}">Cart Sub Total: <span>{{number_format(session('cart_total'),2)}}</span></li>
										@php
											$total_amount = session('cart_total');
											$coupon_total = 0;
										@endphp
										@if(session()->has('coupons'))
											@foreach (session()->get('coupons') as $coupon)
												@php $coupon_total += $coupon['value']; @endphp
												<li class="coupon_price" data-price="{{$coupon['value']}}">Coupon Discount: <span>{{number_format($coupon['value'], 2)}}</span></li>
											@endforeach
											@php $total_amount = $total_amount - $coupon_total; @endphp
										@endif
										<li class="last" id="order_total_price">You Pay: <span>{{number_format($total_amount,2)}}</span></li>
									</ul>
									<div class="button5 text-right">
                                        {{-- {{url('/'.$last_slug.'/checkout')}} --}}
										<a href="javascript:void(0)" class="btn btn-primary rounded-0" onclick="checkOutCart()">Checkout</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--/ End Total Amount -->
				</div>
			</div>
		</div>
        @endif
    </form>
	</div>
	<!--/ End Shopping Cart -->
	
	
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