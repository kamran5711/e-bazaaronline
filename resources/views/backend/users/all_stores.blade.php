@extends('backend.layouts.master')

@section('main-content')
 <!-- DataTales Example -->
  <div class="card shadow m-3">
    <div class="card-header py-3 bg-primary text-white">
      <h6 class="m-0 font-weight-bold float-left">All Stores/Businesses</h6>
      {{-- <a href="{{route('users.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Add Customer"><i class="fas fa-plus"></i> Add Customer</a> --}}
    </div>
    <div class="card-body">
      <div class="row">
          <div class="col-md-12">
            @include('backend.layouts.notification')
          </div>
      </div>
      @if($stores->count() > 0)
        <div class="table-responsive">
          <table class="table table-bordered table-sm table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>Name </th>
                <th>Email</th>
                <th>Phone#</th>
                <th>Type</th>
                <th>Status</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              @php
              $counter = 1;
              @endphp
              @foreach($stores as $store)
                @php
                    $modules = json_decode($store->modules, true);
                    // dd($modules);
                @endphp
                    <tr> 
                      <td >{{ $counter++ }}</td>
                      <td>{{$store->name}}</td>
                      <td>{{$store->email}}</td>
                      <td>{{$store->phone}}</td>
                      <td>{{$store->type->name}}</td>
                      <td>
                        @switch($store->status)
                            @case(1)
                              <span class="text-success">Active</span>
                                @break
                            @case(2)
                              <span class="text-danger">In-active</span>
                                @break
                            @default
                              <span class="text-warning">Pending</span>
                        @endswitch
    
                      </td>
                      <td class="text-center">
                        <a class="btn btn-info btn-sm rounded-circle" data-toggle="tooltip" title="View user detail" data-placement="bottom" href="{{url('superadmin/users/'. optional($store->user)->id)}}"><i class="fas fa-eye"></i></a>
                        <a class="btn btn-info btn-sm rounded-circle" data-toggle="tooltip" title="Membership detail" data-placement="bottom" href="{{route('store-payments',$store->id)}}"><i class="fas fa-coins"></i></a>
                        @if($store->status == 1 )
                          <a class="btn btn-warning btn-sm rounded-circle" data-toggle="tooltip" title="Disable Store" data-placement="bottom" href="{{route('store-disable', $store->id)}}"><i class="fas fa-ban"></i></a> <!-- fa-user-lock -->
                        @else
                          <a class="btn btn-success btn-sm rounded-circle" data-toggle="tooltip" title="Enable Store" data-placement="bottom" href="{{route('store-enable', $store->id)}}"><i class="fas fa-unlock"></i></a>
                        @endif
                        <form method="POST" action="{{route('delete-store',[$store->id])}}" class="d-inline">
                          @csrf 
                          @method('delete')
                          <button class="btn btn-danger btn-sm dltBtn" data-id="{{$store->id}}" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                        </form>
                        
                        {{-- <div class="dropdown">
                          <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">Open
                            <span class="caret"></span>
                          </button>
                          <div class="dropdown-menu">
                            <a href="{{url('superadmin/users/'.$store->user->id)}}" class="text-info dropdown-item">view</a>
                            <a href="{{route('store.payments',$store->id)}}" class="text-primary dropdown-item">payment</a>
                            <a href="{{route('store.payments',$store->id)}}" class="text-warning dropdown-item">disable</a>
                            <a href="{{route('store.payments',$store->id)}}" class="text-danger dropdown-item">delete</a>
                          </div>
                        </div> --}}
                      </td>
                    </tr> 
                @endforeach
            </tbody>
          </table>
          <span style="float:right">{{$stores->links()}}</span>
      </div>
      @else
          <h5 class="text-center text-info">No stores found</h5>
      @endif
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
