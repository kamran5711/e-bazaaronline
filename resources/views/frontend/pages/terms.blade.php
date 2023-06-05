@extends('layouts.main')
@section('content')

	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
				<div class="container">
				<li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Terms and conditions</li>
			</div>
		</ol>
	</nav>
	<!-- About Us -->
	<section class="about-us section h-100" style="min-height: 350px">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-12">
					@if(!empty($terms))
					<div class="about-content">
						<h3 class="mb-2 mt-2"><span> {!! @$terms->title !!}</span></h3>
						{!! @$terms->content !!} 
					</div>
					@else
						<div class="d-flex align-items-center justify-content-center" style="height:100vh;">
							<h4 class="text-info">No terms and conditions are added yet!</h4>
					  	</div>
					@endif
				</div>
				
			</div>
		</div>
	</section>
	<!-- End About Us -->	
	{{-- @include('frontend.layouts.newsletter') --}}
@endsection