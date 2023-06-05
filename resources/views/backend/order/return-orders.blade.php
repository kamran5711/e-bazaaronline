@extends('backend.layouts.master')

@section('main-content')
 <!-- DataTales Example -->
 <div class="card shadow m-3">
     <div class="row">
         <div class="col-md-12">
            @include('backend.layouts.notification')
         </div>
     </div>
   
     @php \App\Models\ReturnOrders::where('seen', 0)->update(['seen'=> 1]);  @endphp
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary float-left">Return Order Lists</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        @if( count($return_orders) > 0 )
         <table class="table table-bordered table-sm">
          <thead>
            <tr>
              <th>S.N.</th>
              <th>Order No</th>
              <th>Customer Remarks</th>
              <th>Store Remarks</th>
              <th>Status</th>
              <th class="text-center" style="width:150px">Action</th>
            </tr>
          </thead>
          <tbody>
            @php 
              $counter = 1;
              $colors_array = array("pending"=>"badge-info","accept"=>"badge-success","reject"=>"badge-danger");
              $status_array = array(
                                // "pending" ,
                                "accept" ,
                                "reject"
                              );

              
            @endphp
            @foreach($return_orders as $order)
            {{-- {{ dd($order) }} --}}
                <tr>
                    <td> {{ $counter++ }} </td>
                    <td> {{ $order->order->order_number }} </td>
                    <td> {{ \Illuminate\Support\Str::limit($order->client_remarks, 40,'...') }} </td>
                    <td> {{ \Illuminate\Support\Str::limit($order->store_remarks, 40,'...') }} </td>
                    <td>
                        <span class="badge {{$colors_array[$order->status]}}">{{ Str::ucfirst($order->status) }}</span>
                    </td>
                    <td>
                        <a href="{{route('order.show',$order->order->id)}}" class="btn btn-warning btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="view" data-placement="bottom"><i class="fas fa-eye"></i></a>
                        <a href="#" data-toggle="modal" data-target="#modal-{{ $counter }}" class="btn btn-info btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="view return remarks" data-placement="bottom"><i class="fas fa-reply"></i></a>
                        <a href="#" data-toggle="modal" data-target="#modal-{{ $counter }}-edit" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>

                        <form method="POST" action="{{route('order.return_order_delete',[$order->id])}}">
                          @csrf 
                          @method('delete')
                              <button class="btn btn-danger btn-sm dltBtn" data-id={{$order->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </td>
                </tr>  

                <!-- The Modal -->
                <div class="modal" id="modal-{{ $counter }}-edit">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                      <!-- Modal Header -->
                      <div class="modal-header">
                        <h4 class="modal-title">{{ $order->order->order_number }}</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>

                      <!-- Modal body -->
                      <div class="modal-body">
                        <form method="POST" action="{{ route('order.return_order_update')}}" id="reply-form-{{ $order->id }}">
                          @csrf
                          <input type="hidden" name="return_id" value="{{ $order->id }}" />
                          <label for="status{{ $order->id }}">Status:</label>
                          <select class="form-control" name="status" id="status{{ $order->id }}">
                            @foreach ($status_array as $s_a)
                              <option value="{{$s_a}}" {{ ($order->status == $s_a ? "selected":"") }} >{{ Str::ucfirst($s_a) }}</option>   
                            @endforeach
                          </select>
                          <div class="form-group">
                            <label for="message-text-{{ $order->id }}" class="col-form-label">Store Remarks:</label>
                            <textarea class="form-control" rows="10" name="store_remarks" id="message-text-{{ $order->id }}">{{ $order->store_remarks }}</textarea>
                          </div>
                        </form>
                      </div>

                      <!-- Modal footer -->
                      <div class="modal-footer">
                        <button type="submit" form="reply-form-{{ $order->id }}" class="btn btn-success">Submit</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                      </div>

                    </div>
                  </div>
                </div>
                {{-- end modal --}}

                <!-- The Modal -->
                <div class="modal" id="modal-{{ $counter }}">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                      <!-- Modal Header -->
                      <div class="modal-header">
                        <h4 class="modal-title">{{ $order->order->order_number }}</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>

                      <!-- Modal body -->
                      <div class="modal-body mt-3 mb-3">
                        <div><strong class="text-info">Client Remarks: </strong>{{ $order->client_remarks }}</div>
                        @if($order->store_remarks)
                          <hr />
                          <div><strong class="text-info">Store Remarks: </strong>{{ $order->store_remarks }}</div>
                        @endif
                      </div>

                      <!-- Modal footer -->
                      <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                      </div>

                    </div>
                  </div>
                </div>

                {{-- end modal --}}

            @endforeach
          </tbody>
        </table>
        <div class="d-flex justify-content-center">{{ $return_orders->links() }}</div>
        @else
          <h6 class="text-center">There are no return orders currently!!! </h6>
        @endif
      </div>
    </div>
</div>
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
        "sDom": "<'row'><'row'<'col-md-4'l><'col-md-4'B><'col-md-4'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
                //serverSide: true,
            "columnDefs":[
                {
                    "orderable":false,
                    "targets":[5,6],
                    'ordering': false,
                     'info': false,
                     'autoWidth': true,
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