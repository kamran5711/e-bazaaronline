@extends('backend.layouts.master')

@section('main-content')
 <div class="card shadow m-3">
     <div class="row">
         <div class="col-md-12">
            @include('backend.layouts.notification')
         </div>
     </div>
    <div class="card-header bg-primary text-white">
      <h6 class="m-0 font-weight-bold float-left">User Information</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" >
          <tbody>
              <tr>
                <th>Name</th>
                <th>{{ $user->name }}</th>
              </tr>
              <tr>
                <td>Role</td>
                <td>{{ $user->user_role->display_name }}</td>
              </tr>
              <tr>
                <td>Email</td>
                <td>{{ $user->email }}</td>
              </tr>
              <tr>
                <td>Contact #</td>
                <td>{{ $user->phone }}</td>
              </tr>
              <tr>
                <td>Address Line 1</td>
                <td>@if($user->address) {{ $user->address->address1 }} @endif</td>
              </tr>
              <tr>
                <td>Address Line 2</td>
                <td>{{ (optional($user->address)->address2) ? $user->address->address2 : "Nill" }}</td>
              </tr>

              <tr>
                <td>Area</td>
                <td>@if($user->address) {{ $user->address->city->name }}, {{ $user->address->state->name }}, {{ $user->address->country->name }}. @else {{"User should update his area."}} @endif</td>
              </tr>

              <tr>
                <td>Profile</td>
                @if($user->photo != "")
                  <td> <img width="200" height="100" src="{{ asset('/images/profile/'.$user->photo) }}" alt="{{$user->photo}}"></td>
                @endif
              </tr>

              <tr>
                  <td><strong>Status</strong></td>
                  <td>{{ $user->status }}</td>
              </tr>

            </tbody>
          </table>
        </div>
      </div>
</div>
@php $store = $user->store; @endphp
@if($store)
<div class="card shadow m-3">
  <div class="card-header bg-primary text-white rounded-0">
    <h6 class="m-0 font-weight-bold float-left">Store Information</h6>
  </div>
  <div class="card-body">
  <div class="table-responsive">
    <table class="table table-bordered" >
        <tbody>
          <tr>
            <th>Name</th>
            <th>{{ $store->name }}</th>
          </tr>
          <tr>
            <td>Category</td>
            <td>{{ $store->type->name }}</td>
          </tr>
          <tr>
            <td>Email</td>
            <td>{{ $store->email }}</td>
          </tr>
          <tr>
            <td>Contact #</td>
            <td>{{ $store->phone }}</td>
          </tr>
          <tr>
            <td>Address Line 1</td>
            <td>@if($store->address) {{ $store->address->address1 }} @endif</td>
          </tr>
          <tr>
            <td>Address Line 2</td>
            <td>{{ (optional($store->address)->address2) ? $store->address->address2 : "Nill" }}</td>
          </tr>

          <tr>
            <td>Area</td>
            <td>@if($store->address) {{ $store->address->city->name }}, {{ $store->address->state->name }}, {{ $store->address->country->name }}. @else {{"Store should update his area."}} @endif</td>
          </tr>

          <tr>
            <td>Short Summary</td>
            <td>{{ $store->short_description }}</td>
          </tr>
          <tr>

        <tr>
            <td>Detail Description</td>
            <td>
                {!!html_entity_decode($store->long_description)!!}
            </td>
        </tr>
        
            @if($store->tax_department_number)
                <tr>
                    <td>Tax department number</td>
                    <td>{{ $store->tax_department_number }}</td>
                </tr>
            @endif

            @if($store->registration_number)
                <tr>
                    <td>Registration number</td>
                    <td>{{ $store->registration_number }}</td>
                </tr>
            @endif

            @if($store->bussiness_type)
                <tr>
                    <td>Bussiness type</td>
                    <td>{{ $store->bussiness_type }}</td>
                </tr>
            @endif

            @if($store->registration_certificate)
                <tr>
                    <td>Registration certificate</td>
                    <td> <img width="200" height="100" src="{{ asset('/images/stores/'.$store->registration_certificate) }}" alt="{{$store->registration_certificate}}"></td>
                </tr>
            @endif

            @if($store->other_registeration_ducoment)
                <tr>
                    <td>Other registeration ducoment</td>
                    <td> <img width="200" height="100" src="{{ asset('/images/stores/'.$store->other_registeration_ducoment) }}" alt="{{$store->other_registeration_ducoment}}"></td>
                </tr>
            @endif


          <tr>
            <td>Profile</td>
            @if($store->image != "")
              <td> <img width="200" height="100" src="{{ asset('/images/stores/'.$store->image) }}" alt="{{$store->image}}"></td>
            @endif
          </tr>

            <tr>
                <td><strong>Status</strong></td>
                @switch($store->status)
                    @case(1)
                        <td class="text-success">Active</td>
                    @break
                    @case(2)
                        <td class="text-danger">Inactive</td>
                    @break
                    @default
                        <td class="text-info">Pending</td>
                @endswitch
            </tr>
        </tbody>
    </table>
    </div>
  </div>
</div>
    @if($store->membership)
    <div class="card shadow m-3">
        <div class="card-header bg-primary text-white rounded-0">
          <h6 class="m-0 font-weight-bold float-left">Store Membership Information</h6>
        </div>
        <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" >
              <tbody>
                <tr>
                  <td>Web charge</td>
                  <td>{{ $store->membership->web_charges }}</td>
              </tr>
              <tr>
                  <td>App charge</td>
                  <td>{{ $store->membership->app_charges }}</td>
              </tr>
              <tr>
                  <td>Shop charge</td>
                  <td>{{ $store->membership->shop_charges }}</td>
              </tr>
              <tr>
                  <td>Setup charge</td>
                  <td>{{ $store->membership->setup_charges }}</td>
              </tr>
              <tr>
                  <td>Software charge</td>
                  <td>{{ $store->membership->software_charges }}</td>
              </tr>
              <tr>
                  <td>Invoice Terms</td>
                  @switch($store->membership->invoice_terms)
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
                  <td>{{ $store->membership->free_trail }} times</td>
              </tr>
              <tr>
                  <td>Status</td>
                  @if($store->membership->status == 'active')
                      <td class="text-success">{{ $store->membership->status }}</td>
                  @else
                      <td class="text-danger">{{ $store->membership->status }}</td>
                  @endif
              </tr>
              <tr>
                  <td>Expiry date</td>
                  <td>{{ $store->membership->expiry_date }}</td>
              </tr>
              </tbody>
          </table>
          </div>
        </div>
      </div>
    @endif
@endif
@endsection          
@push('styles')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
@endpush

@push('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
@endpush