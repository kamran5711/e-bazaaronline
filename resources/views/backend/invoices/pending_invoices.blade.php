@extends('backend.layouts.master')

@section('main-content')
 
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
                  <th>Status</th>
                  <th>Created At</th>
                  <th>Expired At</th>
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
                      <span class="text-info">Pending</span>
                    </td>
                    <td>{{ date('Y-m-d' , strtotime($invoice->created_at)) }}</td>
                    <td>{{ $invoice->expiry_date }}</td>
                    <td class="text-center">
                      <a class="btn btn-info btn-sm rounded-circle"  data-toggle="tooltip" title="View Membership Details" data-placement="bottom" href="javascript:void(0)" onclick="ShowMemberShipInfo({{ json_encode($invoice) }})"><i class="fas fa-eye"></i></a>
                      <a href="{{route('invoice-edit',[$invoice->id])}}" class="btn btn-primary btn-sm rounded-circle" data-toggle="tooltip" title="Edit Invoice" data-placement="bottom"><i class="fas fa-edit"></i></a>
                      <form method="POST" action="{{route('invoice-destroy',[$invoice->id])}}" class="d-inline-block">
                        @csrf 
                        @method('delete')
                            <button class="btn btn-danger btn-sm dltBtn" data-id={{$invoice->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete Invoice"><i class="fas fa-trash-alt"></i></button>
                      </form>
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
<div class="modal fade" id="membershipModal" tabindex="-1" role="dialog" aria-labelledby="membershipLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="membershipLabel">Invoice Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="membershipModalBody">
        membership
      </div>
      <div class="modal-footer">
        <button class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
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

  function ShowMemberShipInfo(invoice) {
    var img_url = "{{ asset('images/store_invoices/') }}/";
    var membership = invoice.membership;
    var dataToAppend = ``;
    if(invoice.attachment != null)
      dataToAppend += `<img src='${img_url + invoice.attachment}' class='img img-responsive' style='height: 180px' />`;
    if(invoice.short_notes != '')
      dataToAppend += `<p class='mt-3'>Short Notes: ${invoice.short_notes}</p>`;
    dataToAppend += `
        <div class="table-responsive">
          <table class="table table-bordered table-sm">
            <tbody>
              <tr class='text-center'><td colspan='2'>Membership Plan Details </td></tr>
              <tr>
                <td>Web Charges</td>
                <td>${membership.web_charges}</td>
              </tr>

              <tr>
                <td>App Charges</td>
                <td>${membership.app_charges}</td>
              </tr>

              <tr>
                <td>Shop Charges</td>
                <td>${membership.shop_charges}</td>
              </tr>

              <tr>
                <td>Setup Charges</td>
                <td>${membership.setup_charges}</td>
              </tr>

              <tr>
                <td>Software Charges</td>
                <td>${membership.software_charges}</td>
              </tr>`;

              var invoice_terms;
              switch (membership.invoice_terms) {
                case 1:
                  invoice_terms = 'Monthly';
                  break;
                case 3:
                  invoice_terms = 'Quarterly';
                  break;
                case 6:
                  invoice_terms = 'Half Year';
                  break;
                default:
                  invoice_terms = 'Yearly';
                  break;
              }
              dataToAppend += `
              <tr>
                <td>Invoice Terms</td>
                <td>${invoice_terms}</td>
              </tr>

              <tr>
                <td>Free Trail</td>
                <td>${membership.free_trail} times</td>
              </tr>

              <tr>
                <td>Status</td>
                <td>${membership.status}</td>
              </tr>

              <tr>
                <td>Expiry Date</td>
                <td>${membership.expiry_date}</td>
              </tr>
            </tbody>
          </table>
        </div>`;
        $("#membershipModalBody").html(dataToAppend);
        $("#membershipModal").modal('show');
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
