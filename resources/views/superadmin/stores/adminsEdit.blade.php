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
                  <td>Status</td>
                  <td>{{ $user->status }}</td>
              </tr>

            </tbody>
          </table>
        </div>
      </div>
</div>
@php $store = $user->store; @endphp
<div class="card shadow m-3">
  <div class="card-header bg-primary text-white">
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
            <td>Profile</td>
            @if($store->image != "")
              <td> <img width="200" height="100" src="{{ asset('/images/stores/'.$store->image) }}" alt="{{$store->image}}"></td>
            @endif
          </tr>

          <tr>
              <td>Status</td>
              <td>{{ $user->status }}</td>
          </tr>


          {{-- @if($user->company_reg_no != "")
          <tr>
            <td>Company Registration Number</td>
            <td>{{$user->company_reg_no}}</td>
          </tr>
          @endif
          @if($user->tax_dep_nu != "")
          <tr>
            <td>Tax Department Number</td>
            <td>{{$user->tax_dep_nu}}</td>
          </tr>
          @endif
          @if($user->company_reg_cerf)
          <tr>
            <td>Company Registration Certificate</td>
            <td> <img @if($user->company_reg_cerf) class="img-fluid zoom" style="max-width:300px"  width="100" height="100"   src="{{ asset('products/images/users/'.$user->company_reg_cerf)}}"  alt="{{$user->company_reg_cerf}}" @endif></td>
          </tr>
          @endif
          @if($user->tax_dep_cerf)
          <tr>
            <td>Tax Department Certificate</td> 
            <td> <img  @if($user->tax_dep_cerf) class="img-fluid zoom" style="max-width:300px"  width="100" height="100" src="{{ asset('products/images/users/'.$user->tax_dep_cerf) }}?text=Image cap" alt="{{$user->tax_dep_cerf}}" @endif></td>
          </tr>
          @endif
          @if($user->other_reg_docu)
          <tr>
            <td>Other Registration Documents</td>
            <td> <img @if($user->other_reg_docu) class="img-fluid zoom" style="max-width:300px"  width="100" height="100" src="{{ asset('products/images/users/'.$user->other_reg_docu) }}?text=Image cap" alt="{{$user->other_reg_docu}}" @endif></td>
          </tr>
          <tr>
            @endif
            <td>Short Description</td>
            <td>{{$user->short_description}}</td>
          </tr>
          <tr>
            <td>Products description & specification</td>
            <td>{!! $user->long_description !!}</td>
          </tr>
          <tr>
            <td>Business Document</td>
            @if($user->image != "")
            <td> <img width="200" height="100" src="{{ asset('products/images/users/'.$user->image) }}?text=Image cap" alt="{{$user->image}}"></td>
            @endif
          </tr> --}}
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection          
@push('styles')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
@endpush

@push('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
@endpush