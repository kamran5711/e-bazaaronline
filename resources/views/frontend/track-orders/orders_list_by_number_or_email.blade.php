@extends('layouts.main')
@section('content')
	<!-- Breadcrumbs -->
	{{-- <div class="breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="bread-inner">
						<ul class="bread-list">
							<li><a href="{{('home')}}">Home<i class="ti-arrow-right"></i></a></li>

							<li class="active"><a href="#">Dashboard</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div> --}}
    <link rel="stylesheet" href="{{asset('frontend/css/themify-icons.css')}}">
    <nav aria-label="breadcrumb">
		<ol class="breadcrumb">
				<div class="container">
				<li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Tracked Orders</li>
			</div>
		</ol>
	</nav>

 
    <section class="m-5">
        <div class="container" style="min-height:250px!important">
            @if(count($orders) > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead>
                    <tr>
                        <th>S.N.</th>
                        <th>Order No</th>
                        <th>Order Date</th>
                        <th>Total items</th>
                        <th>Total Amount (Rs)</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $counter = 1; $colors_array=array("Received"=>"badge-warning","Processed"=>"badge-primary","Dispatched"=>"badge-info","Delivered"=>"badge-success","Cancelled"=>"badge-danger");@endphp
                    @foreach($orders as $order)   
                        <tr>
                            <td>{{ $counter++ }}</td>
                            <td>{{$order->order_number}}</td>
                            <td>{{$order->created_at->format('D d M, Y')}} at {{$order->created_at->format('g : i a')}}</td>
                            <td>{{$order->quantity}}</td>
                            @php
                                $subTotal = 0;
                                $totalDiscount = 0;
                                $product = $order->product;
                                // dd($order);
                            @endphp
                            @foreach($order->order_details as $order_product)
                                @php
                                $product = $order_product->product;
                                    if( $order_product->sale_discount > 0 ){
                                        $net = $order_product->sale_price - ( $order_product->sale_price * ( $order_product->sale_discount / 100 ));
                                        $order_product->discounted_price = round($net);
                                        $product->sub_total = round( $net * $order_product->sale_quantity );
                                    }
    
                                    $discount = ($product->price * $product->discount)/100;
                                    $product_price = $product->price;
                                    $after_discount = $product_price -  $discount;
                                    $subTotal = $subTotal + $after_discount * $order_product->sale_quantity;
                                    $totalDiscount = $totalDiscount + $discount;
                                @endphp
                            @endforeach
                                <td>{{ number_format( $subTotal - $order->coupon + $order->product_delivery, 2) }}</td>                    
                            <td>
                                <span class="badge {{$colors_array[$order->status]}}">{{$order->status}}</span>
                            </td>
                            <td>
                                <a href="{{ URL('order-details' . '/' . $order->id)}}" class=""  data-toggle="tooltip" title="view" data-placement="bottom"><i class="ti-eye"></i></a>
                                <form method="POST" action="{{route('order.destroy',[$order->id])}}">
                                    @csrf
                                    @method('delete')
                                        <!--<button class="btn btn-danger btn-sm dltBtn" data-id={{$order->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>-->
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @else
                <h6 class="text-center text-info">We don't have any order with spacify criteria, please try with different!</h6>
            @endif
        </div>
    </section>
@endsection
@push('scripts')
@endpush