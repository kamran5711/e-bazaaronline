@extends('backend.layouts.master')

<style>
 p {
    margin-top: 0;
    margin-bottom: 0rem;
}
</style>
@section('main-content')
 <!-- DataTales Example -->
 <div class="card shadow mb-4">
     <div class="row">
         <div class="col-md-6">
            @include('backend.layouts.notification')
         </div>
     </div>
</div>
<form action="{{route('shopOrder')}}" method="POST" >
  @csrf
  <div class="row ml-1 mr-3">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          Catalog
        </div>
        <div class="card-body scroll">
            <div class="catalog">
             <table class="table">
               <thead>
                 <th>#</th>
                 <th>Product</th>
                 
                 <th>Size</th>
                 <th>Options</th>
                 <th>Price</th>
                 <th>Quantity</th>
                 <th>Total</th>
                 <th>Remove</th>
               </thead>
               <tbody>
               
               </tbody>
             </table>
            </div>
        </div>
        <div class="card-footer">
          <span class="card-total">Cart-Total : <span class="total">0</span></span> 
          <span>Shipping : <small>To be discussed on phone..</small></span>
          
          <span class="paying-amount">Paying Amount : <span class="pay">0</span> </span>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card ">
        <div class="card-header text-grey bg-default ">
           Products
        </div>
        <div class="card-body scroll">
  
            @if(count($products)>0)
              <div class="row">
                @foreach($products as $product) 
                    <div class="card mb-1 ml-1 mt-1 product-div" style="width: 7rem; height : 6rem; cursor: pointer;" data-id="{{$product->id}}">
                      <img src="{{ asset('products/images/products/'.$product->photo) }}" class="card-img-top product-img" alt="...">
                      <div class="card-body">
                        <p class="card-text title" style="margin-top: 0;margin-bottom: 0rem;">{{$product->title}}</p>
                        <p class="card-text"style="margin-top: 0;margin-bottom: 0rem;">  Rs. <span class="price">{{$product->selling_gross}}</span> 
                          <span class="badge badge-info"><span class="discount">{{$product->discount}}</span>% OFF</span> </p>
                          {{-- @if($product->size_option==1)
                           <select name="size_id" class="size">
                              @foreach($product->size as $size)
                                <option value="{{$size->id}}">{{$size->title}} </option>
                              @endforeach
                         </select>
                        @else
                       <input type="hidden" value="0" class="size" name="size_id" />
                        @endif --}}
                        <div class="size" style="display: none" value="{{json_encode($product->size)}}"></div>
  
                        {{-- @if($product->choice_option==1)
         
                           
                          <select name='choice_id' class="choice">
                              @foreach($product->choice as $choice)
                              <option value="{{$choice->id}}">{{$choice->color_name}}</option>
                              @endforeach
                          </select>
                    
                        @else
                          <input type="hidden" value="0" class="choice" name="choice_id" />
                        @endif --}}
                        <div class="choice" style="display: none" value="{{json_encode($product->choice)}}"></div>
  
                        {{$product->condition}}
                        
                          @if($product->stock>0)
                            <span class="badge badge-primary stock">{{$product->stock}}</span>
                          @else 
                            <span class="badge badge-danger stock">{{$product->stock}}</span>
                          @endif    
                      </div>
                    </div>
                @endforeach
              </div>
            @else
              <h6 class="text-center">No Products found!!! Please create Product</h6>
            @endif
          
        </div>
        <div class="card-footer">
          &puncsp;
        </div>
      </div>
    </div>
  </div>
  <div class="row ml-1 mt-2 mr-3 ">
    <div class="col-12">
      <div class="card ">
        <div class="card-header">
          Make Checkout Here
        </div>
        <div class="card-body">
          <p class="text-danger">Kindly double check your cart and proceed to place your order</p>
          <div class="total-amount">
            <div class="row">
              <div class="col-3">
                <div class="form">
                  <label for="customer">Select</label>
                  <select name="customer_id" id="customer" class="form-control">
                    <option value="">Select</option>
                    @foreach($customers as $customer)
                    <option value="{{$customer->id}}">{{$customer->name}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
  
              <div class="col-3">
                <div class="form-group">
                  <label for="coupon">Coupon Code</label>
                  <input type="text" name="coupon" id="coupon" class="form-control">
                </div>
              </div>
            </div>
            <div class="row mb-3"> 
              <div class="col-lg-8 col-12">
                  <div class="checkout-form">
                      
                      
                      <!-- Form -->
                      <div class="row"> 
                          <div class="col-sm-6">
                              <div class="form-group">
                                  <label>Name<span class="text-danger">*</span></label>
                                  <input type="text" name="name" class="form-control"  style="border-radius: 1rem;"  />
                                  @error('name')
                                      <span class='text-danger'>{{$message}}</span>
                                  @enderror
                              </div>
                          </div>
                          <div class="col-sm-6">
                              <div class="form-group">
                           <label>EMAIL <span class="text-danger">*</span></label>
                                  <input type="email" name="email" class="form-control" required  style="border-radius: 1rem;" />
                                  @error('email')
                                      <span class='text-danger'>{{$message}}</span>
                                  @enderror
                              </div>
                          </div>
                          </div>
                      <div class="row"> 
                          <div class="col-sm-6">
                              <div class="form-group">
                                  <label>Building Name / Number<span class="text-danger">*</span></label>
                                  <input type="text" name="building" class="form-control"  style="border-radius: 1rem;"  />
                                  @error('building')
                                      <span class='text-danger'>{{$message}}</span>
                                  @enderror
                              </div>
                          </div>
                          <div class="col-sm-6">
                              <div class="form-group">
                           <label>Address Line 1 <span class="text-danger">*</span></label>
                                  <input type="text" name="address1" class="form-control" required  style="border-radius: 1rem;"/>
                                  @error('address1')
                                      <span class='text-danger'>{{$message}}</span>
                                  @enderror
                              </div>
                          </div>
                          </div>
                          <div class="row">
                          <div class="col-sm-6">
                              <div class="form-group">
                                  <label>Address Line 2 <span></span></label>
                                  <input type="text" name="address2" class="form-control" style="border-radius: 1rem;"  />
                                  @error('address2')
                                      <span class='text-danger'>{{$message}}</span>
                                  @enderror
                              </div>
                          </div> 
                          <div class="col-sm-6">
                              <div class="form-group">
                                  <label> Area<span class="text-danger">*</span></label>
                                  <input type="text" name="area" class="form-control" required style="border-radius: 1rem;" />
                                  @error('area')
                                      <span class='text-danger'>{{$message}}</span>
                                  @enderror
                              </div>
                          </div>
                          </div>
                          <div class="row">
                          <div class="col-sm-6">
                              <div class="form-group">
                                  <label>City <span class="text-danger">*</span></label>
                                  <input type="text" name="city" class="form-control" style="border-radius: 1rem;" />
                                  @error('city')
                                      <span class='text-danger'>{{$message}}</span>
                                  @enderror
                              </div>
                          </div> 
                          <div class="col-sm-6">
                              <div class="form-group">
                                  <label>PostCode <span class="text-danger">*</span></label>
                                  <input type="text" name="postcode" class="form-control"  maxlength="7" size="7" required style="border-radius: 1rem;"  />
                                  @error('postcode')
                                      <span class='text-danger'>{{$message}}</span>
                                  @enderror
                              </div>
                          </div>
                          </div>
                          <div class="row">
                          <div class="col-sm-6">
                              <div class="form-group">
                                  <label>Phone <span class="text-danger">*</span></label>
                                  <input type="number" name="phone" class="form-control" required style="border-radius: 1rem;"  maxlength="11" size="11"/>
                                  @error('phone')
                                      <span class='text-danger'>{{$message}}</span>
                                  @enderror
                              </div>
                          </div>
                          <div class="col-sm-6">
                              <div class="form-group">
                                  <label>Delivery Date <span class="text-danger">*</span></label>
                                  <input type="date" name="delivery_date" class="form-control" min="{{date('Y-m-d')}}" required style="border-radius: 1rem;"/>
                                  @error('delivery_date')
                                      <span class='text-danger'>{{$message}}</span>
                                  @enderror
                              </div>
                          </div>
                          </div> 
                           @php
                              $total_amount=session('cart_total');
                              if(session('coupon')){
                                $total_amount=$total_amount-session('coupon')['value'];
                                  }
                              @endphp
  
                            @if($total_amount>100000)
                           <div class="col-sm-12">
                              <div class="form-group">
                                  <label>CNIC<span class="text-danger">*</span></label>
                                  <input type="text" name="cnic" maxlength="15" size="15" class="form-control" style="border-radius: 1rem;"/>
                                  @error('cnic')
                                      <span class='text-danger'>{{$message}}</span>
                                  @enderror
                              </div>
                          </div>
                          @endif
                       <div class="col-lg-12 col-md-12 col-12">
                              <div class="form-group">
                                  <label>Order Notes</label>
                                  <textarea   name="order_notes" rows="3" cols="60" class="form-control">  </textarea>
                                  @error('order_notes')
                                      <span class='text-danger'>{{$message}}</span>
                                  @enderror
                              </div>
                          </div>
                      <!--/ End Form -->
                  </div>
              </div>
              <div class="col-lg-4 col-12 border">
                  <div class="order-details">
                  
                      <!-- Order Widget -->
                      <div class="single-widget">
                          <h2>Payments</h2>
                          <div class="content">
                              <div class="checkbox">
                                  {{-- <label class="checkbox-inline" for="1"><input name="updates" id="1" type="checkbox"> Check Payments</label> --}}
                                  <form-group>
                                      @foreach($payments as $payment)
                                      <label class="btn-warning btn-sm"><input name="payment_id" type="radio" value="{{ $payment->id}}"> {{ $payment->title}}</label><br>
                                      <!-- <input name="payment_method"  type="radio" value="paypal"> <label> PayPal</label>  -->
                                      @endforeach
                                  </form-group>
                              </div>
                          </div>
                     
                      <!--/ End Order Widget -->
                   
                      <!-- Button Widget --> 
                        <div class="single-widget get-button">
                        <div class="content">
                   <div class="form-group text-left">
                  <div class="g-recaptcha brochure__form__captcha" data-sitekey="6Lfj_CQeAAAAAAAwa_5B8dgn5V6jCts-Rwbkyfhb">
                  </div>
                  </div>
                    
                          
                              <div class="button">
                                  <button type="submit" class="btn btn-primary">proceed to checkout</button>
                              </div>
                          </div>
                      </div>
                       </div>
                      <!--/ End Button Widget -->
                  </div>
              </div>
          </div>
          </div>
        </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
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
  <style>
    .scroll {
      min-height: 500px;
      max-height: 500px;
      overflow-y: auto;
  }
  </style>
@endpush

@push('scripts')

  <!-- Page level plugins -->
  <script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>


  <script>
    catalog = new Array();
    total = 0;
    pay = 0;
    // $(document)
    $('body').on('click','.product-div',function(){
   
      try {
        var self = $(this);
        var p_id = self.data('id');
        var img = self.find('.product-img').attr('src');
        var title = self.find('.title').html();
        var price = self.find('.price').html();
        var choice = self.find('.choice').attr('value');
        var size = self.find('.size').attr('value');
        var qty = 1;
        var ProductArr = {'product_id' : p_id,'qty' : qty,'img' : img, 'title' : title, 'price' : price, 'choice' : $.parseJSON(choice),'size' : $.parseJSON(size)};
      
          if(catalog.length > 0 ){
            var productsIDS = catalog.map(item => item.product_id);
            console.log(productsIDS);
            if($.inArray(p_id,productsIDS) != -1){
               return ;
            }
          }
         
        catalog.push(ProductArr); 
        var html = "";
        var inc = 1;
        var index = 0;
        var total = 0;
        catalog.forEach(arr => {
          html += '<tr>';
          html += '<td>';
          html += inc++;
          html += '</td>';
          html += '<td>';
          html += arr.title + '<img src="'+arr.img+'" class="img" width = "50">';;
          html += '</td>';
        


          html += '<td>';
            var a = 1;
            arr.size.forEach(ele => {
              "<label class='badge badge-info' for='size_"+inc+"'>"+ele.color_name+'<input type="radio" id="size_'+inc+'" name="size_'+arr.product_id+'[]"></label>';
            });

          html += '</td>';

          html += '<td>';

          arr.choice.forEach(element => {
            html += "<label class='badge badge-info' for='choice_"+inc+"'>"+element.color_name+'<input type="radio" id="choice_'+inc+'" name="choice_'+arr.product_id+'[]"></label>';
          });

          html += '</td>';
          html += '<td>';
            html += arr.price;
            total += arr.qty * arr.price; 
          html += '</td>';
          html += '<td>';
            html += "<input type='number' name='qty[]' class='form-control qty col-5' data-id="+arr.product_id+" data-price='"+arr.price+"' value='"+arr.qty+"'>";
            html += "<input type='hidden' name='p_id[]' class='form-control col-5' value='"+arr.product_id+"'>";

          html += '</td>';
          html += '<td>';
            html += "<span class='price' id='"+arr.product_id+"''>"+arr.price+"</span>";
          html += '</td>';
          html += '<td>';
            html += '<span class="fa fa-trash text-danger delete-p" data-productid="'+arr.product_id+'" data-id="'+index+'" style="cursor:pointer"></span>';
          html += '</td>';
          html += '<tr>';
          index++;
        });

        $('tbody').html(html);
        $('.total').text(total);
        $('.pay').text(total);

      } catch (error) {
        console.log(error);
      }
    });

    

    $('body').on('change','.qty',function(){
      var id = $(this).data('id');
      var price = $(this).data('price');
      var qty = $(this).val();
      var total = parseInt(qty) * price;
      var subtotal = $('.total').text();
      console.log(id,parseInt(qty),price,total);
      $('#'+id).text(total);
      $('.total').text(parseInt(subtotal) + total);
      $('.pay').text(parseInt(subtotal) + total);
    });

    $('body').on('click','.delete-p',function(){
      var index = $(this).data('id');
      var productid = $(this).data('productid');
      catalog.splice(index,1);
      var total = $('#'+productid).text();
      var sub_total = $('.total').text();
      var net_total = parseInt(sub_total) - parseInt(total) ;
      $('.total').text(net_total);
      $('.pay').text(net_total);
      $(this).parent().parent().remove();
    });
    ///////////
      // $(document).ready(function(){
      //   $.ajaxSetup({
      //       headers: {
      //           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      //       }
      //   });
      //     $('.dltBtn').click(function(e){
      //       var form=$(this).closest('form');
      //         var dataID=$(this).data('id');
      //         // alert(dataID);
      //         e.preventDefault();
      //         swal({
      //               title: "Are you sure?",
      //               text: "Once deleted, you will not be able to recover this data!",
      //               icon: "warning",
      //               buttons: true,
      //               dangerMode: true,
      //           })
      //           .then((willDelete) => {
      //               if (willDelete) {
      //                  form.submit();
      //               } else {
      //                   swal("Your data is safe!");
      //               }
      //           });
      //     })
      // })
  </script>
@endpush