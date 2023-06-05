@extends('backend.layouts.master')
@section('main-content')
<div class="card">
  <h5 class="card-header">Message</h5>  
  <div class="card-body">
    @if($message)   
        @if($message->photo)  
        <img src="{{ asset('products/images/profile/'.$message->photo) }}" class="img-profile rounded-circle"   style="margin-left:44%;" alt="{{$message->photo}}" wight="30" height="60">
        @else 
        <img src="{{asset('backend/img/avatar.png')}}" class="rounded-circle " style="margin-left:44%;">
        @endif
   
        <div class="py-4"> 
               <table class="table "  >
  <thead>
    <tr class="table-secondary">
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Phone</th>
    </tr>
  </thead>
  <tbody>
    <tr> 
      <td>{{$message->name}}</td>
      <td>{{$message->email}}</td>
      <td>{{$message->phone}}</td>
    </tr>
     
  </tbody>
</table>
        </div>
        <hr/>
  <h5 class="text-center"  ><strong>Subject :</strong> {{$message->subject}}</h5>
        <p class="py-5">{{$message->message}}</p>

    @endif

  </div>
</div>
@endsection