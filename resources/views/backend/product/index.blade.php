@extends('backend.layouts.master')

@section('main-content')
 <!-- DataTales Example -->
 <div class="card shadow m-3">
     <div class="row">
         <div class="col-md-12">
            @include('backend.layouts.notification')
         </div>
     </div>
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary float-left">Product Lists</h6>
      <a href="{{route('product.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Add Product</a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        @if( count($products) >0)
        {{-- <table class="table table-bordered" id="product-dataTable" width="100%" cellspacing="0"> --}}
        <table class="table table-bordered table-sm">
          <thead>
            <tr>
              <th>#</th>
              <th>Title</th>
              <th>Price</th>
              {{-- <th>Discount</th> --}}
              <th width="50">%Off</th>
              <th width="50">Stock</th>
              <th>Photo</th>
              <th width="50">Status</th>
              <th width="120" class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
              @php
               $counter = 1;
              @endphp  
           
            @foreach($products as $product)   
                <tr> 
                    <td>{{ $counter++ }}</td>
                    <td>{{$product->title}}</td>
                    <td>{{$product->price}}</td>
                    <td> {{$product->discount}}%</td>
                    <td class="text-center">
                      @if($product->productStock->sum('stock') > 0)
                      <span class="badge badge-success">{{$product->productStock->sum('stock')}}</span>
                      @else 
                      <span class="badge badge-danger pl-2 pr-2">{{$product->productStock->sum('stock')}}</span>
                      @endif
                    </td>
                    <td>
                        <img  src="{{ asset('images/products/'.$product->photo) }}"
                        class="img-fluid zoom" style="max-width:80px" >
                    </td>
                    <td>
                        @if($product->status=='active')
                            <span class="badge badge-success">{{$product->status}}</span>
                        @else
                            <span class="badge badge-warning">{{$product->status}}</span>
                        @endif
                    </td>
                    <td class="text-center">
                      <a href="#" class="btn btn-info btn-sm float-left mr-2" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" onclick="showProductDetails({{ json_encode($product) }})" title="View" data-placement="bottom"><i class="fas fa-eye"></i></a>
                      <a href="{{route('product.edit',$product->id)}}" class="btn btn-primary btn-sm float-left" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                        <form method="POST" action="{{route('product.destroy',[$product->id])}}">
                          @csrf 
                          @method('delete')
                          <button class="btn btn-danger btn-sm dltBtn" data-id="{{$product->id}}" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </td>
                </tr>  
            @endforeach
          </tbody>
        </table>
        <span style="float:right">{{$products->links()}}</span>
        @else
          <h6 class="text-center">No Products are added yet, please add some products.</h6>
        @endif
      </div>
    </div>
</div>



  <!-- The Modal -->
  <div class="modal fade" id="productDetailsModal">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
      <div class="modal-content">
        
        <!-- Modal body -->
        <div class="modal-body" id="product_details">

        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
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

        function showProductDetails(obj){
          console.log(obj);
          var product_images_directory = "{{ asset('images/products/') }}";
          productDetails = `<div class='p-2'>
            <h3 class='modal-title text-primary font-weight-bold d-inline'>Product details</h3>
            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
          </div>
          <div class='table-responsive'>`;

            productDetails += `<table class='table table-sm table-bordered'>
              <thead>
                <tr>
                  <th colspan='3' class='text-center'><h3 class='text-capitalize'>Product Stock</th>
                </tr>
                <tr>
                  <th class='text-center text-info'><strong class='text-capitalize'>Stock</strong></th>
                  <th class='text-center text-info'><strong class='text-capitalize'>Color</strong></th>
                  <th class='text-center text-info'><strong class='text-capitalize'>Size</strong></th>
                </tr>
            </thead>
            <tbody>`;
              for (let i = 0; i < obj.product_stock.length; i++) {
                productDetails += `<tr class="text-center"><td>${obj.product_stock[i].stock}</td><td>${obj.product_stock[i].color.title}</td><td>${obj.product_stock[i].size.title}</td></tr>`;
              }
            productDetails += `</tbody>
             </table>`;
            productDetails += `<table class='table table-sm table-bordered'>
              <thead>
                <tr>
                  <th colspan='2' class='text-center'><h3 class='text-capitalize'>${obj.title}</h3></th>
                </tr>
            </thead>
            <tbody>
              <tr>
                <th>Category</th>
                <td>${obj.category.title}</td>
              </tr>`;
              if(obj.sub_category_id){
                productDetails += `<tr>
                <th>Sub Category</th>
                <td>${obj.sub_category.title}</td>
              </tr>`;
              }
          productDetails += `<tr>
                <th>Brand</th>
                <td>${obj.brand.title}</td>
              </tr>`;
              if(obj.is_featured == 1){
                productDetails += `<tr>
                                      <th>Featured</th>
                                      <td>Yes</td>
                                  </tr>`;
              }

              productDetails += `
              <tr>
                <th>Product Type</th>
                <td>${obj.condition}</td>
              </tr>`;
              productDetails += `
              <tr>
                <th>Product Stock</th>
                <td>${obj.stock}</td>
              </tr>`;
              productDetails += `
              <tr>
                <th>Status</th>
                <td>${obj.status}</td>
              </tr>`;

              productDetails += `
              <tr>
                <th>Return Policy</th>
                <td>${obj.return_policy}</td>
              </tr>`;

              productDetails += `
              <tr>
                <th>Purchasing price</th>
                <td>${obj.purchasing_price}</td>
              </tr>`;

              productDetails += `
              <tr>
                <th>Product Thumbnail</th>
                <td><img src="${product_images_directory}/${obj.photo}"
                        class="img-fluid zoom" style="max-width:80px" /></td>
              </tr>`;

              if(obj.purchasing_tax != null){
                productDetails += `<tr>
                                      <th>Purchasing Tax</th>
                                      <td>${obj.purchasing_tax}</td>
                                  </tr>`;
              }
              if(obj.purchasing_gross != null){
                productDetails += `<tr>
                                      <th>Purchasing Gross</th>
                                      <td>${obj.purchasing_gross}</td>
                                  </tr>`;
              }

              productDetails += `
              <tr>
                <th>Selling price</th>
                <td>${obj.price}</td>
              </tr>`;
              if(obj.discount != null){
                productDetails += `<tr>
                                      <th>Selling Discount</th>
                                      <td>${obj.discount}</td>
                                  </tr>`;
              }
              
              if(obj.selling_gross != null){
                productDetails += `<tr>
                                      <th>Selling Gross</th>
                                      <td>${obj.selling_gross}</td>
                                  </tr>`;
              }
              if(obj.images.length > 0){
                productDetails += `<tr><th colspan='2' class='text-center'><h5 class='text-capitalize'>Product images</h5></th></tr><tr><td colspan='2'>`;
                for (let index = 0; index < obj.images.length; index++) {
                  var img = obj.images[index];
                  productDetails += `<img src="${product_images_directory}/${img.image}"
                        class="img-fluid img-thumbnail m-2" style="max-width:120px; hieght:auto;" />`;
                }
                productDetails += `</td></tr>`;
              }            
              
              productDetails += `
            </tbody>
          </table>
        </div>
        ${obj.description}`;
          $('#product_details').html(productDetails);
          // $('#productDetailsModal').modal('toggle');
          $('#productDetailsModal').modal('show');
          // $('#productDetailsModal').modal('hide');
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