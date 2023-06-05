@extends('frontend.layouts.master')
@section('main-content')
@section('page-title','E-BAZAAR || Contact US page')
<style>
</style>
	<!-- Breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="bread-inner">
						<ul class="bread-list">
							<li><a href="/">Home<i class="ti-arrow-right"></i></a></li>
							<li class="active"><a href="javascript:void(0);">Contact</a></li>
							@php
								$storeAndUrl = Helper::getStoreAndUrlBySlug();
								$store_slug = $last_slug = $storeAndUrl['last_slug'];
								$store_id = $storeAndUrl['store']->id;
								$store = \App\StoreModal::with(['address' => function($query) {
										$query->with(['country', 'state', 'city']);
									}])->where('id', $store_id)->first();
							@endphp
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Breadcrumbs -->
	<!-- Start Contact -->
	<section id="contact-us" class="contact-us section mt-3 mb-3">
		<div class="container">
				<div class="contact-head">
					<div class="row">
						<div class="col-lg-8 col-12">
							<div class="form-main">
								<div class="title">
									@php
										// $settings=DB::table('settings')->where('store_id', Crypt::decrypt(request()->get('k') ))->get();
									@endphp
									<h2>Get in touch</h2>
								</div>
								<form class="form-contact form contact_form" method="post" action="{{route('contact.store')}}" id="contactForm" novalidate="novalidate">
									@csrf
									<input type="hidden" name="store_id" value="{{ $store->id }}" />
									<div class="row">
										<div class="col-lg-6 col-12">
											<div class="form-group">
												<label>Name<span>*</span></label>
												<input name="name" id="name" type="text" value="" placeholder="Enter your name" required/>
											</div>
										</div><div class="col-lg-6 col-12">
											<div class="form-group">
												<label>Email<span>*</span></label>
												<input name="email" type="email" id="email" value="" placeholder="Enter your email" required/>
											</div>	
										</div>
										<div class="col-lg-6 col-12">
											<div class="form-group">
												<label>Subjects<span>*</span></label>
												<input name="subject" type="text" id="subject" placeholder="Enter Subject" required />
											</div>
										</div>
										
										<div class="col-lg-6 col-12">
											<div class="form-group">
												<label>Phone<span>*</span></label>
												<input id="phone" name="phone" type="number" placeholder="Enter your phone" required />
											</div>	
										</div>
										<div class="col-12">
											<div class="form-group message">
												<label>message<span>*</span></label>
												<textarea name="message" id="message" cols="30" rows="9" placeholder="Enter Message"></textarea>
											</div>
										</div>
										<div class="col-12">
											<div class="form-group button">
												<button type="submit" class="btn ">Send Message</button>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
						<div class="col-lg-4 col-12">
							<div class="single-head">
								<div class="single-info">
									<i class="fa fa-phone"></i>
									<h4 class="title">Call us Now:</h4>
									<ul>
										<li>{{ !is_null($store) ? $store->phone : '' }}</li>
									</ul>
								</div>
								<div class="single-info">
									<i class="fa fa-envelope-open"></i>
									<h4 class="title">Email:</h4>
									<ul>
										<li><a href="mailto:{{ !is_null($store) ? $store->email : '' }}"> {{$store->email}}</li></a></li>
									</ul>
								</div>
								<div class="single-info">
									<i class="fa fa-location-arrow"></i>
									<h4 class="title">Our Address:</h4>
									<ul>
										<li>{{ $store->address->country->name .", ". $store->address->state->name . ", " . $store->address->city->name }}</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	</section>
	<!--/ End Contact -->
	<!-- Map Section -->
	{{-- <div class="map-section">
		<div id="myMap">
			<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d14130.857353934944!2d85.36529494999999!3d27.6952226!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sne!2snp!4v1595323330171!5m2!1sne!2snp" width="100%" height="100%" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
		</div>
	</div> --}}
	<!--/ End Map Section -->
	<!-- Start Shop Newsletter  -->
	{{-- @include('frontend.layouts.newsletter') --}}
	<!-- End Shop Newsletter -->
	<!--================Contact Success  =================-->
	<div class="modal fade" id="success" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
		  <div class="modal-content">
			<div class="modal-header">
				<h2 class="text-success">Thank you!</h2>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p class="text-success">Your message is successfully sent...</p>
			</div>
		  </div>
		</div>
	</div>
	<!-- Modals error -->
	<div class="modal fade" id="error" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
		  <div class="modal-content">
			<div class="modal-header">
				<h2 class="text-warning">Sorry!</h2>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p class="text-warning">Something went wrong.</p>
			</div>
		  </div>
		</div>
	</div>
@endsection
@push('styles')
<style>
	.modal-dialog .modal-content .modal-header{
		position:initial;
		padding: 10px 20px;
		border-bottom: 1px solid #e9ecef;
	}
	.modal-dialog .modal-content .modal-body{
		height:100px;
		padding:10px 20px;
	}
	.modal-dialog .modal-content {
		width: 50%;
		border-radius: 0;
		margin: auto;
	}
</style>
@endpush
@push('scripts')
<script src="{{ asset('frontend/js/jquery.form.js') }}"></script>
<script src="{{ asset('frontend/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('frontend/js/contact.js') }}"></script>
@endpush