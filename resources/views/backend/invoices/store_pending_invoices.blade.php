@extends('backend.layouts.master')

@section('main-content')
 
  @if($current_membership)
  <div class="card shadow m-3">
      <div class="card-header bg-primary text-white rounded-0">
        <h6 class="m-0 font-weight-bold float-left" data-toggle="collapse" role="button" data-target="#membership_plan_collapse" aria-expanded="true" aria-controls="membership_plan_collapse">Membership Plan</h6>
      </div>
      <div id="membership_plan_collapse" class="collapse show" data-parent="#accordion">
          <div class="card-body">
          <div class="table-responsive">
          <table class="table table-bordered" >
              <tbody>
                <tr>
                  <td>Web charge</td>
                  <td>{{ $current_membership->web_charges }}</td>
              </tr>
              <tr>
                  <td>App charge</td>
                  <td>{{ $current_membership->app_charges }}</td>
              </tr>
              <tr>
                  <td>Shop charge</td>
                  <td>{{ $current_membership->shop_charges }}</td>
              </tr>
              <tr>
                  <td>Setup charge</td>
                  <td>{{ $current_membership->setup_charges }}</td>
              </tr>
              <tr>
                  <td>Software charge</td>
                  <td>{{ $current_membership->software_charges }}</td>
              </tr>
              <tr>
                  <td>Invoice Terms</td>
                  @switch($current_membership->invoice_terms)
                      @case(1)
                          <td>Monthly</td>
                          @break
                      @case(3)
                          <td>Quarterly</td>
                          @break
                      @case(6)
                          <td>Half Yearly</td>
                          @break
                      @default
                          <td>Yearly</td>     
                  @endswitch
              </tr>
              <tr>
                  <td>Free Trail</td>
                  <td>{{ $current_membership->free_trail }} times</td>
              </tr>
              <tr>
                  <td>Free Trail</td>
                  @if($current_membership->status == 'active')
                      <td class="text-success">{{ $current_membership->status }}</td>
                  @else
                      <td class="text-danger">{{ $current_membership->status }}</td>
                  @endif
              </tr>
              <tr>
                  <td>Expiry date</td>
                  <td>{{ $current_membership->expiry_date }}</td>
              </tr>
              </tbody>
          </table>
          </div>
          </div>
      </div>
    </div>
  @endif
  <div class="card shadow m-3">
    <div class="card-header bg-primary text-white rounded-0">
      <h6 class="m-0 font-weight-bold float-left">Pending Invoices</h6>
    </div>
    <div class="card-body">
      <div class="row">
          <div class="col-md-12">
            @include('backend.layouts.notification')
          </div>
      </div>
      @if($invoices)
        <div class="table-responsive">
          <table class="table table-bordered" >
              @if($invoices->count() > 0)
              <tbody>
                <tr>
                  <th>#</th>
                  <th>Store Name</th>
                  <th>Type</th>
                  <th>Payment</th>
                  <th>Attachment if any</th>
                  <th>Status</th>
                  <th>Expired At</th>
                  <th>Created At</th>
                  <th class="text-center">Action</th>
                </tr>
                @php $counter = 1; @endphp
                @foreach ($invoices as $invoice)
                  <tr>
                    <td>{{ $counter++ }}</td>
                    <td>{{ $invoice->store->name }}</td>
                    <td>{{ ($invoice->invoice_type == 0) ? 'Free Trail' : 'Paid' }}</td>
                    <td>{{ $invoice->payment }}</td>
                    <td>
                      @if(!gettype($invoice->attachment))
                        <img width="100" height="250" class="card-img-top" src="{{ asset('images/invoices') . '/' . $invoice->attachment  }}" alt="invoice attachment">
                      @endif
                    </td>
                    <td>
                      <span class="text-info">Pending</span>
                    </td>
                    <td>{{ date('Y-m-d' , strtotime($invoice->created_at)) }}</td>
                    <td>{{ $invoice->expiry_date }}</td>
                    <td class="text-center">
                      <a class="btn btn-info btn-sm rounded-circle"  data-toggle="tooltip" title="Submit Invoice" data-placement="bottom" href="javascript:void(0)" onclick="showInvoiceModal({{ json_encode($invoice) }})"><i class="fas fa-directions"></i></a>
                    </td>
                  </tr>
                @endforeach
                @else
                  <h5 class="text-info text-center">There is no invoice generated yet.</h5>
                @endif
              </tbody>
          </table>
        </div>
      @endif
    </div>
  </div>

<!-- Modal -->
<div class="modal fade" id="invoiceModal" tabindex="-1" role="dialog" aria-labelledby="invoiceModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="invoiceModalLabel">Pending Invoice</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form enctype="multipart/form-data" action="{{route('store_extend_membership')}}" method="post" id="membership_extension_form">
            @csrf
            <input type="hidden" name="store_id" value="" id="store_id" />
            <input type="hidden" name="member_ship_id" value="" id="member_ship_id" />
            <input type="hidden" name="status" value="1" />
            <div class="mb-2">
              <div class="form-group">
                <label for="short_notes">Short Notes</label>
                <textarea class="form-control" rows="3" id="short_notes" name="short_notes"></textarea>
              </div>
            </div>
            <div class="mt-4 mb-2">Add Attachment</div>
            <div class="custom-file mb-4 mt-0">
              <input type="file" class="custom-file-input" id="customFile" name="attachment">
              <label class="custom-file-label" for="customFile">Choose file</label>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-sm" form="membership_extension_form">Proceed</button>
        <button type="reset" class="btn btn-danger btn-sm" data-dismiss="modal" form="membership_extension_form">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
  function showInvoiceModal(obj) {
      $("#store_id").val(obj.store_id);
      $("#member_ship_id").val(obj.id);
      $("#invoiceModal").modal('show');
  }
</script>

@endsection          
@push('styles')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
@endpush

@push('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
  <script>
  // Add the following code if you want the name of the file appear on select
    $(".custom-file-input").on("change", function() {
      var fileName = $(this).val().split("\\").pop();
      $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });


    function func(e, form_id) {
      var form = $(this).closest('form');
      var dataID = $(this).data('id');
      //here I want to prevent default
      e = e || window.event;
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
              $(`#form__${form_id}`).submit()
            } else {
                swal("Your data is safe!");
            }
      });
    }
  </script>
@endpush
