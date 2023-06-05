@extends('layouts.main')
@section('content')

<style>
.stepwizard-step p {
    margin-top: 0px;
    color:#666;
}
.stepwizard-row {
    display: table-row;
}
.stepwizard {
    display: table;
    width: 100%;
    position: relative;
}
.stepwizard-step button[disabled] {
    /*opacity: 1 !important;
    filter: alpha(opacity=100) !important;*/
}
.stepwizard .btn.disabled, .stepwizard .btn[disabled], .stepwizard fieldset[disabled] .btn {
    opacity:1 !important;
    color:#bbb;
}
.stepwizard-row:before {
    top: 19px;
    bottom: 0;
    position: absolute;
    content:" ";
    width: 100%;
    height: 2px;
    background-color: #ccc;
    z-index: 0;
}
.stepwizard-step {
    display: table-cell;
    text-align: center;
    position: relative;
}
.btn-circle {
    width: 40px;
    height: 40px;
    text-align: center;
    padding: 8px;
    font-size: 12px;
    line-height: 1.428571429;
    border-radius: 100%;
}
.stepwizard .fa {
    font-size: 24px;
    color:white;
}
.hidden{display:none;}
input[type=text] {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    box-sizing: border-box;
}
form {
    width: 100%;
    max-width: 500px;
}
</style>
<!-- Themify Icons -->

    {{-- <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{route('home')}}">Home<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0);">Order Track</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <nav aria-label="breadcrumb">
		<ol class="breadcrumb">
				<div class="container">
				<li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Track Orders</li>
			</div>
		</ol>
	</nav>
    <div class="container">
        <div class="h-75 d-flex align-items-center justify-content-center">        
            <form action="{{ url('track-orders-list/')}}" method="post">
                {{-- <input type="hidden" name="store_slug" value="{{ $last_slug }}" /> --}}
                {{ csrf_field() }}
                <div class="form-group m-2">
                  <input type="text" class="form-control" name="order_number_or_email" placeholder="Enter your order number or email address" required>
                </div>
                <div class="form-check-inline m-2">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input form-control-lg" name="order_type" value="order_number" checked>&nbsp; Order number
                    </label>
                </div>
                <div class="form-check-inline m-2">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input" name="order_type" value="email_address">&nbsp; Email address
                    </label>
                </div>
                <div class="d-flex justify-content-center">
                    <button class="btn submit_btn d-block mt-2 btn-primary" type="submit" value="submit"><span class="fa fa-search" aria-hidden="true">
                    </span> Track Order</button>
                </div>
            </form>
        </div>
    </div>
      
</section>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>