{{-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> --}}
<!------ Include the above in your HEAD tag ---------->

{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> --}}

	<!-- Start Footer Area -->
	<style>
		.link{
			color: #ffff !important;
    		font-size: xx-large;
		}

		.footer{
			background: #EE4540;
			opacity: 0.9;
    
		}

		.footer .links ul li a:hover{
			color:#510A32;
		}
		.footer .about .call a{
			color: white;
		}

		h5 {
    color: white;
}
	</style>
	<footer class="footer">
		<!-- Footer Top -->
		<div class="footer-top section">
			<div class="container mt-5 mb-5">
				@php
					// $storeAndUrl = Helper::getStoreAndUrlBySlug();
        			// $store_info = $storeAndUrl['store'];
					// $last_slug = $storeAndUrl['last_slug'];
					// $social_links = DB::table('social_links')->where('store_id',$store_info->id)->first();
					// $store = \App\StoreModal::with('country', 'state', 'city', 'social_links')->where('id', $store_info->id)->first();

				@endphp
				<div class="row">
					<div class="col-lg-5 col-md-6 col-12">
						<!-- Single Widget -->
						<div class="single-footer about">
							<div class="logo">
								{{-- <a href="{{url('/')}}"> --}}
									<h3 class="text-white">{{ auth()->user()->name }}</h3>
									{{-- <img src="images/logo2.png" alt="#"> --}}
								{{-- </a> --}}
							</div>
							<p class="text">short description</p>
							<p class="call">Got Question? Call us 24/7<span class="mt-2"><a href="tel:926948945">926948945</a></span></p>
						</div>
						<!-- End Single Widget -->
					</div>
					<div class="col-lg-2 col-md-6 col-12">
						<!-- Single Widget -->
						<div class="single-footer links">
							<h4>Information</h4>
							<ul>
								<li><a href="#">Contact Us</a></li>
								{{-- <li><a href="{{url('/'.$last_slug.'/about-us')}}">home</a></li> --}}
								<li><a href="#">Faq</a></li>
								{{-- <li><a href="{{url('/'.$last_slug.'/terms-and-conditions')}}">Terms & Conditions</a></li> --}}

								{{-- <li><a href="{{url('/'.$last_slug.'/faqs')}}">FAQS</a></li> --}}
								<li><a href="#">Help</a></li>
							</ul>
						</div>
						<!-- End Single Widget -->
					</div>
					<div class="col-lg-2 col-md-6 col-12">
						<!-- Single Widget -->
						<div class="single-footer links">
							<h4>Customer Service</h4>
							<ul>
								<li><a href="#">Payment Methods</a></li>
								<li><a href="#">Money back</a></li>
								<li><a href="#">Returns</a></li>
								<li><a href="#">Shippings</a></li>
								<li><a href="#">Privacy & Policy</a></li>
								{{-- <li><a href="{{url('/'.$last_slug.'/payment-methods')}}">Payment Methods</a></li>
								<li><a href="{{url('/'.$last_slug.'/money-back')}}">Money back</a></li>
								<li><a href="{{url('/'.$last_slug.'/returns')}}">Returns</a></li>
								<li><a href="{{url('/'.$last_slug.'/shippings')}}">Shippings</a></li>
								<li><a href="{{url('/'.$last_slug.'/privacy-policy')}}">Privacy & Policy</a></li> --}}
							</ul>
						</div>
						<!-- End Single Widget -->
					</div>

					<div class="col-lg-3 col-md-6 col-12">
						<!-- Single Widget -->
						<div class="single-footer social">
							<h4>Get In Tuch</h4>
							<!-- Single Widget -->
							<div class="contact">
								<ul>
									<li>islamabad</li>
									<li>pakistan</li>
									{{-- <li>{{ $store->area }}</li>
									<li>{{ $store->city->name }}, {{ $store->state->name }}, {{ $store->country->name }}.</li>
									<li>{{ $store->email }}</li>
									<li>{{ $store->phone }}</li> --}}
								</ul>
							</div>
							<!-- End Single Widget -->
							<ul>
								<li><a href="#" target="_blank"><i class="ti-facebook"></i></a></li>
								<li><a href="#" target="_blank"><i class="ti-twitter"></i></a></li>
								<li><a href="#" target="_blank"><i class="ti-instagram"></i></a></li>
							</ul>
							{{-- @if(@$store->social_links)
								<ul>
									@if($store->social_links->facebook_link)
										<li><a href="{{ $store->social_links->facebook_link }}" target="_blank"><i class="ti-facebook"></i></a></li>
									@endif
									@if($store->social_links->twitter_link)
										<li><a href="{{ $store->social_links->twitter_link }}" target="_blank"><i class="ti-twitter"></i></a></li>
									@endif
									@if($store->social_links->instagram_link)
										<li><a href="{{ $store->social_links->instagram_link }}" target="_blank"><i class="ti-instagram"></i></a></li>
									@endif
								</ul>
							@endif --}}
						</div>
						<!-- End Single Widget -->
					</div>


				</div>
			</div>
		</div>
		<!-- End Footer Top -->
		 <div class="copyright">
			<div class="container">
				<div class="inner">
					<div class="row">
						<div class="col-lg-6 col-12">
							<div class="left">
								<p>Copyright © {{date('Y')}} <a href="https://e-bazaaronline.com" target="_blank">To  digitalised your business with us.</a> </p>
							</div>
						</div>
						<!--<div class="col-lg-6 col-12">
							<div class="right">
								<img src="{{asset('backend/img/payments.png')}}" alt="#">
							</div>
						</div>-->
					</div>
				</div>
			</div>
		</div> 
	</footer>
	<!-- /End Footer Area -->		
 
	<!-- Jquery -->
    <script src="{{asset('/frontend/js/jquery.min.js')}}"></script>
    <script src="{{asset('frontend/js/jquery-migrate-3.0.0.js')}}"></script>
	<script src="{{asset('frontend/js/jquery-ui.min.js')}}"></script>
	<!-- Popper JS -->
	<script src="{{asset('frontend/js/popper.min.js')}}"></script>
	<!-- Bootstrap JS -->
	<script src="{{asset('frontend/js/bootstrap.min.js')}}"></script>
	<!-- Color JS -->
	<script src="{{asset('frontend/js/colors.js')}}"></script>
	<!-- Slicknav JS -->
	<script src="{{asset('frontend/js/slicknav.min.js')}}"></script>
	<!-- Owl Carousel JS -->
	<script src="{{asset('frontend/js/owl-carousel.js')}}"></script>
	<!-- Magnific Popup JS -->
	<script src="{{asset('frontend/js/magnific-popup.js')}}"></script>
	<!-- Waypoints JS -->
	<script src="{{asset('frontend/js/waypoints.min.js')}}"></script>
	<!-- Countdown JS -->
	<script src="{{asset('frontend/js/finalcountdown.min.js')}}"></script>
	<!-- Nice Select JS -->
	<script src="{{asset('frontend/js/nicesellect.js')}}"></script>
	<!-- Flex Slider JS -->
	<script src="{{asset('frontend/js/flex-slider.js')}}"></script>
	<!-- ScrollUp JS -->
	<script src="{{asset('frontend/js/scrollup.js')}}"></script>
	<!-- Onepage Nav JS -->
	<script src="{{asset('frontend/js/onepage-nav.min.js')}}"></script>
	{{-- Isotope --}}
	<script src="{{asset('frontend/js/isotope/isotope.pkgd.min.js')}}"></script>
	<!-- Easing JS -->
	<script src="{{asset('frontend/js/easing.js')}}"></script>

	<!-- Active JS -->
	<script src="{{asset('frontend/js/active.js')}}"></script>

	
	@stack('scripts')
	<script>
		setTimeout(function(){
		  $('.alert').slideUp();
		},5000);
		$(function() {
		// ------------------------------------------------------- //
		// Multi Level dropdowns
		// ------------------------------------------------------ //
			$("ul.dropdown-menu [data-toggle='dropdown']").on("click", function(event) {
				event.preventDefault();
				event.stopPropagation();

				$(this).siblings().toggleClass("show");


				if (!$(this).next().hasClass('show')) {
				$(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
				}
				$(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
				$('.dropdown-submenu .show').removeClass("show");
				});

			});
		});
	  </script>