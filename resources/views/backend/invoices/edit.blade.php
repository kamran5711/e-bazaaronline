@extends('backend.layouts.master')

@section('main-content')
 
  <div class="card shadow m-3">
    <div class="card-header bg-primary text-white rounded-0">
      <h6 class="m-0 font-weight-bold float-left">Invoice edit</h6>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-12">
          @include('backend.layouts.notification')
        </div>
      </div>
      <form method="post" action="{{route('invoice-update', $invoice->id)}}" enctype="multipart/form-data">
        @csrf
            @method('PATCH')
            <input type="hidden" name="store_id" value="{{ $invoice->store_id }}" id="store_id" />
            <div class="mb-3">
                <label for="payment" class="col-form-label">Paid Amount</label>
                <input type="number" value="{{ $invoice->payment }}" name="payment" class="form-control" id="payment" />
                @error('payment')
                  <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="mb-2">
              <label for="invoice_type" class="col-form-label">Invoice Type</label>
              <select class="custom-select" name="invoice_type" id="invoice_type">
                <option value="0" {{ ($invoice->invoice_type == 0 ) ? 'selected' : ''  }}>Free</option>
                <option value="1" {{ ($invoice->invoice_type == 1 ) ? 'selected' : ''  }}>Paid</option>
              </select>
            </div>

            <div class="mb-2">
              <label for="status" class="col-form-label">Status</label>
              <select class="custom-select" name="status" id="status">
                <option value="0">Pending to store</option>
                <option value="1">Pending</option>
                <option value="2" selected>Approve</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="start_from" class="col-form-label">Start From</label>
              <input type="date" value="<?php echo date('Y-m-d', strtotime($invoice->start_date)); ?>" name="start_date" class="form-control" id="start_from" />
              @error('start_date')
                <span class="text-danger">{{$message}}</span>
              @enderror
            </div>
            <div class="mb-3">
              <label for="expiry_date" class="col-form-label">Expiry Date</label>
              <input type="date" value="<?php echo date('Y-m-d', strtotime($invoice->expiry_date)); ?>" name="expiry_date" class="form-control" id="expiry_date" />
              @error('expiry_date')
                <span class="text-danger">{{$message}}</span>
              @enderror
            </div>

            {{-- <div class="mb-2 mt-4">
              <img style="max-height:200px" class="img img-responsive" src="{{ asset('images/store_invoices') . '/' . $invoice->attachment  }}" />
              <input type="hidden" name="old_attachment" value="{{ $invoice->attachment }}" />
            </div>
            <div class="mt-4 mb-2">Add Attachment</div>
            <div class="custom-file mb-4 mt-0">
              <input type="file" class="custom-file-input" id="customFile" name="attachment">
              <label class="custom-file-label" for="customFile">Choose file</label>
            </div> --}}
        <div class="form-group mb-3">
          <a type="button" href="{{ route('all-invoices') }}" class="btn btn-info btn-sm">Back</a>
           <button class="btn btn-primary btn-sm" type="submit">Update</button>
        </div>
      </form>
    </div>
</div>

@endsection
