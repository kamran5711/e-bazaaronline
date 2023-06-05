@extends('backend.layouts.master')

@section('main-content')
 <!-- DataTales Example -->
 <div class="card shadow mb-4">
     <div class="row">
         <div class="col-md-12">
            @include('backend.layouts.notification')
         </div>
     </div>
    <div class="card-body">
      <div class="table-responsive">
        @if(count($products)>0)
        <table class="table table-bordered" id="product-dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Title</th>
              <th>Price</th>
              <th>Discount</th>
              <th>Size</th>
              <th>Color</th>
              <th>Condition</th>
              <th>Stock</th>
              <th>Photo</th>
              <th>Add To Cart</th>
            </tr>
          </thead>
          <tbody>  
           
            @foreach($products as $product) 
            <form action="{{route('add-to-cart',$product->id)}}" method="POST">
              {{csrf_field()}}   
              @php 
              $sub_cat_info=DB::table('categories')->select('title')->where('id',$product->child_cat_id)->get();
              // dd($sub_cat_info);
              $brands=DB::table('brands')->select('title')->where('id',$product->brand_id)->get();
              
             @endphp
                <tr> 
                    <td>{{$product->title}}<input type="hidden" value="{{$product->id}}" name="product_id" /></td>
                    
                    <td>Rs. {{$product->selling_gross}} </td>
                    
                    <td> {{$product->discount}}% OFF</td>
                    <td>
                        @if($product->size_option==1)
                        @php
                        $sizes=DB::table('sizes')->where('product_id',$product->id)->where('deleted_flag',0)->get();
                        if($sizes){
                        $sizes=$sizes;
                        }else{
                        $sizes=null;
                        }
                        @endphp
                       <select name="size_id">
                       @foreach($sizes as $size)
                      <option value="{{$size->id}}">{{$size->title}} </option>
                      @endforeach
                     </select>
                    @else
                   <input type="hidden" value="0" name="size_id" />
                    @endif
                    </td>
                    <td>
                        @if($product->choice_option==1)
                        @php $choices=DB::table('choices')->where('product_id',$product->id)->where('deleted_flag',0)->get();
                        if($choices){
                        $choices=$choices;
                        }else{
                        $choices=null;
                        }
                        @endphp
                       
                            <select name='choice_id'>
                                @foreach($choices as $choice)
                                <option value="{{$choice->id}}">{{$choice->color_name}}</option>
                                @endforeach
                            </select>
                        
                        @else
                       <input type="hidden" value="0" name="choice_id" />
                        @endif
                       </td>
                    <td>{{$product->condition}}</td>
                    <td>
                      @if($product->stock>0)
                      <span class="badge badge-primary">{{$product->stock}}</span>
                      @else 
                      <span class="badge badge-danger">{{$product->stock}}</span>
                      @endif
                    </td>
                    <td>
                        <img  src="{{ asset('products/images/products/'.$product->photo) }}"
                        class="img-fluid zoom" style="max-width:80px" >
                    </td>
                    
                    <td>
                      <button type="submit" name="btn_add_to_cart"
                      class="btn-warning btn-sm min" title="Add to cart">Add to
                      cart</button>
                      {{-- <button type="submit" href="{{route('product.edit',$product->id)}}" name="btn_add_to_cart" class="btn-warning btn-sm min" title="Add to cart">Add to cart</button> --}}
                    </td>
                </tr>  
              </form>
            @endforeach
          </tbody>
        </table>
        <span style="float:right">{{$products->links()}}</span>
        @else
          <h6 class="text-center">No Products found!!! Please create Product</h6>
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
      .zoom {
        transition: transform .2s; /* Animation */
      }

      .zoom:hover {
        transform: scale(5);
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
      
      
      $('#product-dataTable').DataTable( {
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