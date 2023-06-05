@extends('backend.layouts.master')
@section('title','E-SHOP || Payment Page')
@section('main-content')
<!-- DataTales Example -->
<div class="card shadow m-3">
    <div class="row">
        <div class="col-md-12">
            @include('backend.layouts.notification')
        </div>
    </div>
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary float-left">Payment List</h6>
        <a href="{{route('payments.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip"
            data-placement="bottom" title="Add Payment"><i class="fas fa-plus"></i> Add Payments</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            @if(count($payments)>0)
            <table class="table table-bordered" id="banner-dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>S.N.</th>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Details</th>  
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                    <tr>
                        <td>{{$payment->id}}</td>
                        <td>{{$payment->title}}</td>
                        <td>{{$payment->slug}}</td>
                        <td>{!! $payment->details !!}</td>
                        <td>
                            @if($payment->status=='active')
                            <span class="badge badge-success">{{$payment->status}}</span>
                            @else
                            <span class="badge badge-warning">{{$payment->status}}</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{route('payments.edit',[$payment->id])}}"
                                class="btn btn-primary btn-sm float-left mr-1"
                                style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit"
                                data-placement="bottom"><i class="fas fa-edit"></i></a>
                            <form method="POST" action="{{route('payment.destroy',[$payment->id])}}">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger btn-sm dltBtn" data-id={{$payment->id}}
                                    style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                    data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </td>
                        {{-- Delete Modal --}}
                        {{-- <div class="modal fade" id="delModal{{$user->id}}" tabindex="-1" role="dialog"
                        aria-labelledby="#delModal{{$user->id}}Label" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="#delModal{{$user->id}}Label">Delete user</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="{{route('payment.destroy',[$payment->id])}}">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger"
                                            style="margin:auto; text-align:center">Parmanent delete Payments
                                            Method</button>
                                    </form>
                                </div>
                            </div>
                        </div>
        </div> --}}
        </tr>
        @endforeach
        </tbody>
        </table>
        <span style="float:right">{{$payments->links()}}</span>
        @else
        <h6 class="text-center">No payment methods are added yet, Please add some payment methods.</h6>
        @endif
    </div>
</div>
</div>
@endsection

@push('styles')
<link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<style>
div.dataTables_wrapper div.dataTables_paginate {
    display: none;
}

.zoom {
    transition: transform .2s;
    /* Animation */
}

.zoom:hover {
    transform: scale(3.2);
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
$('#banner-dataTable').DataTable({
    "columnDefs": [{
        "orderable": false,
        "targets": [3, 4]
    }]
});

// Sweet alert

function deleteData(id) {

}
</script>
<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.dltBtn').click(function(e) {
        var form = $(this).closest('form');
        var dataID = $(this).data('id');
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