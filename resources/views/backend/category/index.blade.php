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
        <h6 class="m-0 font-weight-bold text-primary float-left">Categories Lists</h6>
        <a href="{{route('category.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip"
            data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Add Category</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            @if(count($categories)>0)
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th width="25">S.N</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Sub Categories</th>
                        <th width="100">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    @php
                    $parent_cats=DB::table('categories')->select('title')->where('id',$category->parent_id)->get();
                    // dd($parent_cats);
                    @endphp
                    <tr>
                        <td>{{$category->id}}</td>
                        <td>{{$category->title}}</td>
                       <td style="width:50px;">
                            @if($category->status=='active')
                            <span class="badge badge-success">{{$category->status}}</span>
                            @else
                            <span class="badge badge-warning">{{$category->status}}</span>
                            @endif
                        </td>
                        <td style="width:140px;">
                            <a href="{{route('category.sub',$category->id)}}"
                               class="btn btn-primary btn-sm float-left mr-1"
                               data-toggle="tooltip" style="height:30px; width:120px;" title="Sub categories"
                               data-placement="bottom">View</a>
                        </td>
                        <td style="width:60px;">
                            <a href="{{route('category.edit',$category->id)}}"
                                class="btn btn-primary btn-sm float-left mr-1"
                                style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit"
                                data-placement="bottom"><i class="fas fa-edit"></i></a>
                            <form method="POST" action="{{route('category.destroy',[$category->id])}}">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger btn-sm dltBtn"
                                    style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                    data-placement="bottom" title="Delete" data-id={{$category->id}}><i class="fas fa-trash-alt"></i></button>
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
                                    <form method="post" action="{{ route('categorys.destroy',$user->id) }}">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger"
                                            style="margin:auto; text-align:center">Parmanent delete user</button>
                                    </form>
                                </div>
                            </div>
                        </div>
        </div> --}}
        </tr>
        @endforeach
        </tbody>
        </table>
        <span style="float:right">{{$categories->links()}}</span>
        @else
        <h6 class="text-center">No Categories are added yet, please add some.</h6>
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
        "targets": [3, 4, 5]
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
