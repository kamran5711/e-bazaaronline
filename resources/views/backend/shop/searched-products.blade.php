<div class="table-responsive">
    @if( count($products) > 0)
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
          {{-- <th>Photo</th> --}}
          <th width="120">Categorized In</th>
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
                {{-- <td>
                    <img  src="{{ asset('images/products/'.$product->photo) }}"
                    class="img-fluid zoom" style="max-width:80px" >
                </td> --}}
                <td>
                    {{ ($product->category) ? $product->category->title : '' }} {{ ($product->sub_category) ? ', ' . $product->sub_category : '' }}
                </td>
                <td class="text-center">
                  <a href="javascript:void(0)" class="btn btn-info btn-sm mr-1 rounded-circle p-2" data-toggle="tooltip" onclick="showProductDetails({{ json_encode($product) }})" title="View" data-placement="bottom"><i class="fas fa-eye"></i></a>
                  <a href="javascript:void(0)" class="btn btn-success btn-sm mr-1 rounded-circle p-2" data-toggle="tooltip" onclick="addToCartModal({{ json_encode($product) }})" title="Add to cart" data-placement="bottom"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a>
                  {{-- <a href="{{route('product.edit',$product->id)}}" class="btn btn-primary btn-sm float-left" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                    <form method="POST" action="{{route('product.destroy',[$product->id])}}">
                      @csrf 
                      @method('delete')
                      <button class="btn btn-danger btn-sm dltBtn" data-id="{{$product->id}}" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                    </form> --}}
                </td>
            </tr>  
        @endforeach
      </tbody>
    </table>
    @else
      <h6 class="text-center text-danger">Unable to find the productds with spacified criteria.</h6>
    @endif
  </div>