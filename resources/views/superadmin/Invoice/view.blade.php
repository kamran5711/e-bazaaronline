@extends('layouts.admin')
  
@section('content') 

<div class="nk-content-wrap">
	<div class="nk-block-head">
		<div class="nk-block-between g-3">
			<div class="nk-block-head-content">
				<h3 class="nk-block-title page-title">Invoice<strong class="text-primary small"> #{{$inoice->invoice_id}}</strong></h3>
				<div class="nk-block-des text-soft"><ul class="list-inline"><li>Created At: <span class="text-base">{{date('d M Y, h:ma', strtotime($inoice->created_at))}}</span></li></ul></div>
			</div>
			
		</div>
	</div>
	@php
		$verfied = App\Models\StoreMemberShip::where('user_id',$inoice->id)->first();
	@endphp
	<div class="nk-block">
		<div class="invoice">
			<div class="invoice-action">
				@if($inoice->status==0)
				            <a href="" class="btn  btn-sm btn-warning">Unpaid</a>
				         @else
				    <span class="badge   badge-success">Paid</span>
				@endif
			</div>
			<div class="invoice-wrap">
				<div class="invoice-brand text-center">
					  <img class="logo" alt="Ebazar Logo" src="{{asset('images/logo.png')}}">
				</div>
				<div class="invoice-head">
					<div class="invoice-contact">
						<span class="overline-title">Invoice To</span>
						<div class="invoice-contact-info">
							<h4 class="title">{{! is_null($inoice->user) ? $inoice->user->person_name :'Not Found'}}</h4>
							<ul class="list-plain">
								<li><em class="icon ni ni-call-fill"></em><span>{{! is_null($inoice->user) ?$inoice->user->person_tel:'Not Found'}}</span></li>
							</ul>
						</div>
					</div>
					<div class="invoice-desc">
						<h3 class="title">Invoice</h3>
						<ul class="list-plain">
							<li class="invoice-id">
								<span>Invoice ID</span>:<span>{{$inoice->invoice_id}}</span></li>
							<li class="invoice-date"><span>Date</span>:<span>{{date('d M Y', strtotime($inoice->created_at))}}</span></li>
						</ul>
					</div>
				</div>
				<div class="invoice-bills">
					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<tr>
									<th >Item ID</th>
									<th >Title</th>
									<th >Month</th>
									<th>Amount</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td >{{$inoice->invoice_id}}</td>
									<td >{{$inoice->title}}</td>
									<td>{{date('d M Y, h:ma', strtotime($inoice->created_at))}}</td>
									<td>{{! is_null($verfied) ? $verfied->membership_charge :''}}</td>
								</tr>
							</tbody>

						</table>
						<div class="nk-notes ff-italic fs-12px text-soft"> Invoice was created on a computer and is valid without the signature and seal.
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection 
