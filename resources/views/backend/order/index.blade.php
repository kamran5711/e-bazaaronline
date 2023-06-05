@extends('backend.layouts.master')

@section('main-content')
 <!-- DataTales Example -->
 <div class="card shadow m-4">
     <div class="row">
         <div class="col-md-12">
            @include('backend.layouts.notification')
         </div>
     </div>
   
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary float-left">Order Lists</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        @if(count($orders)>0)
         <table class="table table-bordered table-sm">
          <thead>
            <tr>
              <th>S.N.</th>
              <th>Order No</th>
              <th>Customer</th>
              <th>Total items</th>
              <th>Total Amount (Rs)</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          @php $counter = 1;  $colors_array=array("Received"=>"badge-warning","Processed"=>"badge-primary","Dispatched"=>"badge-info","Delivered"=>"badge-success","Cancelled"=>"badge-danger");@endphp
            @foreach($orders as $order)  
            {{-- @php
                $product=DB::table('products')->where('id',$order->shipping_id)->pluck('price');
            @endphp 
            @php 
            $get_order_details=DB::table('order_details')->where('order_id',$order->id)->get();
            @endphp --}}
            {{-- @foreach($get_order_details as $row)
            @php
            $product=DB::table('products')->where('id',$row->product_id)->first();
            @endphp
            @endforeach --}}
                <tr>
                    <td>{{ $counter++ }}</td>
                    <td>{{$order->order_number}}</td>
                    <td>{{$order->user->name}}<br>{{$order->user->email}}</td>
                    <td>{{$order->quantity}}</td>
                    @php
                        $subTotal = 0;
                        $totalDiscount = 0;
                        // $get_order_details = DB::table('order_details')->where('order_id',$order->id)->get();
                    @endphp
                    @foreach($order->order_details as $o_d)
                        @php
                            // $product=DB::table('products')->where('id',$row->product_id)->first();
                            // $choice=\App\Models\Choice::where('id',$row->choice_id)->first();
                            // $size=\App\Models\Size::where('id',$row->size_id)->first();
                            // $color_name=is_null($choice)?"":$choice->color_name;
                            // $size_title=is_null($size)?"":$size->title;
                            //   if($row->sale_discount>0){
                            //       $net=$row->sale_price-($row->sale_price*($row->sale_discount/100));
                            //       $row->discounted_price=round($net);
                            //       $product->sub_total=round($net*$row->sale_quantity);
                            //   }

                            $discount = ($o_d->product->price * $o_d->product->discount)/100;
                            $product_price = $o_d->product->price;
                            $after_discount = $product_price -  $discount;
                            $subTotal = $subTotal + $after_discount * $o_d->sale_quantity;
                            $totalDiscount = $totalDiscount + $discount;
                        @endphp
                    @endforeach
                        <td>{{number_format( $subTotal- $order->coupon +$order->product_delivery,2)}}</td>

                    <td>
                        <span class="badge {{$colors_array[$order->status]}}">{{$order->status}}</span>
                    </td>
                    <td>
                        <a href="{{route('order.show',$order->id)}}" class="btn btn-warning btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="view" data-placement="bottom"><i class="fas fa-eye"></i></a>
                        <!--<a href="{{route('order.edit',$order->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>-->
                        @if(Auth::user()->role=='admin')
                        <form method="POST" action="{{route('order.destroy',[$order->id])}}">
                          @csrf 
                          @method('delete')
                              <button class="btn btn-danger btn-sm dltBtn" data-id={{$order->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                        </form>
                        @endif
                    </td>
                </tr>  
            @endforeach
          </tbody>
        </table>
        <span style="float:right">{{$orders->links()}}</span>
        @else
          <h6 class="text-center">There are no orders currently!!! </h6>
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