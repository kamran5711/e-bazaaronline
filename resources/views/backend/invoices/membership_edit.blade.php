@extends('backend.layouts.master')

@section('main-content')
 
  <div class="card shadow m-3">
    <div class="card-header bg-primary text-white rounded-0">
      <h6 class="m-0 font-weight-bold float-left">Store Membership edit</h6>
    </div>
    <div class="card-body">
      <form method="post" action="{{route('membership-update', $membership->id)}}" enctype="multipart/form-data">
        @csrf
            @method('PATCH')
            <input type="hidden" name="store_id" value="{{ $membership->store_id }}" id="store_id" />
            <div class="mb-3">
                <label for="web_charges" class="col-form-label">Web Charges</label>
                <input type="number" value="{{ $membership->web_charges }}" name="web_charges" class="form-control" id="web_charges" />
                @error('web_charges')
                  <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            <div class="mb-3">
              <label for="app_charges" class="col-form-label">App Charges</label>
              <input type="number" value="{{ $membership->app_charges }}" name="app_charges" class="form-control" id="app_charges" />
              @error('app_charges')
                <span class="text-danger">{{$message}}</span>
              @enderror
            </div>

            <div class="mb-3">
              <label for="shop_charges" class="col-form-label">Shop Charges</label>
              <input type="number" value="{{ $membership->shop_charges }}" name="shop_charges" class="form-control" id="shop_charges" />
              @error('shop_charges')
                <span class="text-danger">{{$message}}</span>
              @enderror
            </div>

            <div class="mb-3">
              <label for="setup_charges" class="col-form-label">Setup Charges</label>
              <input type="number" value="{{ $membership->setup_charges }}" name="setup_charges" class="form-control" id="setup_charges" />
              @error('setup_charges')
                <span class="text-danger">{{$message}}</span>
              @enderror
            </div>

            <div class="mb-3">
              <label for="software_charges" class="col-form-label">Software Charges</label>
              <input type="number" value="{{ $membership->software_charges }}" name="software_charges" class="form-control" id="software_charges" />
              @error('software_charges')
                <span class="text-danger">{{$message}}</span>
              @enderror
            </div>
            {{-- expiry_date --}}
            {{-- <div class="mb-3">
              <label for="start_from" class="col-form-label">Start From</label>
              <input type="date" value="<?php echo date('Y-m-d', strtotime($invoice->start_date)); ?>" name="start_date" class="form-control" id="start_from" />
              @error('start_date')
                <span class="text-danger">{{$message}}</span>
              @enderror
            </div> --}}

            <div class="mb-2">
              <label for="status" class="col-form-label">Status</label>
              <select class="custom-select" name="status" id="status">
                <option value="1" {{ ($membership->status == 'active' ) ? 'selected' : ''  }}>Active</option>
                <option value="3" {{ ($membership->status == 'inactive' ) ? 'selected' : ''  }}>Inactive</option>
              </select>
            </div>
            <div class="mb-2">
                <label for="month" class="col-form-label">Invoice Terms</label>
                <select class="custom-select" name="invoice_terms" id="month">
                  <option value="1" {{ ($membership->invoice_terms == 1 ) ? 'selected' : ''  }}>Monthly</option>
                  <option value="3" {{ ($membership->invoice_terms == 3 ) ? 'selected' : ''  }}>Quarterly</option>
                  <option value="6" {{ ($membership->invoice_terms == 6 ) ? 'selected' : ''  }}>Half Yearly</option>
                  <option value="12" {{ ($membership->invoice_terms == 12 ) ? 'selected' : ''  }}>Yearly</option>
                </select>
            </div>
        <div class="form-group mb-3 mt-3">
          <a type="button" href="{{ route('all-memberships') }}" class="btn btn-info btn-sm">Back</a>
           <button class="btn btn-primary btn-sm" type="submit">Update</button>
        </div>
      </form>
    </div>
</div>

@endsection
