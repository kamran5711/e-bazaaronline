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
      <h6 class="m-0 font-weight-bold text-primary float-left">Discount List</h6>
      <a href="{{route('discounts.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Add Discount</a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        @if(count($discounts)>0)
        <table class="table table-bordered" id="banner-dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>#</th>
              <th>Discount</th>
              <th>Status</th>
              <th style="width: 20%">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($discounts as $discount)   
                <tr>
                    <td>{{$discount->id}}</td>
                    <td>{{$discount->discount}}%</td>
                    <td>
                        @if($discount->status=='active')
                            <span class="badge badge-success">{{$discount->status}}</span>
                        @else
                            <span class="badge badge-warning">{{$discount->status}}</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{route('discounts.edit',$discount->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                        <form method="POST" action="{{route('discounts.destroy',[$discount->id])}}">
                            @csrf 
                            @method('delete')
                                <button class="btn btn-danger btn-sm dltBtn" onclick="return confirm('Are you sure?')" data-id={{$discount->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                          </form>
                    </td>
                </tr>  
            @endforeach
          </tbody>
        </table>
        <span style="float:right">{{$discounts->links()}}</span>
        @else
          <h6 class="text-center">No Discount found!!! Please create Discount</h6>
        @endif
      </div>
    </div>
</div>
@endsection

