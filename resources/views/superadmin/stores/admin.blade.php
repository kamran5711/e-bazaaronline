@extends('layouts.admin')
@section('content')

    <div class="nk-content-wrap">
        @if(Session::has('delete_user'))
            <p class="alert alert-danger">{{ session('delete_user')}}</p>
        @endif
        @if(Session::has('user_succss'))
            <p class="alert alert-success">{{ session('user_succss')}}</p>
        @endif
        <div class="nk-block-head pb-2">
            <div class="nk-block-head-content">
                <h4 class="nk-block-title text-center">All Businesses</h4>
            </div>
        </div>


        @if($user)

            <div class="row">
                <div class="col-sm-12 mt-2">
                    <table class="table table-bordered">
                        <thead class="tb-member-head thead-light">
                        <tr class="tb-member-item">
                            <th class="overline-title">Id</th>
                            <th class="overline-title">Name </th>
                            <th class="overline-title">Email</th>
                            <th class="overline-title">DOMAIN</th>
                            <th class="overline-title">Status</th>
                            <th class="overline-title">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($user as $user)
                            <tr>
                                <td >{{$user->id}}</td>
                                <td>{{$user->person_name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->domain}}</td>
                                {{--                  <td >@if($user->paid==1)--}}
                                {{--                    <span class="badge   badge-success">Active</span>--}}
                                {{--                    @elseif ($user->paid==0)--}}
                                {{--                    <span class="badge   badge-warning">Pending</span>--}}
                                {{--                    @else--}}
                                {{--                    <span class="badge   badge-danger">Cancel</span>--}}
                                {{--                    @endif--}}
                                {{--                    </td>--}}
                                <td >

                                        <a class="btn @if($user->is_active==1) btn-success @else btn-danger @endif" style="color:white;"  class="btn btn-sm btn-wave"   data-toggle="modal" data-target="#myModal{{$user->id}}" ><i class="fa fa-toggle-on" aria-hidden="true">@if($user->is_active==1)Active @else Inactive @endif</i></a>

                                </td>
                                <td>
                                    <div class="dropdown">
                                        <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown">
                                            <em class="icon ni ni-more-h"></em>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-xs">
                                            <ul class="link-list-plain">
                                                <li>
                                                    <a href="{{url('admin/users/'.$user->id)}}" class="icon ni ni-eye btn btn-dim btn-sm btn-primary">View</a></li>
                                                <li>
                                                <li>
                                                    <a href="{{route('store-payments',$user->id)}}" class="icon ni ni-eye btn btn-dim btn-sm btn-success">Payments</a></li>

                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <div class="container">
                                <div class="modal fade" id="myModal{{$user->id}}" role="dialog">
                                    <div class="modal-dialog">
                                    @php
                                        $verfied = App\Models\StoreMemberShip::where('user_id',$user->id)->first();
                                    @endphp
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color: #4e4c4c; color: whitesmoke">
                                                <h5 class="modal-title">Business Status Update</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{route('user.enable')}}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="user_id" value="{{$user->id}}">
                                                    <label for="recipient-name" class="col-form-label">Select Status</label>
                                                    <select class="custom-select" name="is_active">
                                                        <option value="1"  {{ ($user->is_active) == (1) ?  'selected' : null }}>Active</option>
                                                        <option value="0" {{ ($user->is_active) == (0) ?  'selected' : null }}>Inactive</option>
                                                    </select>
                                                    <div class="mb-3">
                                                        <label for="recipient-name" class="col-form-label">Membership charges</label>
                                                        <input type="number" value="{{! is_null($verfied) ? $verfied->membership_charge :'0'}}" name="membership_charge" class="form-control" id="recipient-name" >
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="recipient-name" class="col-form-label">Setup charges</label>
                                                        <input type="number"  value="{{! is_null($verfied) ? $verfied->setup_charge :'0'}}" name="setup_charge" class="form-control" id="recipient-name">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="recipient-name" class="col-form-label">Software charges</label>
                                                        <input type="number"  value="{{! is_null($verfied) ? $verfied->software_charge :'0'}}" name="software_charge" class="form-control" id="recipient-name">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="recipient-name" class="col-form-label">Verify Date</label>
                                                        <input type="date" value="{{! is_null($verfied) ? $verfied->verified_date :''}}" required name="verified_date" class="form-control" id="recipient-name" >
                                                    </div> 
                                                    <div class="mb-3 text-right">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Update</button>
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
                </div>

            </div><!-- .card-preview -->



        @endif

    </div>

@endsection
