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
							<li class="active"><a href="#">Reviews</a></li>
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
                        <div class="table-responsive">
                            @if(count($reviews)>0)
                            <table class="table table-bordered" id="order-dataTable" width="100%" cellspacing="0">
                              <thead>
                                <tr>
                                  <th>S.N.</th>
                                  <th>Review By</th>
                                  <th>Product Title</th>
                                  <th>Review</th>
                                  <th>Rate</th>
                                  <th>Date</th>
                                  <th>Status</th>
                                  <th>Action</th>
                                </tr>
                              </thead>
                              <tfoot>
                                <tr>
                                  <th>S.N.</th>
                                  <th>Review By</th>
                                  <th>Product Title</th>
                                  <th>Review</th>
                                  <th>Rate</th>
                                  <th>Date</th>
                                  <th>Status</th>
                                  <th>Action</th>
                                  </tr>
                              </tfoot>
                              <tbody>
                                @foreach($reviews as $review)  
                                  @php 
                                  $title=DB::table('products')->select('title')->where('id',$review->product_id)->get();
                                  @endphp
                                    <tr>
                                        <td>{{$review->id}}</td>
                                        <td>{{$review->user_info['name']}}</td>
                                        <td>@foreach($title as $data){{ $data->title}} @endforeach</td>
                                        <td>{{$review->review}}</td>
                                        <td>
                                         {{-- <ul style="list-style:none">
                                              @for($i=1; $i<=5;$i++)
                                              @if($review->rate >=$i)
                                                <li style="float:left;color:#F7941D;">
                                                  <i class="fa fa-star"></i>
                                                </li>
                                              @else 
                                                <li style="float:left;color:#F7941D;">
                                                  <i class="far fa-star-o"></i>
                                                </li>
                                              @endif
                                            @endfor
                                         </ul> --}}
                                         <div class="rating-main">
                                          <ul class="rating">
                                            @for($i=1; $i<=5;$i++)
                                              @if($review->rate >=$i)
                                                <li style="float:left;color:#F7941D;"><i class="fa fa-star"></i></li>
                                              @else 
                                                <li style="float:left;color:#F7941D;" class="dark"><i class="fa fa-star-o"></i></li>
                                              @endif
                                           
                                            @endfor
                                          </ul>
                                        </div>
                                        </td>
                                        <td>{{$review->created_at->format('M d D, Y g: i a')}}</td>
                                        <td>
                                            @if($review->status=='active')
                                              <span class="badge badge-success">{{$review->status}}</span>
                                            @else
                                              <span class="badge badge-warning">{{$review->status}}</span>
                                            @endif
                                        </td>
                                        <td>
                                          <div class="btn-group">
                                            <a href="{{route('customer.review_edit',$review->id)}}" class="btnn btn-warning btn-sm"  data-toggle="tooltip" title="edit" data-placement="bottom"><i class="ti-pencil-alt2"></i></a>
                                            <form method="POST" action="{{route('customer.review_delete',[$review->id])}}">
                                              @csrf 
                                              @method('delete')
                                                  <button class="btnn btn-danger btn-sm dltBtn" data-id={{$review->id}}  data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="ti-eraser"></i></button>
                                            </form>
                                            </div>
                                        </td>
                                    </tr>  
                                @endforeach
                              </tbody>
                            </table>
                            <span style="float:right">{{$reviews->links()}}</span>
                            @else
                              <h6 class="text-center">No reviews found!!!</h6>
                            @endif
                          </div>
                    </div>
                </div> 
            </div>
        </div>
</section>
@endsection
@push('styles')
  <link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
  <style>
      div.dataTables_wrapper div.dataTables_paginate{
          display: none;
      }
  </style>
@endpush

@push('scripts')

  <!-- Page level plugins -->
  <script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="{{asset('backend/js/demo/datatables-demo.js')}}"></script>
  <script>
      
      $('#order-dataTable').DataTable( {
            "columnDefs":[
                {
                    "orderable":false,
                    "targets":[5,6]
                }
            ]
        } );

        // Sweet alert

        function deleteData(id){
            
        }
  </script>
  <script>
      $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
          $('.dltBtn').click(function(e){
            var form=$(this).closest('form');
              var dataID=$(this).data('id');
              // alert(dataID);
              e.preventDefault();
              swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                       form.submit();
                    } else {
                        swal("Your data is safe!");
                    }
                });
          })
      })
  </script>
@endpush