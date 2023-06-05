@extends('layouts.admin')
@section('content') 
<div class="nk-content-wrap">
<div class="nk-block-head nk-block-head-lg wide-sm">
    <div class="nk-block-head-content">
        <div class="nk-block-head-sub">
            <a class="back-to" href="{{url('admin/profile')}}">
                <em class="icon ni ni-arrow-left"></em><span>Account Setting</span></a>
        </div>
        <h2 class="nk-block-title fw-normal">Account Setting</h2>
        <div class="nk-block-des">
                <p class="lead">Form is most esential part of your project. We styled out nicely so you can build your form so quickly.</p>
        </div>
    </div>
</div>
@if(Session::has('message'))
        <div class="example-alert mb-4">
            <div class="alert alert-success alert-icon">
                <em class="icon ni ni-check-circle"></em> 
                <strong>{{ session('message')}}</strong> 
            </div>
        </div>
        @endif
<div class="card card-bordered ">
    <div class="card-inner">
        <div class="card-head"><h5 class="card-title">Profile</h5></div>
        <form method="post" enctype="multipart/form-data" action="{{route('admin.update')}}">
        @include('includes.form_error')
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="form-group">
                    {!! Form::label('name', 'UserName', ['class' => 'form-label']) !!}
                    <div class="form-control-wrap">
                        {!! Form::text('name', $value =  $user->username , ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <!-- Email -->
                <div class="form-group">
                    {!! Form::label('email', 'Email:', ['class' => 'form-label']) !!}
                    <div class="form-control-wrap">
                        {!! Form::email('email', $value = $user->email, ['class' => 'form-control']) !!}
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
            @csrf
            <div class="col-lg-6">
                <div class="form-group">
                    {!! Form::submit('Submit', ['class' => 'btn btn-lg btn-primary'] ) !!}
                </div>
            </div>
        </div>
    </form>
    </div> 
 </div>
</div>
@endsection 
