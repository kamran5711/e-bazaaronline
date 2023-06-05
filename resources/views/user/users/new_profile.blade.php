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

							<li class="active"><a href="#">Profile</a></li>
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
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="image">
                                        @if($profile->photo)
                                        <img class="card-img-top img-fluid roundend-circle mt-4" style="border-radius:50%;height:80px;width:80px;margin:auto;"  alt="{{$profile->photo}}"  
                                        src="{{ asset('products/images/profile/'.Auth()->user()->photo) }}" >
                                        @else 
                                        <img class="card-img-top img-fluid roundend-circle mt-4" style="border-radius:50%;height:80px;width:80px;margin:auto;" src="{{asset('backend/img/avatar.png')}}" alt="profile picture">
                                        @endif
                                    </div>
                                    <div class="card-body mt-4 ml-2">
                                      <h5 class="card-title text-left"><small><i class="fas fa-user"></i> {{$profile->name}}</small></h5>
                                      <p class="card-text text-left"><small><i class="fas fa-envelope"></i> {{$profile->email}}</small></p>
                                      <p class="card-text text-left"><small class="text-muted"><i class="fas fa-hammer"></i> {{$profile->role}}</small></p>
                                    </div>
                                  </div>
                            </div>
                            <div class="col-md-8">
                                <form class="border px-4 pt-2 pb-3" method="POST" action="{{route('user-profile-update',$profile->id)}}"  enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="inputTitle" class="col-form-label">Name</label>
                                      <input id="inputTitle" type="text" name="name" placeholder="Enter name"  value="{{$profile->name}}" class="form-control">
                                      @error('name')
                                      <span class="text-danger">{{$message}}</span>
                                      @enderror
                                      </div>
                              
                                      <div class="form-group">
                                          <label for="inputEmail" class="col-form-label">Email</label>
                                        <input id="inputEmail" disabled type="email" name="email" placeholder="Enter email"  value="{{$profile->email}}" class="form-control">
                                        @error('email')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                      </div>
                              
                                      <!-- <div class="form-group">
                                      <label for="inputPhoto" class="col-form-label">Photo</label>
                                      <div class="input-group">
                                          <span class="input-group-btn">
                                              <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                              <i class="fa fa-picture-o"></i> Choose
                                              </a>
                                          </span>
                                          <input id="thumbnail" class="form-control" type="text" name="photo" value="{{$profile->photo}}">
                                      </div>
                                        @error('photo')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                      </div> -->
                                      {{-- <div class="form-group">
                                          <label for="role" class="col-form-label">Role </label>
                                          <select name="role" class="form-control">
                                              <!--<option value="">-----Select Role-----</option>-->
                                                 <!-- <option value="admin" {{(($profile->role=='admin')? 'selected' : '')}}>Admin</option> -->
                                                  <option value="user" {{(($profile->role=='user')? 'selected' : '')}}>Customer</option>
                                          </select>
                                        @error('role')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                        </div> --}}
                                        <div class="form-group"> 
                                        <input type='file' onchange="readURL(this);" name="photo" value="{{old('photo')}}" style=" width: 237px;">
                                        <img id="blah" style="height:100px; wight: 100px;" />
                                        <div id="holder" style="height:10px; wight: 10px;"></div>
                          @error('photo')
                          <span class="text-danger">{{$message}}</span>
                          @enderror
                        </div>
                            <button type="submit" class="btn btn-success btn-sm">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
</section>
@endsection
<style>
    .breadcrumbs{
        list-style: none;
    }
    .breadcrumbs li{
        float:left;
        margin-right:10px;
    }
    .breadcrumbs li a:hover{
        text-decoration: none;
    }
    .breadcrumbs li .active{
        color:red;
    }
    .breadcrumbs li+li:before{
      content:"/\00a0";
    }
    .image{
        background:url('{{asset('backend/img/background.jpg')}}');
        height:150px;
        background-position:center;
        background-attachment:cover;
        position: relative;
    }
    .image img{
        position: absolute;
        top:55%;
        left:35%;
        margin-top:30%;
    }
    i{
        font-size: 14px;
        padding-right:8px;
    }
  </style> 

@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script>
    $('#lfm').filemanager('image');


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