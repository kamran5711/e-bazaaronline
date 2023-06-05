@extends('backend.layouts.master')
@section('main-content')
  <div class="card shadow m-3">
    <div class="card-header bg-primary text-white rounded-0">
      <h6 class="m-0 font-weight-bold float-left">Pending Store/Bussiness</h6>
    </div>
    <div class="card-body">
      @if (count($stores) > 0)
      <div class="table-responsive">
        <table class="table table-bordered table-sm table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>Name </th>
              <th>Email</th>
              <th>Phone#</th>
              <th>Type</th>
              <th>Status</th>
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>

            @php
            $counter = 1;
            @endphp
            @foreach($stores as $store)
                <tr> 
                  <td >{{ $counter++ }}</td>
                  <td>{{$store->name}}</td>
                  <td>{{$store->email}}</td>
                  <td>{{$store->phone}}</td>
                  <td>{{ $store->type->name }}</td>
                  <td>
                    <span class="text-warning">Pending</span>
                  </td>
                  <td class="text-center">
                    <a class="btn btn-info btn-sm rounded-circle" data-toggle="tooltip" title="View user detail" data-placement="bottom" href="{{url('superadmin/users/'.$store->user->id)}}"><i class="fas fa-eye"></i></a>
                    <a class="btn btn-info btn-sm rounded-circle" data-toggle="tooltip" title="Membership detail" data-placement="bottom" href="{{route('store-payments',$store->id)}}"><i class="fas fa-coins"></i></a>
                    <a class="btn btn-success btn-sm rounded-circle" data-toggle="modal" data-target="#myModal{{$store->id}}" href="return false;"><i class="far fa-handshake"></i></i></a>
                  </td>
                </tr> 
                
                <div class="container">
                  <div class="modal fade" id="myModal{{$store->id}}" role="dialog">
                      <div class="modal-dialog modal-lg">
                      <!-- Modal content-->
                          <div class="modal-content">
                              <div class="modal-header bg-primary text-white">
                                  <h5 class="modal-title">{{ $store->name }}</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span class="text-white" aria-hidden="true">&times;</span>
                                  </button>
                              </div>
                              <div class="modal-body">
                                  <form action="{{route('user.enable',['id' => $store->id])}}" method="post">
                                      @csrf
                                      <input type="hidden" name="store_id" value="{{$store->id}}">
                                      <div class="row">
                                        <div class="col">
                                          <label for="recipient-name" class="col-form-label">Select Status</label>
                                          <select class="custom-select" name="is_active">
                                              <option value="1" {{ ($store->status) == '1' ?  'selected' : null }}>Active</option>
                                              <option value="0" {{ ($store->status) == '0' ? 'selected' : null }}>Pending</option>
                                              <option value="2" {{ ($store->status) == '2' ? 'selected' : null }}>Inactive</option>
                                          </select>
                                        </div>
                                        <div class="col">
                                          <div class="mb-2 mt-3">
                                            <div>Modules:</div>
                                            <div class="form-check form-check-inline">
                                              <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" name="web" value="1" disabled checked>
                                              Web</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                              <label class="form-check-label">  
                                                <input class="form-check-input" type="checkbox" name="app" value="1" onclick="$('#app_charges_wrapper').toggle();$('#app_charges').val('');get_total();">
                                              App</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                              <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" name="shop" value="1" onclick="$('#shop_charges_wrapper').toggle();$('#shop_charges').val('');get_total();">
                                              Shop</label>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="mb-3">
                                          <label for="web_charges" class="col-form-label">Web Charges</label>
                                          <input type="number" value="" name="web_charges" class="form-control" id="web_charges" onkeyup="get_total()">
                                      </div>
                                      <div class="mb-3" id="app_charges_wrapper" style="display: none;">
                                        <label for="app_charges" class="col-form-label">App Charges</label>
                                        <input type="number" value="" name="app_charges" class="form-control" id="app_charges" onkeyup="get_total()">
                                      </div>
                                      <div class="mb-3" id="shop_charges_wrapper" style="display: none;">
                                        <label for="shop_charges" class="col-form-label">Shop Charges</label>
                                        <input type="number" value="" name="shop_charges" class="form-control" id="shop_charges" onkeyup="get_total()">
                                      </div>
                                      <div class="row">
                                        <div class="col">
                                          <div class="mb-3">
                                              <label for="setup_charges" class="col-form-label">Setup Charges</label>
                                              <input type="number"  value="" name="setup_charges" class="form-control" id="setup_charges" onkeyup="get_total()">
                                          </div>
                                        </div>
                                        <div class="col">
                                          <div class="mb-3">
                                              <label for="software_charges" class="col-form-label">Software Charges</label>
                                              <input type="number"  value="" name="software_charges" class="form-control" id="software_charges" onkeyup="get_total()">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">

                                        <div class="col">
                                          <div class="mb-3">
                                            <label for="invoice_terms" class="col-form-label">Invoice Terms</label>
                                            <select class="custom-select" name="invoice_terms" id="invoice_terms">
                                              <option value="1">Monthly</option>
                                              <option value="3">Quarterly</option>
                                              <option value="6">Half Year</option>
                                              <option value="12">Yearly</option>
                                            </select>
                                          </div>
                                        </div>

                                        <div class="col">
                                          <div class="mb-3">
                                            <label for="free_trail" class="col-form-label">Free Trail</label>
                                            <select class="custom-select" name="free_trail" id="free_trail">
                                              <option value="1">1 time</option>
                                              <option value="2">2 times</option>
                                              <option value="3">3 times</option>
                                              <option value="4">4 times</option>
                                              <option value="5">5 times</option>
                                              <option value="6">6 times</option>
                                              <option value="7">7 times</option>
                                              <option value="8">8 times</option>
                                              <option value="9">9 times</option>
                                              <option value="10">10 times</option>
                                              <option value="11">11 times</option>
                                              <option value="12">12 times</option>
                                            </select>
                                          </div>
                                        </div>
                                        
                                      </div>
                                      <div id="amount_wrapper">Total: </div>
                                      <div class="mb-3 text-right">
                                          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                                          <button type="submit" class="btn btn-primary btn-sm">Proceed</button>
                                      </div>
                                  </form>
                              </div>
                          </div>

                      </div>
                  </div>

              </div>
            @endforeach                
          </tbody>
        </table>
        {{-- <span style="float:right">{{$stores->links()}}</span> --}}
      </div>
      @else
        <h5 class="mt-5 mb-5 text-info text-center"><b>There is no pending stores for now.</b></h5>
      @endif
    </div>
  </div>

  <script>
    function get_total(){
        var web_charges = $("#web_charges").val();
        var app_charges = $("#app_charges").val();
        var shop_charges = $("#shop_charges").val();
        var setup_charges = $("#setup_charges").val();
        var software_charges = $("#software_charges").val();
        var amount_wrapper = $("#amount_wrapper");
        var total = other_amount = 0;
        
        if(web_charges != "")
          total = total + parseInt(web_charges);

        if(app_charges != "")
          total = total + parseInt(app_charges);
        
        if(shop_charges != "")
          total = total + parseInt(shop_charges);
        
        if(setup_charges != "")
          other_amount = other_amount + parseInt(setup_charges);

        if(software_charges != "")
          other_amount = other_amount + parseInt(software_charges);

        if(other_amount != 0)
          total = total + other_amount;

        amount_wrapper.html("Total: " + total + ", Setup & Software Charges(if any):" + other_amount);
    }
  </script>
@endsection

@push('styles')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
@endpush

@push('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
@endpush

