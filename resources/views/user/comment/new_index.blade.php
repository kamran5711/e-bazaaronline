@extends('frontend.layouts.customer-layout')

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
                      <div class="table-responsive">
                        @if(count($comments)>0)
                        <table class="table table-bordered" id="order-dataTable" width="100%" cellspacing="0">
                          <thead>
                            <tr>
                              <th>S.N.</th>
                              <th>Author</th>
                              <th>Post Title</th>
                              <th>Message</th>
                              <th>Date</th>
                              <th>Status</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tfoot>
                            <tr>
                              <th>S.N.</th>
                              <th>Author</th>
                              <th>Post Title</th>
                              <th>Message</th>
                              <th>Date</th>
                              <th>Status</th>
                              <th>Action</th>
                            </tr>
                          </tfoot>
                          <tbody>
                            @foreach($comments as $comment)
                            {{-- {{$comment}}   --}}
                              @php 
                              $title=DB::table('posts')->select('title')->where('id',$comment->post_id)->get();
                              @endphp
                                <tr>
                                    <td>{{$comment->id}}</td>
                                    <td>{{$comment->user_info['name']}}</td>
                                    <td>@foreach($title as $data){{ $data->title}} @endforeach</td>
                                    <td>{{$comment->comment}}</td>
                                    <td>{{$comment->created_at->format('M d D, Y g: i a')}}</td>
                                    <td>
                                        @if($comment->status=='active')
                                          <span class="badge badge-success">{{$comment->status}}</span>
                                        @else
                                          <span class="badge badge-warning">{{$comment->status}}</span>
                                        @endif
                                    </td>
                                    <td>
                                      <div class="btn-group">
                                        <a href="{{route('customer.comments.edit',$comment->id)}}?k={{request()->get('k')}}" class="btnn btn-sm btn-warning"  data-toggle="tooltip" title="edit" data-placement="bottom"> <i class="ti-pencil-alt2"></i> </a>
                                        <form method="POST" action="{{route('user.post-comment.delete',[$comment->id])}}">
                                          @csrf 
                                          @method('delete')
                                              <button class="btnn btn-danger btn-sm dltBtn" data-id={{$comment->id}}  data-toggle="tooltip" data-placement="bottom" title="Delete"> <i class="ti-eraser"></i> </button>
                                        </form>
                                      </div>
                                    </td>
                                </tr>  
                            @endforeach
                          </tbody>
                        </table>
                        <span style="float:right">{{$comments->links()}}</span>
                        @else
                          <h6 class="text-center">No post comments found!!!</h6>
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