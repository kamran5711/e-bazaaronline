@extends('backend.layouts.master')

@section('main-content')
 
  <div class="card shadow m-3">
    <div class="card-header bg-primary text-white rounded-0">
      <h6 class="m-0 font-weight-bold float-left">Expired Store Membership</h6>
    </div>
    <div class="card-body">
      @if($expired_member_ships->count() > 0)
        <div class="table-responsive">
          <table class="table table-bordered" >
              <tbody>
                <tr>
                  <th>#</th>
                  <th>Store Name</th>
                  <th>Web</th>
                  <th>App</th>
                  <th>Shop</th>
                  <th>Setup</th>
                  <th>Software</th>
                  <th>Invoice Terms</th>
                  <th>Expired at</th>
                  <th>Status</th>
                  <th class="text-center">Action</th>
                </tr>
                @php $counter = 1; @endphp
                @foreach ($expired_member_ships as $ems)
                  <tr>
                    <td>{{ $counter++ }}</td>
                    <td>{{ $ems->store->name }}</td>
                    <td>{{ $ems->web_charges }}</td>
                    <td>{{ $ems->app_charges }}</td>
                    <td>{{ $ems->shop_charges }}</td>
                    <td>{{ $ems->setup_charges }}</td>
                    <td>{{ $ems->software_charges }}</td>
                    @switch($ems->invoice_terms)
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
                    <td>{{ $ems->expiry_date }}</td>
                    <td class="{{ ($ems->status == 'active') ? 'text-success' : 'text-danger' }}">{{ $ems->status }}</td>
                    <td class="text-center">
                      @php $invoiceRecord = $ems->store_invoices->first(); @endphp
                      <a class="btn btn-info btn-sm rounded-circle"  data-toggle="tooltip" title="View Invoices" data-placement="bottom" href="javascript:void(0)" onclick="ShowInvoiceList({{ json_encode($invoiceRecord) }})"><i class="fas fa-eye"></i></a>
                      <a class="btn btn-primary btn-sm rounded-circle" data-toggle="tooltip" title="Edit Membership" data-placement="bottom" href="{{ route('membership-edit',[$ems->id]) }}"><i class="fas fa-edit"></i></a>
                      <a class="btn btn-info btn-sm rounded-circle"  data-toggle="tooltip" title="Generate Invoice" data-placement="bottom" href="javascript:void(0)" onclick="showInvoiceModal({{ json_encode($ems) }})"><i class="fas fa-directions"></i></a>
                      {{-- <form method="POST" action="{{route('color.destroy',[$ems->id])}}">
                        @csrf 
                        @method('delete')
                            <button class="btn btn-danger btn-sm dltBtn" data-id={{$ems->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                      </form> --}}
                    </td>
                  </tr>
                @endforeach
              </tbody>
          </table>
        </div>
      @else
        <h5 class="text-info text-center">There are no memberships yet.</h5>
      @endif
    </div>
  </div>

<!-- Modal -->
<div class="modal fade" id="invoiceModal" tabindex="-1" role="dialog" aria-labelledby="invoiceModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="invoiceModalLabel">Generate Invoice | Extend Membership</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form enctype="multipart/form-data" action="{{route('invoice-create')}}" method="post" id="membership_extension_form">
            @csrf
            <input type="hidden" name="store_id" value="" id="store_id" />
            <div class="mb-3">
                <label for="payment" class="col-form-label">Payment</label>
                <input type="number" value="" name="payment" class="form-control" id="payment" >
            </div>
            <div class="mb-3">
              <label for="start_date" class="col-form-label">Start From</label>
              <input type="date" value="" name="start_date" class="form-control" id="start_date" >
            </div>
            <div class="mb-3">
              <label for="expiry_date" class="col-form-label">Expiry Date</label>
              <input type="date" value="" name="expiry_date" class="form-control" id="expiry_date" >
            </div>
            <div class="mb-2">
              <label for="invoice_type" class="col-form-label">Invoice Type</label>
              <select class="custom-select" name="invoice_type" id="invoice_type">
                <option value="0">Free</option>
                <option value="1" selected>Paid</option>
              </select>
            </div>
            <div class="mb-2">
              <label for="status" class="col-form-label">Status</label>
              <select class="custom-select" name="status" id="status">
                <option value="0">Pending to store</option>
                <option value="1">Pending to admin</option>
                <option value="2" selected>Approved by admin</option>
              </select>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="reset" class="btn btn-danger btn-sm" data-dismiss="modal" form="membership_extension_form">Close</button>
        <button type="submit" class="btn btn-primary btn-sm" form="membership_extension_form">Proceed</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="lastInvoice" tabindex="-1" role="dialog" aria-labelledby="lastInvoiceLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="lastInvoiceLabel">Last Paid Invoice</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="invoicesBody">
        lastInvoice
      </div>
      <div class="modal-footer">
        <button class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>

function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
}

  function showInvoiceModal(obj) {
    var currentDate = new Date();
    var nextMonth = new Date(currentDate.setMonth(currentDate.getMonth() + 1));
    var firstDay = new Date(nextMonth.getFullYear(), nextMonth.getMonth(), 1);
    var lastDay = new Date(currentDate.setMonth(currentDate.getMonth() + parseInt(obj.invoice_terms), 0));
    var total_payment = parseInt(obj.web_charges) + parseInt(obj.app_charges) + parseInt(obj.shop_charges);
      
      $("#start_date").val(formatDate(firstDay));
      $("#expiry_date").val(formatDate(lastDay));
      $("#payment").val(total_payment);
      $("#store_id").val(obj.store_id);
      $("#member_ship_id").val(obj.id);
      $("#invoiceModal").modal('show');
  }

  function ShowInvoiceList(obj) {
    var created_at = new Date(obj.created_at);
    let day = created_at.getDate();// 23
    let month = created_at.getMonth(); //month + 1
    let year = created_at.getFullYear();// 2022
    if (day < 10) {
        day = '0' + day;
    }
    if (month < 10) {
        month = `0${month}`;
    }
    let dateFormatted = `${year}-${month}-${day}`;

    var img_url = "{{ asset('images/store_invoices/') }}/";
    var dataToAppend = ``;
    if(obj.attachment != null)
      dataToAppend += `<img src='${img_url + obj.attachment}' class='img img-responsive' style='height: 180px' />`;
    if(obj.short_notes != '')
      dataToAppend += `<p class='mt-3'>Short Notes: ${obj.short_notes}</p>`;
    dataToAppend += `
        <div class="table-responsive">
          <table class="table table-bordered" >
            <tbody>
              <tr>
                <th>Payment</th>
                <td>${obj.payment}</td>
              </tr>
              <tr>
                <th>Type</th>`;
                if(obj.invoice_type == 0){
                    dataToAppend += `<td>Free</td>`;
                }else{
                  dataToAppend += `<td>Paid</td>`;
                }
                dataToAppend += `<tr><th>Status</th>`;
                switch (obj.status) {
                  case 0:
                    dataToAppend += `<td>Pending <sup class='text-info'><small>(store)</small></sup></td>`;
                    break;
                  case 1:
                    dataToAppend += `<td>Pending <sup class='text-info'><small>(admin)</small></sup></td>`;
                    break;                
                  default:
                    dataToAppend += `<td>Approved <sup class='text-success'><small>(admin)</small></sup></td>`;
                    break;
                }

              dataToAppend += `</tr>
              <tr>
                <th>Start Date</th>
                <td>${obj.start_date}</td>
              </tr>
              <tr>
                <th>Expiry Date</th>
                <td>${obj.expiry_date}</td>
              </tr>
            </tbody>
          </table>
        </div>`;
        $("#invoicesBody").html(dataToAppend);
        $("#lastInvoice").modal('show');
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
  </script>
@endpush