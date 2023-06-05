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
      <h6 class="m-0 font-weight-bold text-primary float-left">Size List</h6>
      <a href="{{route('size.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Add Size</a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        @if(count($sizes)>0)
        <table class="table table-bordered table-sm">
          <thead>
            <tr>
              <th width="60" class="text-center">#</th>
              <th>Title</th>
              <th width="80" class="text-center">Status</th>
              <th width="100" class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($sizes as $size)   
                <tr>
                    <td class="text-center">{{$size->id}}</td>
                    <td>{{$size->title}}</td>
                    <td class="text-center">
                        @if($size->status=='active')
                            <span class="badge badge-success">{{$size->status}}</span>
                        @else
                            <span class="badge badge-warning">{{$size->status}}</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="{{route('size.edit',$size->id)}}" class="btn btn-primary btn-sm float-left ml-2" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                        <form method="POST" action="{{route('size.destroy',[$size->id])}}">
                            @csrf 
                            @method('delete')
                                <button class="btn btn-danger btn-sm dltBtn" onclick="return confirm('Are you sure?')" data-id={{$size->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                          </form>
                    </td>
                </tr>  
            @endforeach
          </tbody>
        </table>
        {{-- <span style="float:right">{{$sizes->links()}}</span> --}}
        @else
          <h6 class="text-center">No sizes added yet! Please create some sizes</h6>
        @endif
      </div>
    </div>
</div>
@endsection

