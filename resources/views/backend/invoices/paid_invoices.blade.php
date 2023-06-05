@extends('backend.layouts.master')

@section('main-content')
 
  <div class="card shadow m-3">
    <div class="card-header bg-primary text-white rounded-0">
      <h6 class="m-0 font-weight-bold float-left">Store Membership</h6>
    </div>
    <div class="card-body">
      @if($member_ships)
        <div class="table-responsive">
          <table class="table table-bordered" >
              <tbody>
                <tr>
                  <th>#</th>
                  <th>Store Name</th>
                  <th>Membership charge</th>
                  <th>Setup charge</th>
                  <th>Software charge</th>
                  <th>Expired at</th>
                  <th>Status</th>
                  <th class="text-center">Action</th>
                </tr>
                @php $counter = 1; @endphp
                @foreach ($member_ships as $ems)
                  <tr>
                    <td>{{ $counter++ }}</td>
                    <td>{{ $ems->store->name }}</td>
                    <td>{{ $ems->membership_charge }}</td>
                    <td>{{ $ems->setup_charge }}</td>
                    <td>{{ $ems->software_charge }}</td>
                    <td>{{ $ems->expiry_date }}</td>
                    <td class="{{ ($ems->status == 'active') ? 'text-success' : 'text-danger' }}">{{ $ems->status }}</td>
                    <td class="text-center">
                      @php $invoiceRecords = $ems->store_invoices()->latest()->get(); @endphp
                      <a class="btn btn-info btn-sm rounded-circle"  data-toggle="tooltip" title="Generate Invoice" data-placement="bottom" href="javascript:void(0)" onclick="showInvoiceModal({{ json_encode($ems) }})"><i class="fas fa-directions"></i></a>
                      <a class="btn btn-info btn-sm rounded-circle"  data-toggle="tooltip" title="View Invoices" data-placement="bottom" href="javascript:void(0)" onclick="ShowInvoiceList({{ json_encode($invoiceRecords) }})"><i class="fas fa-eye"></i></a>
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
        <form enctype="multipart/form-data" action="{{route('store_extend_membership')}}" method="post" id="membership_extension_form">
            @csrf
            <input type="hidden" name="store_id" value="" id="store_id" />
            <input type="hidden" name="member_ship_id" value="" id="member_ship_id" />
            <div class="mb-3">
                <label for="payment" class="col-form-label">Paid Amount</label>
                <input type="number" value="" name="payment" class="form-control" id="payment" >
            </div>
            <div class="mb-3">
              <label for="start_from" class="col-form-label">Start From</label>
              <input type="date" value="<?php echo date('Y-m-d'); ?>" name="start_date" class="form-control" id="start_from" >
            </div>
            <div class="mb-2">
                <label for="month" class="col-form-label">Extend Membership For</label>
                <select class="custom-select" name="expiry_date" id="month">
                  <option value="1">1 Month</option>
                  <option value="3">3 Months</option>
                  <option value="6">6 Months</option>
                </select>
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

<!-- Modal -->
<div class="modal fade" id="lastInvoice" tabindex="-1" role="dialog" aria-labelledby="lastInvoiceLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="lastInvoiceLabel">Paid Invoices</h5>
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
  function showInvoiceModal(obj) {
      $("#store_id").val(obj.store_id);
      $("#member_ship_id").val(obj.id);
      $("#invoiceModal").modal('show');
  }

  function ShowInvoiceList(invoiceList) {
    var dataToAppend = `
        <div class="table-responsive">
          <table class="table table-bordered" >
            <tbody>
              <tr>
                <th>#</th>
                <th>Payment</th>
                <th>Month<small>(s)</small></th>
                <th>Start Date</th>
                <th>Expiry Date</th>
                <th>Dated</th>
              </tr>`;
    var counter = 1;
        invoiceList.forEach(obj => {
          var created_at = new Date(obj.created_at);
          var day = created_at.getDate();// 23
          var month = created_at.getMonth(); //month + 1
          var year = created_at.getFullYear();// 2022
          if (day < 10) {
              day = '0' + day;
          }
          if (month < 10) {
              month = `0${month}`;
          }
          var dateFormatted = `${year}-${month}-${day}`;
          dataToAppend += `
              <tr>
                <td>${counter++}</td>
                <td>${obj.payment}</td>
                `;
                if(obj.payment != 0){
                    dataToAppend += `<td>${obj.months} Month</td>`;
                }else{
                    dataToAppend += `<td>Free Trail</td>`;
                }
              dataToAppend +=`
                <td>${obj.start_date}</td>
                <td>${obj.expiry_date}</td>
                <td>${dateFormatted}</td>
              </tr>`;
        });
        dataToAppend += `
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