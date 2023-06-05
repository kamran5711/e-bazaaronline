@extends('frontend.layouts.master')

@section('title','E-SHOP || About Us')
@section('page-title','About Us')
@section('main-content')
	<!-- Breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="bread-inner">
						<ul class="bread-list">
							<li><a href="{{('home')}}">Home<i class="ti-arrow-right"></i></a></li>

							<li class="active"><a href="#">About Us</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Breadcrumbs -->
	
	<!-- About Us -->
	<section class="about-us section">
			<div class="container mt-3 mb-5">
				<div class="row">
					<div class="col-lg-12 col-12">
						@if(!empty($about_us))
						<div class="about-content">
							<h3 class="mb-2 mt-2"><span> {!! @$about_us->title !!}</span></h3>
							{!! @$about_us->content !!} 
						</div>
						@else
							<div class="d-flex align-items-center justify-content-center" style="height:100vh;">
								<h4 class="text-info">No content added yet for about us.</h4>
							  </div>
						@endif
					</div>
				</div>
			</div>
	</section>
	<!-- End About Us -->

	{{-- @include('frontend.layouts.newsletter') --}}
@endsection