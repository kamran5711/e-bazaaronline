@extends('backend.layouts.master')
@section('title','E-SHOP || Color Page')
@section('main-content')
 <!-- DataTales Example -->
 <div class="card shadow m-3">
     <div class="row">
         <div class="col-md-12">
            @include('backend.layouts.notification')
         </div>
     </div>
    <div class="card-header py-3">
      <h5 class="m-0 font-weight-bold text-primary float-left">Colors List</h5>
      <a href="{{route('color.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Add Color</a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        @if(count($colors)>0)
        <table class="table table-bordered table-sm">
          <thead>
            <tr>
              <th width="50">S.N.</th>
              <th>Title</th>
              <th>Hex Code</th>
              <th>Color</th>
              <th class="text-center" width=100>Status</th>
              <th class="text-center" width=100>Action</th>
            </tr>
          </thead>
          <tbody>
            @php
            $counter = Request::get('page');
            if(empty($counter))
            $counter = 1;
            if($counter >= 2){
              $counter = $counter * 15;
              if($counter == 2)
              $counter = 16;
            }
            @endphp
            @foreach($colors as $color)   
                <tr>
                    <td>{{ $counter++ }}</td>
                    <td>{{$color->title}}</td>
                    <td>{{$color->hex}}</td> 
                    <td>
                      <div class="p-2" style="background: {{ $color->hex }}; width:100%; min-width:200px; height:25px"></div>
                    </td>
                    <td class="text-center">
                        @if($color->status=='active')
                            <span class="badge badge-success">{{$color->status}}</span>
                        @else
                            <span class="badge badge-warning">{{$color->status}}</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="{{route('color.edit',$color->id)}}" class="btn btn-primary btn-sm float-left" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                        <form method="POST" action="{{route('color.destroy',[$color->id])}}">
                          @csrf 
                          @method('delete')
                              <button class="btn btn-danger btn-sm dltBtn" data-id={{$color->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </td>
                </tr>  
            @endforeach
          </tbody>
        </table>
        <span style="float:right">{{$colors->links()}}</span>
        @else
          <h6 class="text-center">No colors are added yet, please add some.</h6>
        @endif
      </div>
    </div>
</div>
@endsection

@push('styles')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
@endpush

@push('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>


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