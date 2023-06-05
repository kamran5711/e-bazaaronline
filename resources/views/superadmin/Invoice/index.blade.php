@extends('layouts.admin')
@section('content') 

<style>
table{
    width:100%;
}
#example_filter{
    float:right;
  
    margin-right:10%;
}
#example_paginate{
    float:right;
}
label {
    display: inline-flex;
    margin-bottom: -5rem;
    margin-top: -5rem;

}

</style>
<div class="nk-content-wrap">
	 @if(Session::has('success'))
    <p class="alert alert-success">{{ session('success')}}</p>
@endif


			<div class="container" style="font-size: small">
                <div class="text-center"><b> Unpaid Invoices</b></div>
	<div class="row">
	<table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr style="padding-right: -37px;">
                <th>Invoice ID</th>
                <th>Agent Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Date</th>
                <th>Amount</th>
                <th>Payment Mode</th>
				<th>Approve</th>
            </tr>
        </thead>
        <tbody>

        @foreach($inoices as $inoice)
            @php
                $verfied=App\Models\StoreMemberShip::where('user_id',$inoice->id)->first();
            @endphp
            <tr>
                <td ><a href="{{url('invoice/agent/'.$inoice->id)}}"># {{$inoice->invoice_id}}</a>
                    <a href="{{! is_null($inoice->user) ? url('invoices/agent/'.$inoice->user->id).'?status='.$status :'Not Found'}}"></td>
                <td>{{! is_null($inoice->user) ? $inoice->user->person_name :'Not Found'}}</td>
                <td>{{! is_null($inoice->user) ? $inoice->user->person_tel :'Not Found'}}</td>
                <td>{{! is_null($inoice->user) ?$inoice->user->email :'Record Not Found'}}</td>
                <td>{{date('d/m/Y', strtotime($inoice->created_at))}}</td>
                <td>{{! is_null($verfied) ? $verfied->membership_charge:''}} </td>
                <td>
                    @if($inoice->attachment)
                        <a style="margin-left:10px;color:#526484" target="_blank"  href="{{ url('images/'.$inoice->attachment)}}">
                            View Attachment</a>
                    @elseif($inoice->name)
                        Cash<br>{{! is_null($inoice) ? $inoice->name :'Not Found'}}<br>{{! is_null($inoice) ? $inoice->phone :'Not Found'}} / {{! is_null($inoice) ? $inoice->date :'Not Found'}}
                    @else

                    @endif
                </td>
                <td>
                    <ul class="link-list-plain">
                        <li>
                            <a href="{{url('invoice/agent/'.$inoice->id)}}" class="btn  btn-sm btn-warning"><em class="icon ni ni-eye"> </em>View</a></li>
                        @if($inoice->attachment && $inoice->status==0 || $inoice->name && $inoice->status==0)
                            <li><a   href="{{url('accept/attachment/'.$inoice->id)}}" class="btn  btn-sm btn-success" onclick="return confirm('Are you sure?')"><em class="icon ni ni-repeat"></em> Accept </a></li>
                        @endif
                    </ul>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
	</div>
</div>
</div>
</div>
</div>
@endsection 

