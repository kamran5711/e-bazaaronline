@extends('frontend.layouts.master')

@section('main-content')
	<!-- Breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="bread-inner">
						<ul class="bread-list">
							<li><a href="{{('home')}}?k={{request()->get('k')}}">Home<i class="ti-arrow-right"></i></a></li>

							<li class="active"><a href="#">Dashboard</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
    <section class="shop-services section home">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <a href ="{{route('customer.index')}}?k={{request()->get('k')}}">
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
                        <a href ="{{route('customer.reviews')}}?k={{request()->get('k')}}">
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
                        <a href ="{{route('customer.comments')}}?k={{request()->get('k')}}">
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
                        <a href ="{{route('customer.profile')}}?k={{request()->get('k')}}">
                        <i class="ti-user"></i>
                        {{-- <h4> {{\App\Models\Order::where(['user_id'=>Auth::user()->id])->count()}}</h4> --}}
                        <p>My Profile</p>
                        </a>
                    </div>
                    <!-- End Single Service -->
                </div>
            </div>
        </div>
    </section>
    <section class="about-us section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-12">
                    <div class="about-content">
                        <form action="{{route('customer.comment.update',$comment->id)}}" method="POST">
                            @csrf
                            {{-- @method('PATCH') --}}
                            <div class="form-group">
                              <label for="name">By:</label>
                              <input type="text" disabled class="form-control" value="{{$comment->user_info->name}}">
                            </div>
                            <div class="form-group">
                              <label for="comment">comment</label>
                            <textarea name="comment" id="" cols="20" rows="10" class="form-control">{{$comment->comment}}</textarea>
                            </div>
                          
                            <button type="submit" class="btn ">Update</button>
                          </form>
                    </div>
                </div> 
            </div>
        </div>
</section>
@endsection


