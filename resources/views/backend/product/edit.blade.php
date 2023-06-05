@extends('backend.layouts.master')
@section('main-content')
<style>
img {
    background: white;
}
input[type=file] {
    padding: 4px;
    background: white;
}
.hidden {
    display: none;
}
.btn-default {
    border: 1px solid;
}
</style>
<div class="row">
    <div class="col-md-12">
       @include('backend.layouts.notification')
    </div>
</div>
<div class="card m-3">

    <h5 class="card-header">Edit Product</h5>
    <div class="card-body">
        <form method="post" action="{{route('product.update',$product->id)}}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="inputTitle">Title <span class="text-danger">*</span></label>
                        <input id="inputTitle" type="text" name="title" placeholder="Enter title"
                            value="{{$product->title}}" class="form-control">
                        @error('title')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="brand_id">Brand</label>
                        <select name="brand_id" class="form-control">
                            <option value="">Select</option>
                            @foreach($brands as $brand)
                            <option value="{{$brand->id}}" {{(($product->brand_id == $brand->id)? 'selected':'')}}>
                                {{$brand->title}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                {{-- {{$categories}} --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="category_id">Category <span class="text-danger">*</span></label>
                        <select name="category_id" id="category_id" class="form-control">
                            <option value="">Select</option>
                            @foreach($categories as $key => $cat_data)
                            <option value='{{$cat_data->id}}' {{(($product->category_id == $cat_data->id)? 'selected' : '')}}>
                                {{$cat_data->title}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                      <label for="sub_category_id">Sub Category <span class="text-danger">*</span></label>
                      <select name="sub_category_id" id="sub_category_id" class="form-control">
                            <option value="">Select</option>
                            @foreach ($sub_categories as $sc)
                                <option value="{{$sc->id}}" {{(($product->sub_category_id == $sc->id) ? 'selected' : '')}}>{{ $sc->title }}</option>
                            @endforeach
                      </select>
                    </div>
                </div>

                <div class="col-md-6 mt-3">
                    <div class="form-group">
                      <label for="is_featured" class="btn btn-default w-100 text-left">
                      <input type="checkbox" name='is_featured' id='is_featured' value='1' {{  ($product->is_featured == 1 ? ' checked' : '') }}> Mark as Featured Product</label>
                    </div>
                </div>

                <div class="col-md-6 mt-3">
                    <div class="form-group">
                      <label class="btn btn-default w-100 text-left">
                        <input type="checkbox" class="btn btn-default product_description_checkbox" name="product_description" {{  ($product->description != '' ? ' checked' : '') }}> Add Product description</label>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group {{  ($product->description != '' ? '' : 'd-none') }} product_description_element">
                        <div class="form-group">
                            <label for="description" class="col-form-label">Product description OR Product Specification</label>
                            <textarea class="form-control" id="description" name="description"> {!! $product->description !!} </textarea>
                            @error('description')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                      </div>
                </div>
            </div>

            <div class="row">
 
                <div class="col-md-4">
                    <div class="form-group">
                      <label for="price">Purchasing Price <span class="text-danger">*</span></label>
                      <input id="purchasingPrice" type="number" name="purchasing_price" placeholder="Enter Purchasing Price" value="{{$product->purchasing_price}}" class="form-control" required="required">
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
                          @foreach($taxs as $key => $tax)
                          <option value='{{ $tax->tax }}' {{(($product->purchasing_tax == $tax->tax)? 'selected':'')}}>{{ $tax->tax }}%</option>
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
                      <input id="totalGross" type="number" name="purchasing_gross" readonly placeholder="Enter Gross"  value="{{$product->purchasing_gross}}" class="form-control" required="required">
                      @error('price')
                      <span class="text-danger">{{$message}}</span>
                      @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="price" class="col-form-label">Selling Price  <span class="text-danger">*</span></label>
                        <input  type="number" id="sellingprice" value="{{$product->price}}" name="price" placeholder="Enter price"  value="{{old('price')}}" class="form-control" required="required">
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
                          <option value="{{$discount->discount}}" {{( ($product->discount == $discount->discount) ? 'selected':'')}}>{{$discount->discount}}%</option>
                          @endforeach
                      </select>
                      @error('discount')
                      <span class="text-danger">{{$message}}</span>
                      @enderror
                    </div>
                </div>

                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="price" class="col-form-label">Gross <span class="text-danger">*</span></label>
                        <input id="totalGross1" type="number" value="{{$product->selling_gross}}" readonly name="selling_gross" placeholder="Enter Gross"  value="{{old('selling_gross')}}" class="form-control" required="required">
                        @error('price')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="condition">Condition</label>
                        <select name="condition" class="form-control">
                            <option value="">Select</option>
                            <option value="default" {{(($product->condition=='default')? 'selected':'')}}>Default
                            </option>
                            <option value="new" {{(($product->condition=='new')? 'selected':'')}}>New</option>
                            <option value="hot" {{(($product->condition=='hot')? 'selected':'')}}>Hot</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                      <label for="">Return </label>
                      <input type="number" name="return" id="return" class="form-control" value="{{$product->return_policy}}" placeholder="Please enter return days after purchase">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control">
                            <option value="active" {{(($product->status=='active')? 'selected' : '')}}>Active</option>
                            <option value="inactive" {{(($product->status=='inactive')? 'selected' : '')}}>Inactive
                            </option>
                        </select>
                        @error('status')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row" id="AddMoreColorSizeQauntityWrapper">
                @php
                $size_options = '';
                foreach ($sizes as $size) {
                    $size_options .= "<option value='" . $size->id . "'>". $size->title ."</option>";
                }
                $color_options = '';
                foreach ($colors as $color){
                    $color_options .= "<option value='" . $color->id . "'>". $color->title. "</option>";

                }
                @endphp
                @foreach ($product->productStock as $key => $ps)
                <div class="col-md-4 stock-{{$key + 1}}">
                    <input type="hidden" name="productStockIds[]" value="{{$ps->id}}">
                        <div class="form-group">
                            <label for="stock-{{$key}}">Quantity <span class="text-danger">*</span></label>
                            <input id="stock-{{$key}}" type="number" name="stock[]" min="0" placeholder="Enter quantity"
                                value="{{$ps->stock}}" class="form-control">
                            @error('stock')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4 color-{{$key + 1}}">
                        <div class="form-group">
                            <label for="colors-{{$key}}">Colors</label>
                            <select class="multiple-select2 form-control" id="colors-{{$key}}" name="colors[]" data-placeholder="Search the colors">
                                @php echo $color_options; @endphp
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-4 size-{{$key +1}}">
                        <div class="form-group">
                        <label for="sizes-{{$key}}">Sizes</label>
                        <select class="multiple-select2 form-control" id="sizes-{{$key}}" name="sizes[]" data-placeholder="Search the sizes">
                            @php echo $size_options; @endphp              
                        </select>
                        </div>
                    </div>

                    @push('scripts')
                    <script>
                        $('#colors-{{$key}}').val(@json($ps->color_id));
                        $('#sizes-{{$key}}').val(@json($ps->size_id));
                    </script>
                    @endpush  
                @endforeach
            </div>
            <div class="col-md-12 mt-3">
              <div class="form-group">
                <button class="btn btn-info btn-sm" type="button" onclick="AddMoreColorSizeQauntity()">Add More</button>
                &nbsp;
                <button class="btn btn-danger btn-sm" type="button" onclick="RemoveColorSizeQauntity()">Remove</button>
              </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="custom-file">
                      <input accept="image/*" onchange="readURL(this);" class="custom-file-input form-control" type='file' name="photo" value="{{old('photo')}}" id="exampleInputFile">
                      <label class="custom-file-label" for="exampleInputFile">Product thumbnail 550 X 750</label>
                    </div>
                    <div class="mb-1 mt-3 mb-3 show_images">
                      <img id="show_images" class="w-100 h-100" src="{{asset('images/products/'. $product->photo)}}"/><br>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                    <label for="add-product-images" class="btn btn-default w-100 text-left">
                        <input type="checkbox" name='images_option' value='1' id="add-product-images" class="btn btn-default add-product-image-btn" {{  ($product->images->count() > 0 ? ' checked' : '') }} /> Add Product Images
                    </label>              
                    <div class="sd-box sd-advanced-upload {{  ($product->images->count() > 0 ? '' : 'd-none') }}  drap-drop-wrapper">
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
                @if( $product->images->count() > 0 )
                <hr class="bg-invert w-100" />
                    @foreach($product->images as $img)
                        <div class="col-md-4">
                            <div class="mb-1 mt-3 mb-3 show_images">
                                <img id="show_images" class="w-100 h-100" src="{{asset('images/products/'. $img->image)}}"/>
                                <div class="text-center mt-3"> <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick='remove_product_image(this,{{$img->id}});'>Remove</a></div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div> 

            <div class="row">
                <div class="col-1">
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">Update</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<link rel="stylesheet" href="{{asset('backend/css/simpledropit.min.css')}}">
@endpush
@push('scripts')
<link href="https://transloadit.edgly.net/releases/uppy/v1.6.0/uppy.min.css" rel="stylesheet">
 
<script src="https://transloadit.edgly.net/releases/uppy/v1.6.0/uppy.min.js"></script>
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script src="{{asset('backend/js/simpledropit.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<script>
    var AddMoreColorSizeQauntityCounter = <?php echo json_encode($product->productStock->count()); ?>;
    var size_options = color_options = '<option>Select</option>';
    size_options += <?php echo json_encode($size_options); ?>;
    color_options += <?php echo json_encode($color_options); ?>;
    function RemoveColorSizeQauntity() {

        if(AddMoreColorSizeQauntityCounter == 1)
        return;
        $(`.stock-${AddMoreColorSizeQauntityCounter}`).remove();
        $(`.color-${AddMoreColorSizeQauntityCounter}`).remove();
        $(`.size-${AddMoreColorSizeQauntityCounter}`).remove();
        AddMoreColorSizeQauntityCounter = AddMoreColorSizeQauntityCounter - 1;
    }
    function AddMoreColorSizeQauntity() {
        AddMoreColorSizeQauntityCounter = AddMoreColorSizeQauntityCounter + 1;
        var sizeOptions = $("#sizes").html();
        var colorOptions = $("#colors").html();
        var sizeSelect = `<div class="col-md-4 size-${AddMoreColorSizeQauntityCounter}">
                            <div class="form-group">
                                <label for="size_${AddMoreColorSizeQauntityCounter}">Sizes</label>
                                <select class="select2 form-control" id="size_${AddMoreColorSizeQauntityCounter}" name="sizes[]" data-placeholder="Search the sizes">
                                    ${size_options}
                                </select>
                            </div>
                            </div>`;

        var qauntitySelect = `<div class="col-md-4 stock-${AddMoreColorSizeQauntityCounter}">
                            <div class="form-group">
                                <label for="stock_${AddMoreColorSizeQauntityCounter}">Quantity</label>
                                <input id="stock_${AddMoreColorSizeQauntityCounter}" type="number" name="stock[]" min="0" placeholder="Enter quantity"  value="" class="form-control" required="required">
                            </div>
                            </div>`;

        var colorSelect = `<div class="col-md-4 color-${AddMoreColorSizeQauntityCounter}">
                            <div class="form-group">
                                <label for="color_${AddMoreColorSizeQauntityCounter}">Colors</label>
                                <select class="select2 form-control" id="color_${AddMoreColorSizeQauntityCounter}" name="colors[]" data-placeholder="Search the colors">
                                ${color_options}
                                </select>
                            </div>
                            </div>`;
        $("#AddMoreColorSizeQauntityWrapper").append(qauntitySelect);
        $("#AddMoreColorSizeQauntityWrapper").append(colorSelect);
        $("#AddMoreColorSizeQauntityWrapper").append(sizeSelect);
    }

    function remove_product_image(element, image_id) {
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this data!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url:"{{route('remove_product_image')}}",
                    method: 'post',
                    dataType: 'json',
                    data: {
                        image_id: image_id,
                        action: "remove_product_image",
                        _token: "{{csrf_token()}}"
                    },
                    success: function(data) {
                        if (data['status'] == "success") {
                            $(element).parents('.col-md-4').remove();
                        }
                    },
                    error: function(data) {
                        alert("Error code : " + data.status + " , Error message : " + data.statusText);
                    }
                });                    
            } else {
                swal("Your data is safe!");
            }
        });
    }

    $('.add-product-image-btn').change(function(){
        if($(this).prop('checked')){
        $(this).parents('.row').find('.drap-drop-wrapper').removeClass('d-none');
        }else{
        $(this).parents('.row').find('.drap-drop-wrapper').addClass('d-none');
        }
    });

    $('.product_description_checkbox').change(function(){
        // console.log("this ...");
        if( $(this).prop('checked') ){
        $('.product_description_element').removeClass('d-none');
        }else{
        $('.product_description_element').addClass('d-none');
        }
    });
    /// delete image
    $('body').on('click','.delete-image',function(){
        var id = $(this).data('id');
        $(this).parent().remove();

        $.ajax({
            url: "{{url('admin/product/delete-image')}}/"+id,
            type: "get",
            success: function(response) {
                if(response.status == 'success'){
                    $(this).parent().remove();
                }
            }
        });
    });
    // create a jquery function which previews the images before upload
    $(document).ready(function(){
        new SimpleDropit(document.getElementById('example'));
        $('.multiple-select2').select2();
        $('#summary').summernote({
            placeholder: "Write short description.....",
            tabsize: 2,
            height: 150
        });
        $('#description').summernote({
            placeholder: "Write detail Description.....",
            tabsize: 2,
            height: 150
        });
    });
    ///////////////////////
    $('#tax1').change(function(){
        var sellingprice=$('#sellingprice').val();
        // var tax=$('#tax1').text();
        var tax=parseInt($("#tax1 option:selected").text());
        //var gross=(tax/purchasingPrice) * 100;
        var gross=(sellingprice*(tax/100));
        var totalgross=sellingprice-gross;
        $('#totalGross1').val(totalgross);
    });
    //File manager
    $('#lfm').filemanager('image');

$('#category_id').change(function(){
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
                var html_option = "<option value=''>Select</option>";
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
                $('#show_images').parent().removeClass('d-none');
                $('#show_images').attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

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
        return // temporyly disable this function
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
@endpush