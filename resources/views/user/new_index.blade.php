@extends('frontend.layouts.customer-layout')
@section('main-content')
	<!-- Breadcrumbs -->
	<div class="breadcrumbs">
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
	</div>
    
    {{-- <section class="shop-services section home">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <a href ="{{route('customer.index')}}">
                        <i class="ti-truck"></i>
                        <h4> {{\App\Models\Order::where(['user_id'=>Auth::user()->id])->count()}}</h4>
                        <p>Total Orders</p>
                        </a>
                    </div>
                    <!-- End Single Service -->
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <a href ="{{route('customer.reviews')}}">
                        <i class="ti-star"></i>
                        <h4> {{\App\Models\Order::where(['user_id'=>Auth::user()->id])->count()}}</h4>
                        <p>Your Reviews</p>
                        </a>
                    </div>
                    <!-- End Single Service -->
                </div>

                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <a href ="{{route('customer.comments')}}">
                        <i class="ti-comment-alt"></i>
                        <h4> {{\App\Models\Order::where(['user_id'=>Auth::user()->id])->count()}}</h4>
                        <p>Your Comments</p>
                        </a>
                    </div>
                    <!-- End Single Service -->
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <a href ="{{route('customer.profile')}}">
                        <i class="ti-user"></i>
                        {{-- <h4> {{\App\Models\Order::where(['user_id'=>Auth::user()->id])->count()}}</h4> --}}
                        {{-- <p>My Profile</p>
                        </a>
                    </div>
                    <!-- End Single Service -->
                </div>
            </div>
        </div>
    </section> --}}


    <section class="m-5">
        <div class="container">
            @if(count($orders)>0)
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
                                <a href="{{route('customer.ordershow', $order->id)}}" class=""  data-toggle="tooltip" title="view" data-placement="bottom"><i class="ti-eye"></i></a>
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
                {{-- <span style="float:right">{{$orders->links()}}</span> --}}
                <style>
                    .pagination {
                        margin: 5px;
                        display: inline-flex
                    }
                </style>
                <div class="d-flex justify-content-end">
                    {!! $orders->links() !!}
                </div>
            </div>
            @else
                <h6 class="text-center">You haven't placed any order yet!</h6>
            @endif
        </div>
    </section>
@endsection
@push('scripts')
@endpush