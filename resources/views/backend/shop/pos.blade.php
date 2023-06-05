@extends('backend.layouts.master')
<style>
 p {
    margin-top: 0;
    margin-bottom: 0rem;
}
</style>
<link rel="stylesheet" href="{{asset('frontend/css/themify-icons.css')}}">
@section('main-content')

<div class="card shadow m-3">
  <div class="row mb-0 mt-4 ml-2 mr-2">
      <div class="col-md-12">
         @include('backend.layouts.notification')
      </div>
  </div>
 {{-- <div class="card-header py-3">
   <h6 class="m-0 font-weight-bold text-primary float-left">Product Lists</h6>
 </div> --}}
 <div class="card-body">
    <div class="row" id="response_message">
        
    </div>
    <form action="/" class="form">
      <div class="input-group">
          <input class="form-control rounded-0" placeholder="Search the products by name" type="text" name="search_product" id="search_product" onkeyup="search(this)" />
          <button class="btn btn-primary rounded-0" type="submit" id="btn_search"><i class="fa fa-search"></i></button>
      </div>
    </form>
    <div id="searched_products" class="mt-2 mb-2"></div>
    <div id="cart_items_wrapper"></div>
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
  <!-- End Modal -->

  <!-- The Modal -->
    <div class="modal fade" id="checkOutModal">
      <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
          <!-- Modal body -->
          <div class="modal-body">
            <form class="form checkout-form" method="POST" action="{{route('shop.place.order')}}" id="customerForm">
              <input type="hidden" name="store_id" value="{{ auth()->user()->store_id }}" />
              {{-- <input type="hidden" name="user_id" value="" /> --}}
              @csrf
              <div class="row d-flex justify-content-center mb-5 mt-5">
                <h4><strong class="text-info">Kindly double check cart and proceed to place the order.</strong></h4>
              </div>
              <div class="row" id="customerFormResponse">
        
              </div>

              @php
                $total_amount = session('cart_total');
                $coupon_total = 0;
              @endphp
              @if(session()->has('coupons'))
                @foreach (session()->get('coupons') as $coupon)
                  @php $coupon_total += $coupon['value']; @endphp
                @endforeach
                @php $total_amount = $total_amount - $coupon_total; @endphp
              @endif
              @if(session()->has('cart'))
                <div class="row">
                  <div class="col-md-12">
                    <div class="table-responsive">
                      <table class="table table-sm table-bordered">
                        <tr>
                          <th>#</th>
                          <th>Product</th>
                          <th>color</th>
                          <th>Size</th>
                          <th>Price & Discount</th>
                          <th>Quantity</th>
                          <th>Price</th>
                        </tr>
                        <tbody id="checkout_modal_cart_info">
                        {{-- @php $counter__ = 1; $subTotal = 0; $totalDiscount = 0; @endphp
                        @foreach (session()->get('cart') as $key => $cart)
                          @php
                            $color_id = $cart['choice_id'];
                            $size_id = $cart['size_id'];
                            $product = App\Models\Product::with(['productStock' => function($query) use ($color_id, $size_id) {
                                          $query->where(['color_id' => $color_id, 'size_id' => $size_id])->with(['color', 'size']);
                                      }])->where('id', $cart['id'])->first();
                            $discount = ($product->price * $product->discount)/100;
                            $product_price = $product->price;
                            $after_discount = $product_price - $discount;
                            $subTotal = $subTotal + $after_discount * $cart['quantity'];
                            $totalDiscount = $totalDiscount + $discount;
                          @endphp
                          <tr>
                            <td>{{ $counter__++ }}</td>
                            <td>{{ $product->title }}</td>
                            <td>{{ $product->productStock[0]->color->title }}</td>
                            <td>{{ $product->productStock[0]->size->title }}</td>
                            <td>{{ ($discount) ? $product_price . " - " . $discount : $product_price }}</td>
                            <td>{{ $after_discount }} * {{ $cart['quantity'] }}X</td>
                            <td style="width: 200px"><input type="text" name="paid_amount[]" class="form-control rounded-0" value="{{ $after_discount * $cart['quantity'] }}"></td>
                          </tr>
                        </tbody>
                        @endforeach --}}
                      </table>
                    </div>
                  </div>
                </div>
              @endif
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="total_amount">Pay amount <span class="text-danger">*</span></label>
                    <input type="number" name="total_amount" class="form-control" value="{{ $total_amount }}" id="total_amount" required/>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group mt-4 pt-2">
                  <label for="add_customer_data" class="form-control w-100 text-left">
                    <input type="checkbox" name='add_customer_data' id='add_customer_data' checked onchange="toggleCustomerForm()"/> Add customer information.</label>
                  </div>
                </div>
              </div>
              <div id="customer_form">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="name">Name <span class="text-danger">*</span></label>
                      <input type="text" name="name" class="form-control" value="" id="name" required/>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="email">Email <span class="text-danger">*</span></label>
                      <input type="email" name="email" class="form-control" value="" id="email" required/>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="phone">Phone <span class="text-danger">*</span></label>
                      <input type="number" name="phone" class="form-control" value="" id="phone" required/>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="country_id">Country <span class="text-danger">*</span></label>
                      <select class="form-select select2 form-control" name="country_id" id="country_id" onchange="getStatesByCountryId(this)" required>
                        <option value="">Select Country</option>
                        @foreach($countries as $country)
                          <option value="{{$country->id}}">{{$country->name}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>

                <div class="row"> 
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="state_id">State <span class="text-danger">*</span></label>
                      <select class="form-select select2 form-control" name="state_id" id="state_id" onchange="getCitiesByStateId(this)" required>
                        <option value="">Select Country First</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="city_id">City <span class="text-danger">*</span></label>
                        <select class="form-select select2 form-control" name="city_id" id="city_id" required>
                            <option value="">Select State First</option>
                        </select>
                      </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                      <div class="form-group">
                        <label for="address1">Address Line 1 <span class="text-danger">*</span></label>
                        <input type="text" name="address1" class="form-control" value="" id="address1" required />
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="address2">Address Line 2</label>
                          <input type="text" name="address2" class="form-control"value="" id="address2"/>
                      </div>
                  </div> 
                </div>

                <div class="row">
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="post_code">PostCode</label>
                          <input type="text" name="postcode" class="form-control"  maxlength="7" size="7" id="post_code" value=""/>
                      </div>
                  </div>
                </div> 
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="order_notes">Order Notes</label>
                        <textarea name="order_notes" class="form-control" id="order_notes" rows="3" cols="60"></textarea>
                    </div>
                  </div>
                </div>

              </div>
              <div class="row">
                <div class="col-md-12 mt-3">
                  <div class="form-group">
                    <button class="btn btn-primary" type="submit" id="customerFormBtn">Proceed the order</button>
                  </div>
                </div>
              </div>
            </form>
            <!--/ End Form -->
          </div>        
          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
          
        </div>
      </div>
    </div>
  <!-- End Modal -->


@endsection

@push('scripts')
  <script>
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#btn_search").click(function(e){
        e.preventDefault();
        search(document.getElementById("search_product"));
    });
    function search(search) {
      if(search.value.length < 3){
        $("#searched_products").html('');
        return;
      } 
      $.ajax({
          type:'POST',
          url: "{{ route('search_product_ajax') }}",
          data: { search: search.value, _token: "<?php echo csrf_token() ?>" },
          success:function(data) {
            $("#searched_products").html(data);
          }
      });
      
    }

    function toggleCustomerForm() {
      var display_ = false;
      if( $('#add_customer_data').prop("checked") == true ){
        $('#customer_form').fadeIn();
        display_ = true;
      }else{
        $('#customer_form').fadeOut();
      }
      $("#name").prop('required', display_);
      $("#email").prop('required', display_);
      $("#phone").prop('required', display_);
      $("#address1").prop('required', display_);
      $("#country_id").prop('required', display_);
      $("#state_id").prop('required', display_);
      $("#city_id").prop('required', display_);
      // address2
      // post_code
    }

    document.getElementById("customerForm").addEventListener("submit", function(event){
      event.preventDefault();
      var formValues= $(this).serialize();
      var actionUrl = $(this).attr("action");
      var message_wrapper = document.getElementById('customerFormResponse');
      $("#customerFormBtn").html('Please wait...').addClass('btn-info').removeClass('btn-primary').prop('disabled', true);
      $.ajax({
        method:'POST',
        url: actionUrl,
        data: formValues,
        success:function(data) {
          if(data.error == false)
            message_wrapper.innerHTML = `<div class="alert alert-success w-100 mb-3 ml-3 mr-3" id="success-alert">
                                          <button type="button" class="close" data-dismiss="alert">x</button>
                                          <strong>Success! </strong> ${data.message}.
                                      </div>`;
            getCartItems();
            $("#success-alert").fadeTo(3000, 500).slideUp(500, function() {
              $("#success-alert").slideUp(500);
            });
        },
        error:function(error) {
          message_wrapper.innerHTML = `<div class="alert alert-danger w-100 mb-3 ml-3 mr-3" id="danger-alert">
                                          <button type="button" class="close" data-dismiss="alert">x</button>
                                          <strong>Error! </strong> ${error.responseJSON.message}.
                                      </div>`;
            getCartItems();
            $("#danger-alert").fadeTo(3000, 500).slideUp(500, function() {
              $("#danger-alert").slideUp(500);
            });
        }
      });
      setTimeout(() => {
        $('#checkOutModal').modal('hide');
        $("#customerFormBtn").html('Proceed the order').removeClass('btn-info').addClass('btn-primary').prop('disabled', false);
      }, 5000);
    });

    var product_images_directory = "{{ asset('images/products/') }}";
    function showProductDetails(obj){
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
          var total_stock = 0; 
          for (let i = 0; i < obj.product_stock.length; i++) {
            total_stock = parseInt(obj.product_stock[i].stock) + parseInt(total_stock);
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
            <td>${total_stock}</td>
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
      $('#productDetailsModal').modal('show');
  }

  function RemoveCartItem(id) {
    // alert(id);
    $.ajax({
        method:'POST',
        url: "{{ route('remove_cart_item') }}",
        data: { _token: "<?php echo csrf_token() ?>", id },
        success:function(data) {
            var message_wrapper = document.getElementById('response_message');
          if(data.error == false)
            message_wrapper.innerHTML = `<div class="alert alert-success w-100 mb-3 ml-3 mr-3" id="success-alert">
                                          <button type="button" class="close" data-dismiss="alert">x</button>
                                          <strong>Success! </strong> ${data.message}.
                                      </div>`;
            getCartItems();
            $("#success-alert").fadeTo(5000, 500).slideUp(500, function() {
              $("#success-alert").slideUp(500);
            });
        }
    });
  }
  function getCartItems() {
    $.ajax({
            url: "{{ route('get_cart_items_view') }}",
            method:'GET',
            data: { },
            success:function(data) {
              document.getElementById('cart_items_wrapper').innerHTML = data;
            }
          });
  }
  getCartItems();
  function add_to_cart_form_process(e) {
    var product_id = document.getElementById('product_id').value;
    var choice_id = document.getElementById('color').value;
    var size_id = document.getElementById('size').value;
    var quantity = document.getElementById('quantity').value;
    $.ajax({
        type:'POST',
        url: "{{ route('add_to_cart_process') }}",
        data: { _token: "<?php echo csrf_token() ?>", product_id, choice_id, size_id, quantity },
        success:function(data) {
          var message_wrapper = document.getElementById('response_message');
          if(data.error == false)
          message_wrapper.innerHTML = `<div class="alert alert-success w-100 mb-3 ml-3 mr-3" id="success-alert">
                                          <button type="button" class="close" data-dismiss="alert">x</button>
                                          <strong>Success! </strong> ${data.message}.
                                      </div>`;
            getCartItems();
            $("#success-alert").fadeTo(5000, 500).slideUp(500, function() {
              $("#success-alert").slideUp(500);
            });
            $('#productDetailsModal').modal('hide');

          // $("#searched_products").html(data);
        }
    });
  }
  // document.getElementById("add_to_cart_form").addEventListener("submit", function (e) {
  //   e.preventDefault();
  // });

  
  function addToCartModal(obj){
      productDetails = `<div class='p-2'>
        <h3 class='modal-title text-primary font-weight-bold d-inline'>Add to cart</h3>
        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>
      <div class='table-responsive'>`;

        productDetails += `<table class='table table-sm table-bordered'>
          <thead>
            <tr>
              <th colspan='3' class='text-center'><h4 class='text-capitalize'>Product Stock</h4></th>
            </tr>
            <tr>
              <th class='text-center text-info'><strong class='text-capitalize'>Stock</strong></th>
              <th class='text-center text-info'><strong class='text-capitalize'>Color</strong></th>
              <th class='text-center text-info'><strong class='text-capitalize'>Size</strong></th>
            </tr>
        </thead>
        <tbody>`;
          var color_options = size_options = stock_options = '';
          for (let i = 0; i < obj.product_stock.length; i++) {
            color_options += `<option value="${obj.product_stock[i].color.id}">${obj.product_stock[i].color.title}</option>`;
            size_options += `<option value="${obj.product_stock[i].size.id}">${obj.product_stock[i].size.title}</option>`;
            productDetails += `<tr class="text-center"><td>${obj.product_stock[i].stock}</td><td>${obj.product_stock[i].color.title}</td><td>${obj.product_stock[i].size.title}</td></tr>`;
          }
        productDetails += `</tbody>
          </table></div>`;

        productDetails += `<form method="post" action="{{route('product.store')}}" enctype="multipart/form-data" id="add_to_cart_form">`;
        productDetails += `<input type="hidden" name="product_id" value="${obj.id}" id="product_id" />`;
        productDetails += `<div class="row">
                            <div class="col-md-4">
                              <div class="form-group ">
                                <label for="color">Color <span class="text-danger">*</span></label>
                                <select name="color" class="form-control" id="color" >
                                    ${color_options}
                                </select>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="size">Size <span class="text-danger">*</span></label>
                                <select name="size" class="form-control" id="size" >
                                    ${size_options}
                                </select>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="quantity">Qauntity <span class="text-danger">*</span></label>
                                <input id="quantity" type="number" name="quantity" placeholder="Enter the quantity"  value="1" class="form-control" required="required">
                              </div>
                            </div>
                            </div>
                            <div class="row d-flex flex-row-reverse">
                              <a href="javascript:void(0);" class="btn btn-primary btn-sm mr-3 rounded-0 p-2 float-right" data-toggle="tooltip" title="Add to cart" data-placement="bottom" id="add_to_cart_button" onclick="add_to_cart_form_process(this)"><i class="fas fa-plus"></i> Add To Cart</a>
                            </div>
                          </form>`;
      $('#product_details').html(productDetails);
      // $('#productDetailsModal').modal('toggle');
      $('#productDetailsModal').modal('show');
      // $('#productDetailsModal').modal('hide');
  }

  function checkOutCart() {
    var data_to_append = "";
    var subTotal = totalDiscount = counter = 0;
    $(".products-info").each(function(){
      var productDiscount = $(this).attr('product-discount');
      var productPrice = parseInt($(this).attr('product-price'));
      var productQuantity = $(this).attr('product-quantity');
      var after_discount = productPrice - productDiscount;
      subTotal = subTotal + (after_discount * productQuantity);
      
      totalDiscount = totalDiscount + productDiscount;
      data_to_append +=  `<tr><td>${++counter}</td>`;
      data_to_append += `<td>${$(this).attr('product-name')}</td>`;
      data_to_append += `<td>${$(this).attr('product-color')}</td>`;
      data_to_append += `<td>${$(this).attr('product-size')}</td>`;
      if(productDiscount == 0 ){
        data_to_append += `<td>${productPrice}</td>`;
      }else{
        data_to_append += `<td>${productPrice} - ${productDiscount}</td>`;
      }
      data_to_append += `<td>${after_discount} * ${productQuantity}X</td>`;
      data_to_append += `<td style="width: 200px"><input type="text" name="paid_amount[]" class="form-control rounded-0" value="${after_discount * productQuantity}"></td>`;
      data_to_append += `</tr>`;
    });
    $("#checkout_modal_cart_info").html(data_to_append);
    $("#total_amount").val(subTotal);
    $('#checkOutModal').modal('show');
  }

  function getStatesByCountryId(country) {
      var country_id = country.value;
      $.ajax({
          url: "{{url('get-states-by-country-id').'/'}}"+country_id,
          method: 'GET',
          success:function(response){
              $('#state_id').html("");
              if(response.length === 0)
              $('#state_id').html("<option>No states found against country</option");
              $('#city_id').html("<option value=''>select state first</option");
              $.each(response, function (index, value) {
                  if(index == 0 )
                  $('#state_id').append('<option>Select State</option>');
                  $('#state_id').append('<option value="' + value.id + '">' + value.name + '</option>');
              });
          },
          error: function(response) {
              $('#state_id').html("<option>No states found against country</option");
              console.log(response);
          }
      });
  }


  function getCitiesByStateId(state) {
      var state_id = state.value;
      $.ajax({
          url: "{{url('get-cities-by-state-id').'/'}}"+state_id,
          method: 'GET',
          success:function(response){
              $('#city_id').html("");
              if(response.length === 0)
              $('#city_id').html("<option>No cities found against state</option");
              $.each(response, function (index, value) {
                  if( index == 0 )
                  $('#city_id').append('<option>Select City</option>');
                  $('#city_id').append('<option value="' + value.id + '">' + value.name + '</option>');
              });
          },
          error: function(response) {
              $('#city_id').html("<option>No cities found against state</option");
              console.log(response);
          }
      });
  }
</script>
@endpush