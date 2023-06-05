@extends('backend.layouts.master')
@section('main-content')
<style>
img{background: white;}
input[type=file]{padding:4px;background: white;}
.hidden{display:none;}
.btn-default{border:1px solid;}

.sd-box {
  background-color: #ffffff;
  position: relative;
  /* padding: 25px 20px; */
  width: 100%;
  text-align: center;
  border: 1px solid #EBE9E9;
  border-radius: 2px;
  /* line-height: 18px; */
}
</style>
<div class="card m-3">
    <h5 class="card-header">Add Product</h5>
    <div class="card-body">
      <form method="post" action="{{route('product.store')}}" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="inputTitle">Title <span class="text-danger">*</span></label>
              <input id="inputTitle" type="text" name="title" placeholder="Enter title"  value="{{old('title')}}" class="form-control" required="required">
              @error('title')
              <span class="text-danger">{{$message}}</span>
              @enderror
            </div>
          </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="brand_id">Brand</label>
            {{-- {{$brands}} --}}
            <select name="brand_id" class="form-control" required="required">
                <option value="">Select</option>
              @foreach($brands as $brand)
                <option value="{{$brand->id}}">{{$brand->title}}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label for="category_id">Category <span class="text-danger">*</span></label>
            <select name="category_id" id="category_id" class="form-control" required="required">
                <option value="">Select</option>
                @foreach($categories as $key=>$cat_data)
                    <option value='{{$cat_data->id}}'>{{$cat_data->title}}</option>
                @endforeach
            </select>
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label for="sub_category_id">Sub Category</label>
            <select name="sub_category_id" id="sub_category_id" class="form-control">
                <option value="">Select</option>
            </select>
          </div>
        </div>

        <div class="col-md-6 mt-3">
          <div class="form-group">
            <label for="is_featured" class="btn btn-default w-100 text-left">
            <input type="checkbox" name='is_featured' id='is_featured' value='1'> Mark as Featured Product</label>
          </div>
        </div>

        <div class="col-md-6 mt-3">
          <div class="form-group">
            <label class="btn btn-default w-100 text-left">
              <input type="checkbox" name="product_description" class="btn btn-default product_description_checkbox"> Add Product description</label>
          </div>
        </div>

        <div class="col-md-12">
            <div class="form-group d-none product_description_element">
                  <div class="">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="description" class="col-form-label">Product description OR Product Specification</label>
                        <textarea class="form-control" id="description" name="description">{{old('description')}}</textarea>
                        @error('description')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                      </div>
                      </div>
                  <table class="table">
                  <tbody>
                    <tr>
                    <td class="append_desc" style="border:none;">
                    </td>
                      </tr>
                      </tbody>
                    </table>
                  </div>
              </div>
        </div>
       <!-- //***************** Start  Purchasing Price ***********************/ -->
        <div class="col-md-4">
        <div class="form-group">
          <label for="price">Purchasing Price <span class="text-danger">*</span></label>
          <input id="purchasingPrice" type="number" name="purchasing_price" placeholder="Enter Purchasing Price"  value="{{old('purchasing_price')}}" class="form-control" required="required">
          @error('purchasing_price')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        </div>
        <div class="col-md-4">
        <div class="form-group ">
          <label for="condition">Tax (If Any)</label>
          <select name="purchasing_tax" class="form-control" id="tax" >
              <option value="">Select</option>
              @foreach($taxs as $key=>$tax)
              <option value='{{$tax->tax}}'>{{$tax->tax}}%</option>
              @endforeach
          </select>
          @error('purchasing_tax')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        </div>
        <div class="col-md-4">
        <div class="form-group">
          <label for="price">Gross  <span class="text-danger">*</span></label>
          <input id="totalGross" type="number" name="purchasing_gross" readonly placeholder="Enter Gross"  value="{{old('purchasing_gross')}}" class="form-control" required="required">
          @error('price')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        </div>
         <!-- //***************** Start  Selling Price ***********************/ -->
        <div class="col-md-4">
        <div class="form-group">
          <label for="price">Selling Price  <span class="text-danger">*</span></label>
          <input  type="number" id="sellingprice" name="price" placeholder="Enter price"  value="{{old('price')}}" class="form-control" required="required">
          @error('price')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        </div> 
        <div class="col-md-4">
        <div class="form-group">
          <label for="condition">Include discount Percentage (If Any)</label>
          <select name="discount" class="form-control" id="tax1">
              <option value="">Select</option>
              @foreach($discounts as $key=>$discount)
              <option value="{{$discount->discount}}">{{$discount->discount}}%</option>
              @endforeach
          </select>
          @error('discount')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        </div>
        <div class="col-md-4">
        <div class="form-group">
          <label for="price">Gross <span class="text-danger">*</span></label>
          <input id="totalGross1" type="number" readonly name="selling_gross" placeholder="Enter Gross"  value="{{old('selling_gross')}}" class="form-control" required="required">
          @error('price')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        </div>
         <!-- //***************** End  Selling Price ***********************/ -->

        <div class="col-md-4">
        <div class="form-group">
          <label for="condition">Condition</label>
          <select name="condition" class="form-control" required="required">
              <option value="default">Default</option>
              <option value="new">New</option>
              <option value="hot">Hot</option>
          </select>
        </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="">Return </label>
            <input type="number" name="return" id="return" class="form-control" placeholder="Please enter return days after purchase">
          </div>
        </div>
        
        <div class="col-md-4">
          <div class="form-group">
            <label for="status">Status <span class="text-danger">*</span></label>
            <select name="status" class="form-control">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
            @error('status')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
        </div>
        
        <div class="col-md-4">
          <div class="form-group">
            <label for="stock">Quantity</label>
            <input id="quantity" type="number" name="stock[]" min="0" placeholder="Enter quantity"  value="{{old('stock')}}" class="form-control" required="required">
            @error('stock')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="colors">Colors</label>
            <select class="select2 form-control" id="colors" name="colors[]" data-placeholder="Search the colors">
              @foreach ($colors as $color)
                <option value="{{ $color->id }}">{{ $color->title }}</option>                
              @endforeach
            </select>
          </div>
        </div>


        <div class="col-md-4">
          <div class="form-group">
            <label for="sizes">Sizes</label>
            <select class="select2 form-control" id="sizes" name="sizes[]" data-placeholder="Search the sizes">
              @foreach ($sizes as $size)
                <option value="{{ $size->id }}"> {{ $size->title }}</option>                
              @endforeach
            </select>
          </div>
        </div>
      </div>
        <div class="row" id="AddMoreColorSizeQauntityWrapper"></div>
        <div class="row">
        <div class="col-md-12 mt-3">
          <div class="form-group">
            <button class="btn btn-info" type="button" onclick="AddMoreColorSizeQauntity()">Add More</button>
            &nbsp;
            <button class="btn btn-danger" type="button" onclick="RemoveColorSizeQauntity()">Remove</button>
          </div>
        </div>

        <div class="col-md-4">
          <div class="custom-file">
            <input accept="image/*" onchange="readURL(this);" class="custom-file-input form-control" type='file' name="photo" value="{{old('photo')}}" required="required" id="exampleInputFile">
            <label class="custom-file-label" for="exampleInputFile">Product thumbnail 550 X 750</label>
          </div>
          <div class="mb-1 mt-4 d-none show_images">
            <img id="show_images" width="200" height="180" src="{{asset('products/images/products/default.png')}}"/><br>
          </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
              <label for="add-product-images" class="btn btn-default w-100 text-left">
                <input type="checkbox" name='images_option' value='1' id="add-product-images" class="btn btn-default add-product-image-btn" /> Add Product Images
              </label>              
              <div class="sd-box sd-advanced-upload d-none drap-drop-wrapper">
                <div class="sd-box-wrapper">
                  <div class="sd-label-wrapper">
                    <span class="sd-box-dragndrop">Drop file here /&nbsp;</span>
                    <span class="sd-box-file-name"></span>
                    <label class="sd-label">Browse <span class="sd-box-browse-file">File</span></label>
                    <input type="file" name="images[]" id="example" multiple=""></div>
                </div>
              </div>
            </div>
        </div>

        <div class="col-md-12 mt-3">
          <div class="form-group">
            <button type="reset" class="btn btn-warning">Reset</button> &nbsp;
            <button class="btn btn-success" type="submit">Submit</button>
          </div>
        </div>
      </form>
    </div>
</div>
@endsection
@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
<link rel="stylesheet" href="{{asset('backend/css/simpledropit.min.css')}}">
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" /> --}}
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
{{-- https://www.jqueryscript.net/form/drag-drop-upload-zone.html --}}
<script src="{{asset('backend/js/simpledropit.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script>
var AddMoreColorSizeQauntityCounter = 0;
function RemoveColorSizeQauntity() {
  if(AddMoreColorSizeQauntityCounter == 0)
  return;

  $(`.stock${AddMoreColorSizeQauntityCounter}`).remove();
  $(`.color${AddMoreColorSizeQauntityCounter}`).remove();
  $(`.size${AddMoreColorSizeQauntityCounter}`).remove();
  AddMoreColorSizeQauntityCounter = AddMoreColorSizeQauntityCounter - 1;
}
function AddMoreColorSizeQauntity() {
  AddMoreColorSizeQauntityCounter = AddMoreColorSizeQauntityCounter + 1;
  var sizeOptions = $("#sizes").html();
  var colorOptions = $("#colors").html();
  var sizeSelect = `<div class="col-md-4 size${AddMoreColorSizeQauntityCounter}">
                      <div class="form-group">
                        <label for="size_${AddMoreColorSizeQauntityCounter}">Sizes</label>
                        <select class="select2 form-control" id="size_${AddMoreColorSizeQauntityCounter}" name="sizes[]" data-placeholder="Search the sizes">
                          ${sizeOptions}
                        </select>
                      </div>
                    </div>`;

  var qauntitySelect = `<div class="col-md-4 stock${AddMoreColorSizeQauntityCounter}">
                      <div class="form-group">
                        <label for="stock_${AddMoreColorSizeQauntityCounter}">Quantity</label>
                        <input id="stock_${AddMoreColorSizeQauntityCounter}" type="number" name="stock[]" min="0" placeholder="Enter quantity"  value="" class="form-control" required="required">
                      </div>
                    </div>`;

  var colorSelect = `<div class="col-md-4 color${AddMoreColorSizeQauntityCounter}">
                      <div class="form-group">
                        <label for="color_${AddMoreColorSizeQauntityCounter}">Colors</label>
                        <select class="select2 form-control" id="color_${AddMoreColorSizeQauntityCounter}" name="colors[]" data-placeholder="Search the colors">
                          ${colorOptions}
                        </select>
                      </div>
                    </div>`;
  $("#AddMoreColorSizeQauntityWrapper").append(qauntitySelect);
  $("#AddMoreColorSizeQauntityWrapper").append(colorSelect);
  $("#AddMoreColorSizeQauntityWrapper").append(sizeSelect);
}
    // $('#lfm').filemanager('image');
    $(document).ready(function() {
      $('.select2').select2();

      new SimpleDropit(document.getElementById('example'));
      $('#summary').summernote({
        placeholder: "Write short description.....",
          tabsize: 2,
          height: 100
      });
    });
    $(document).ready(function() {
      $('#description').summernote({
        placeholder: "Write detail description.....",
          tabsize: 2,
          height: 150
      });
    });
    ////////////////
 $('#tax').change(function(){
    calculate_gross();
  });

  $('#purchasingPrice').keyup(function(){
    calculate_gross();
  });
  
  function calculate_gross(){
    var tax = $('#tax option:selected').val();
    var purchasingPrice = $('#purchasingPrice').val();
    var totalgross = 0;
    if (tax != '') {
      var gross=(purchasingPrice*(tax/100));
      totalgross = parseInt(purchasingPrice)+ parseInt(gross) ;
    }
    else{
      totalgross = purchasingPrice || 0;
    }
    $('#totalGross').val(totalgross);
  }

  $('#tax1').change(function(){
    calculate();
  });

  $('#sellingprice').keyup(function(){
    calculate();
  });
  
  function calculate(){
    var tax = $('#tax1 option:selected').val();
    var sellingprice = $('#sellingprice').val();
    var totalGross1 = 0;
    if (tax != '') {
      var gross=(sellingprice*(tax/100));
      totalGross1 = parseInt(sellingprice)- parseInt(gross) ;
    }
    else{
      totalGross1 = sellingprice || 0;
    }
    $('#totalGross1').val(totalGross1);
  }
      //File manager
    // $('#lfm').filemanager('image');

    // $('select').selectpicker();
</script>
<script>

$('#category_id').change(function(){
  console.log($(this).val(), "$(this).val()");
    var category_id = $(this).val();
    if(category_id == '') return;
    var url = "{{ route('get.sub.categories.by.category.id',  ':id')}}";
      url = url.replace(':id', category_id);
      $.ajax({
        url: url,
        data:{
          _token:"{{csrf_token()}}",
          id : category_id
        },
        type:"POST",
        success: function(response) {
          var html_option = "<option value=''>Select sub category</option>";
            if(response.length > 0){
              $.each(response, function(id, obj){
                html_option +="<option value='"+obj.id+"'>"+ obj.title+"</option>"
              });
            }
            else{
              var html_option = "<option value=''>No sub sub category found.</option>";
            }
            $('#sub_category_id').html(html_option);
        },
        error: function(response) {
           console.log("sub categories: ", response);
        },
      });
  });
    function readURL(input) {
          if (input.files && input.files[0]) {
              var reader = new FileReader();
              reader.onload = function (e) {
                  $('#display_image')
                      .attr('src', e.target.result);
              };
              reader.readAsDataURL(input.files[0]);
          }
      }

        $('.add-product-image-btn').change(function(){
          if($(this).prop('checked')){
            $(this).parents('.row').find('.drap-drop-wrapper').removeClass('d-none');
          }else{
            $(this).parents('.row').find('.drap-drop-wrapper').addClass('d-none');
          }
        });

        $('.product_description_checkbox').change(function(){
          if($(this).prop('checked')){
            $(this).parents('.row').find('.product_description_element').removeClass('d-none');
          }else{
            $(this).parents('.row').find('.product_description_element').addClass('d-none');
          }
        });
    function max_upload($element){
        if($element.files[0].size > 1572864){
          alert("File is too big ! Upload file less than 1.5 MB file");
          $element.value = "";
        }else{
          return "1";
        }
    }
    var _URL = window.URL || window.webkitURL;
    $("#photo").change(function(e) {
        if(max_upload(this)=='1'){
            var file, img;
            var output = document.getElementById('display_product_image');
            if ((file = this.files[0])) {
                img = new Image();
                img.onload = function() {
                    if(this.width!=this.height){
                        alert("You must upload a square photo like 200x200 or 400x400");
						            $("#photo").val('');
                    }else{
                        output.src = _URL.createObjectURL(file);
                    }
                };
                img.onerror = function() {
                    alert("Uploaded file not a valid photo !");
                    $("#photo").val('');
                };
                img.src = _URL.createObjectURL(file);
            }
        }
    });
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $(".btn-add-more").click(function(){ 
        var html = $(".clone").html();
        $(".img_div").after(html);
    });
    $("body").on("click",".btn-remove",function(){ 
        $(this).parents(".control-group").remove();
    });
  });

  function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#show_images').parent().removeClass('d-none');
                    $('#show_images').attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
  }
</script>

@endpush


