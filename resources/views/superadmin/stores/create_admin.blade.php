@extends('layouts.admin')

@section('content') 

<h2>Create User</h2>

{!! Form::open(['method' => 'Post', 'action' => 'AdminUsersController@store','files'=>true]) !!}
 
    <fieldset>
 
      
      <!-- Name -->
        <div class="form-group">
            {!! Form::label('name', 'Name:', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('name', $value = null, ['class' => 'form-control', 'placeholder' => 'Name']) !!}
            </div>
        </div>


        <!-- Email -->
        <div class="form-group">
            {!! Form::label('email', 'Email:', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::email('email', $value = null, ['class' => 'form-control', 'placeholder' => 'email']) !!}
            </div>
        </div>

        

        <!-- Status -->
        <div class="form-group">
            {!! Form::label('is_active', 'Status:', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::select('is_active',array(1=>'Active', 0=>'Not Active'),0, ['class' => 'form-control']) !!}
            </div>
        </div>


         <!-- password -->
        <div class="form-group">
            {!! Form::label('password', 'Password:', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::password('password', ['class' => 'form-control']) !!}
            </div>
        </div>


         



         <!-- Submit Button -->
        <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2">
                {!! Form::submit('Submit', ['class' => 'btn btn-lg btn-info pull-right'] ) !!}
            </div>
        </div>

       

 
    </fieldset>
 
 {!! Form::close()  !!}

 @include('includes.form_error')

@endsection 
