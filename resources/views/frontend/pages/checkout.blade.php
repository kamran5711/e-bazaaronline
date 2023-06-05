@extends('frontend.layouts.master')
@section('title','Checkout page')
@section('page-title','E-BAZAAR || Checkout page')
@section('main-content')
    @php
    $store_info = $storeAndUrl['store'];
    $last_slug = $storeAndUrl['last_slug'];
    // $social_links = DB::table('social_links')->where('store_id',$store_info->id)->first();
    // $store = \App\StoreModal::with('country', 'state', 'city', 'social_links')->where('id', $store_info->id)->first();
    @endphp
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{('home')}}">Home<i class="ti-arrow-right"></i></a></li>

                            <li class="active"><a href="javascript:void(0)">Checkout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->   
    <!-- Start Checkout -->
    <section class="shop checkout section">
        <div class="container">
                <form class="form checkout-form" method="POST" action="{{route('cart.order')}}">
                    <input type="hidden" name="store_id" value="{{ $store_info->id }}" />
                    <input type="hidden" name="user_id" value="{{$user->id}}" />
                    @foreach ($store_ids as $s_i)
                        <input type="hidden" name="hidden_store_ids[]" value="{{ $s_i }}" class="hidden_store_ids">
                    @endforeach
                    @csrf
                    <div class="row"> 
                        <div class="col-lg-8 col-12">
                            <div class="checkout-form">
                                <h2>Make Your Checkout Here</h2>
                                <p>Kindly double check your cart and proceed to place your order</p>
                                <!-- Form -->
                                <div class="row"> 
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Name<span>*</span></label>
                                            <input type="text" name="name" class="form-control"  style="border-radius: 1rem;"  value="{{$user->name}}"/>
                                            @error('name')
                                                <span class='text-danger'>{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                     <label>Email <span>*</span></label>
                                     <input type="email" name="email" class="form-control" required  style="border-radius: 1rem;" value="{{$user->email}}"/>
                                            @error('email')
                                                <span class='text-danger'>{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Phone<span>*</span></label>
                                                <input type="number" name="phone" class="form-control"  style="border-radius: 1rem;"  value="{{$user->phone}}"/>
                                                @error('phone')
                                                    <span class='text-danger'>{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                            <label>Country <span class="text-danger">*</span></label>
                                                <select class="form-select select2" name="country_id" id="country_id" required onchange="getStatesByCountryId(this)">
                                                    <option value="">Select Country</option>
                                                    @foreach($countries as $country)
                                                    <option value="{{$country->id}}" @if ($user->address->country_id === $country->id || old('country_id') === $country->id) selected @endif>{{$country->name}}</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has('country_id'))
                                                <span class="invalid-feedback" id="country_span_id">
                                                    {{ $errors->first('country_id') }}
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row"> 
                                        <div class="col-md-6">
                                        <div class="form-group">
                                            <label>State <span class="text-danger">*</span></label>
                                                <select class="form-select select2" name="state_id" id="state_id" required onchange="getCitiesByStateId(this)"> 
                                                    @foreach($states as $state)
                                                        <option value="{{$state->id}}" @if ($user->address->state_id === $state->id || old('state_id') === $state->id) selected @endif>{{$state->name}}</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has('state_id'))
                                                <span class="invalid-feedback" id="state_span_id">
                                                    {{ $errors->first('state_id') }}
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                          <div class="form-group">
                                              <label class="">City <span class="text-danger">*</span></label>
                                                <select class="form-select select2" name="city_id" id="city_id" required onchange="getDeliveryCharges()">
                                                    @foreach($cities as $city)
                                                        <option value="{{$city->id}}" @if ($user->address->city_id === $city->id || old('city_id') === $city->id) selected @endif>{{$city->name}}</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has('city_id'))
                                                    <span class="invalid-feedback" id="city_span_id">
                                                        {{ $errors->first('city_id') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

    								<div class="row"> 
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                            <label>Address Line 1 <span>*</span></label>
                                                <input type="text" name="address1" class="form-control" required  style="border-radius: 1rem;" value="{{$user->address->address1}}"/>
                                                @error('address1')
                                                    <span class='text-danger'>{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Address Line 2 <span></span></label>
                                                <input type="text" name="address2" class="form-control" style="border-radius: 1rem;"  value="{{$user->address->address2}}"/>
                                                @error('address2')
                                                    <span class='text-danger'>{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>PostCode <span>*</span></label>
                                                <input type="text" name="postcode" class="form-control"  maxlength="7" size="7" required style="border-radius: 1rem;"  value="{{$user->address->postcode}}"/>
                                                @error('postcode')
                                                    <span class='text-danger'>{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Delivery Date <span>*</span></label>
                                                <input type="date" name="delivery_date" class="form-control" min="{{date('Y-m-d')}}" required style="border-radius: 1rem;"/>
                                                @error('delivery_date')
                                                    <span class='text-danger'>{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div> --}}
                                    </div> 
                                 <div class="col-lg-12 col-md-12 col-12">
                                        <div class="form-group">
                                            <label>Order Notes</label>
                                            <textarea   name="order_notes" rows="3" cols="60">  </textarea>
                                            @error('order_notes')
                                                <span class='text-danger'>{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                <!--/ End Form -->
                            </div>
                        </div>
                        <div class="col-lg-4 col-12">
                            <div class="order-details">
                                <!-- Order Widget -->
                                <div class="single-widget">
                                    <h2>CART TOTAL</h2>
                                    <div class="content">  
                                        <ul>
                                        <li class="order_subtotal" data-price="{{session('cart_total')}}">Cart Subtotal<span>{{number_format(session('cart_total'),2)}}</span></li>
                                        <li class="order_subtotal shipping" id="delivery-charges-wrapper">
                                            @php $total_coupons_price = $delivery_charges = 0; @endphp
                                            @foreach ($shippings as $shipping)
                                            @php $delivery_charges = (optional($shipping)->price) ? $delivery_charges + $shipping->price : $delivery_charges; @endphp
                                                <div class="d-flex justify-content-between">
                                                    <input type="hidden" name="store_id[]" value="{{ $shipping->store_id }}" />
                                                    <input type="hidden" name="store[]" value="{{ $shipping->store }}" />
                                                    @if(property_exists($shipping, 'price')) 
                                                        <div class="mt-3">{{ $shipping->store }}'s delivery</div>
                                                        <div class="mt-3">{{ $shipping->price }}</div>
                                                    @endif
                                                    <input type="hidden" name="shipping_id[]" value="{{ optional($shipping)->shipping_id }}" />
                                                    <input type="hidden" name="price[]" value="{{ optional($shipping)->price }}" />
                                                </div>
                                            @endforeach
                                        </li>
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
                                                if( $delivery_charges != 0 ){
                                                    $total_amount = $total_amount + $delivery_charges;
                                                }
                                            @endphp
                                           
                                            <li class="last" id="order_total_price">Total <span><b>{{number_format($total_amount, 2)}}</b></span></li>
                                        </ul>
                                    </div>
                                </div>
                                <!--/ End Order Widget -->
                                <!-- Order Widget -->
                                <div class="single-widget">
                                    <h2>Payments</h2>
                                    <div class="content">
                                        <div class="checkbox">
                                            {{-- <label class="checkbox-inline" for="1"><input name="updates" id="1" type="checkbox"> Check Payments</label> --}}
                                            <form-group>
                        
                                                @foreach($payments as $payment)
                                                            <label id="payment_id" data-id="{{ $payment->title}}">
                                                                <input name="payment_id" type="checkbox" class="form-control payment" id="payemnt_id_{{ $payment->id}}" value="{{ $payment->id}}" />
                                                                {{ $payment->title}}
                                                            </label>
                                                    <br>
                                                @endforeach
                                            </form-group>
                                        </div>
                                    </div>
                               
                                <!--/ End Order Widget -->
                                <!-- Payment Method Widget -->
                                <!-- <div class="single-widget payement">
                                    <div class="content">
                                        <img src="{{('backend/img/payment-method.png')}}" alt="#">
                                    </div>
                                </div>-->
                                <!--/ End Payment Method Widget -->
                                <!-- Button Widget --> 
                                  <div class="single-widget get-button">
                                  <div class="content">
                             <div class="form-group text-left">
                            <div class="g-recaptcha brochure__form__captcha" data-sitekey="6Lfj_CQeAAAAAAAwa_5B8dgn5V6jCts-Rwbkyfhb">
                            </div>
                            </div>
                              
                                    
                                        <div class="button">
                                            <button type="submit" class="btn submit-btn">proceed to checkout</button>
                                        </div>
                                    </div>
                                </div>
                                 </div>
                                <!--/ End Button Widget -->
                            </div>
                        </div>
                    </div>
                </form>
        </div>
    </section>
    <!--/ End Checkout -->
    
    <!-- Start Shop Services Area  -->
    <section class="shop-services section home">
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
                        <h4>SECURE PAYMENT</h4>
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
    <!-- End Shop Services -->
    
    <!-- Start Shop Newsletter  -->
    <section class="shop-newsletter section">
        <div class="container">
            <div class="inner-top">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2 col-12">
                        <!-- Start Newsletter Inner -->
                        <div class="inner">
                            <h4>Newsletter</h4>
                            <p> Subscribe to our newsletter and get <span>10%</span> off your first purchase</p>
                            <form action="mail/mail.php" method="get" target="_blank" class="newsletter-inner">
                                <input name="EMAIL" placeholder="Your email address" required="" type="email">
                                <button class="btn">Subscribe</button>
                            </form>
                        </div>
                        <!-- End Newsletter Inner -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Shop Newsletter -->

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


@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endpush
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script>
  
    $(document).ready(function() {
        $('.select2').select2();
        $('.nice-select').next().hide();
    });
    // $('select').selectpicker();
    function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
    }

</script>
@endpush


@push('scripts')
<script src='https://www.google.com/recaptcha/api.js'></script>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=9z77wjhpwrx6pvh3r3oeiky25krlx0jzd8m69yte73hjrrgg">
</script>
<script src="{{asset('mainJS/jquery.mask.js')}}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
  function getStatesByCountryId(country) {
      var country_id = country.value;
      $.ajax({
          url: "{{url('get-states-by-country-id').'/'}}"+country_id,
          method: 'GET',
          success:function(response){
              $('#state_id').html("");
              if(response.length === 0)
              $('#state_id').html("<option>No states found against country</option");
              $('#city_id').html("<option value=''>select state first</option");
              $.each(response, function (index, value) {
                  if(index == 0 )
                  $('#state_id').append('<option>Select State</option>');
                  $('#state_id').append('<option value="' + value.id + '">' + value.name + '</option>');
              });
          },
          error: function(response) {
              $('#state_id').html("<option>No states found against country</option");
              console.log(response);
          }
      });
  }


  function getCitiesByStateId(state) {
      var state_id = state.value;
      $.ajax({
          url: "{{url('get-cities-by-state-id').'/'}}"+state_id,
          method: 'GET',
          success:function(response){
              $('#city_id').html("");
              if(response.length === 0)
              $('#city_id').html("<option>No cities found against state</option");
              $.each(response, function (index, value) {
                  if( index == 0 )
                  $('#city_id').append('<option>Select City</option>');
                  $('#city_id').append('<option value="' + value.id + '">' + value.name + '</option>');
              });
          },
          error: function(response) {
              $('#city_id').html("<option>No cities found against state</option");
              console.log(response);
          }
      });
  }

  function getDeliveryCharges() {
    var store_ids = [];
    var url = "{{ route('get_delivery_charges', 'nadia-tailor') }}";
    var city_id = $("#city_id").val();
    $(".hidden_store_ids").each(function(){
        store_ids.push($(this).val());
    });
    $.ajax({
        type: "POST",
        data: { city_id, store_ids },
        url: url,
        success: function(data){
            var dataToAppend = shipping_id = price = '';
            $.each(data , function(index, element) {
                dataToAppend += `
                <div class="d-flex justify-content-between">`;
                    if(element.price) dataToAppend += `
                    <div class="mt-3">${ element.store }'s delivery</div>
                    <div class="mt-3">${ element.price }</div>`;
                    dataToAppend += `<input type="hidden" name="store_id[]" value="${ element.store_id }" />`;
                    dataToAppend += `<input type="hidden" name="store[]" value="${ element.store }" />`;
                    shipping_id = '';
                    price = '';
                    if(element.shipping_id){
                        shipping_id = element.shipping_id ? element.shipping_id : '';
                        price = element.price ? element.price : '';
                    }
                    dataToAppend += `
                    <input type="hidden" name="shipping_id[]" value="${ shipping_id }" />
                    <input type="hidden" name="price[]" value="${ price }" />
                </div>`;
            });
            $("#delivery-charges-wrapper").html(dataToAppend);
        }
    });

  }
</script>
@endpush


@push('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	<script src="{{asset('frontend/js/nice-select/js/jquery.nice-select.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{asset('mainJS/jquery.mask.js')}}"></script>
	<script>
		$(document).ready(function() { $("select.select2").select2(); });
  		$('select.nice-select').niceSelect();
	</script>
	<script>
        $(document).ready(function(){
            $('#phone').mask('000000000000',{placeholder:"92xxxxxxxxxx"});
            $('#cnic').mask('00000-0000000-0',{placeholder:"xxxxx-xxxxxxx-x"});
        });
		function showMe(box){
			var checkbox=document.getElementById('shipping').style.display;
			// alert(checkbox);
			var vis= 'none';
			if(checkbox=="none"){
				vis='block';
			}
			if(checkbox=="block"){
				vis="none";
			}
			document.getElementById(box).style.display=vis;
		}
	</script>
	<script>
		$(document).ready(function(){
			$('.shipping select[name=shipping]').change(function(){
				let cost = parseFloat( $(this).find('option:selected').data('price') ) || 0;
				let subtotal = parseFloat( $('.order_subtotal').data('price') );
                let coupon = 0;//parseFloat( $('.coupon_price').data('price') ) || 0; 
                $('.coupon_price').each(function(i, obj) {
                    coupon += parseFloat( $(obj).attr('data-price') );
                });
				$('#order_total_price span').text((subtotal + cost - coupon).toFixed(2));
			});

		});

	</script>
    <script>
        $('body').on('click','form-group>#payment_id',function(){
           var id =$(this).data('id');
        //    alert(id);
            $('label').removeClass("checked");
            $(this).addClass("checked");
        
        });
    </script>
    <script>

        $('body').on('submit','.checkout-form',function(e){
            // alert('form submitted!');
            $(this).submit();
            // e.preventDefault();
            var shipping = $('.shipping select[name=shipping]').val();
            var payment = $('input[name=payment_id]:checked').val();
           
            if(shipping == ""){
                toastr.error('Please select shipping method');
            $('.submit-btn').attr('disabled',false);
                  e.preventDefault();
            }

           else if(!payment){
                toastr.error('Please select payment method');
            $('.submit-btn').attr('disabled',false);

                 e.preventDefault();
            }
            else{
            //     $('.form').submit();
            //    e.submit();
            }
            // $('.submit-btn').attr('disabled',true);
        //    $(this).submit();
        });
    </script>
@endpush