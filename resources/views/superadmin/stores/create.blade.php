@extends('layouts.admin')
  
@section('content') 

<div class="nk-content-wrap">

 
@if(Session::has('delete_user'))

<p class="alert alert-danger">{{ session('delete_user')}}</p>

@endif

@if(Session::has('adminuser_succss'))

<p class="alert alert-success">{{ session('adminuser_succss')}}</p>

@endif


<div class="nk-block-head pb-2">
  <div class="nk-block-head-content">
      <h4 class="nk-block-title">Admin Create </h4> 
  </div>
</div>

<div class="card card-bordered ">
    <div class="card-inner">

         @include('includes.form_error')

    {!! Form::open(['method' => 'Post', 'action' => 'AdminUsersController@store','files'=>true]) !!}
 
     
       <div class="row g-4">

            <div class="col-lg-6">
                    <div class="form-group">
                    {!! Form::label('name', 'Name', ['class' => 'form-label']) !!}
                    <div class="form-control-wrap">
                        {!! Form::text('name', null , ['class' => 'form-control']) !!}
                        

                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <!-- Email -->
                <div class="form-group">
                    {!! Form::label('email', 'Email:', ['class' => 'form-label']) !!}
                    <div class="form-control-wrap">
                        {!! Form::email('email', $value = null, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <!-- password -->
                <div class="form-group">
                    {!! Form::label('password', 'Password', ['class' => 'form-label']) !!}
                    <div class="form-control-wrap">
                        {!! Form::password('password', ['class' => 'form-control']) !!}
                    </div>
                </div>
                <!-- password -->
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    {!! Form::label('password_confirmation', 'Confirm Password', ['class' => 'form-label']) !!}
                    <div class="form-control-wrap">
                        {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>

             <div class="col-lg-6">
               <div class="form-group">
                   {!! Form::label('is_active', 'Is active', ['class' => 'form-label']) !!} 
                     <div class="form-control-wrap">
                        {!! Form::select('is_active',array(1=>'Active', 0=>'Not Active'),0, ['class' => 'form-control']) !!}
                    </div>
                </div>

            </div>

            
        </div>
        <div class="row mt-2">
            <div class="col-lg-6">

                <div class="form-group">
                    {!! Form::submit('Submit', ['class' => 'btn btn-lg btn-primary'] ) !!}
                </div>
            </div>
         </div>   
       
 
 {!! Form::close()  !!}
    </div>
</div>

</div>
@endsection 
