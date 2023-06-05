@extends('layouts.admin')

@section('content') 


<div class="nk-content-wrap">

<div class="nk-block-head">
    <div class="nk-block-head-content">
        <h4 class="nk-block-title">Agent Profile</h4>     
    </div>
</div>

<div class="card card-bordered ">
    <div class="card-inner">

        @include('includes.form_error')

 
    {!! Form::model($user,['method' => 'PATCH', 'action' =>[ 'AdminUsersController@update',$user->id],'files'=>true]) !!}
        
        <div class="row">
        
            <div class="col-sm-6">

                <div class="form-group">
                {!! Form::label('office_name', 'Office Name', ['class' => 'form-label']) !!}
                    <div class="form-control-wrap">
                    {!! Form::text('office_name', $value =  $user->office_name , ['class' => 'form-control', 'placeholder' => 'Office Name']) !!}
                    

                    </div>
                </div>
             </div> 

              <div class="col-sm-6">

                <div class="form-group">
                {!! Form::label('compnay_name', 'Official Name', ['class' => 'form-label']) !!}
                    <div class="form-control-wrap">
                    {!! Form::text('compnay_name', $value =  $user->compnay_name , ['class' => 'form-control', 'placeholder' => 'Official Name']) !!}
                
                    </div>
                </div>
             </div> 

        </div>
         
        <div class="row mt-2">
        
            <div class="col-sm-6">

                <div class="form-group">
                {!! Form::label('reg_number', 'Registration number', ['class' => 'form-label']) !!}
                    <div class="form-control-wrap">
                    {!! Form::text('reg_number', $value =  $user->reg_number , ['class' => 'form-control', 'placeholder' => 'Registration number']) !!}
                    

                    </div>
                </div>
             </div> 

              <div class="col-sm-6">

                <div class="form-group">
                {!! Form::label('tax_number', 'Tax number', ['class' => 'form-label']) !!}
                    <div class="form-control-wrap">
                    {!! Form::text('tax_number', $value =  $user->tax_number , ['class' => 'form-control', 'placeholder' => 'Tax number']) !!}
                
                    </div>
                </div>
             </div> 

        </div> 
        

        <div class="row mt-2">
        
            <div class="col-sm-6">

                <div class="form-group">
                {!! Form::label('country', 'Country', ['class' => 'form-label']) !!}
                    <div class="form-control-wrap">
                    {!! Form::text('country', $value =  $user->country , ['class' => 'form-control', 'placeholder' => 'Country']) !!}
                    

                    </div>
                </div>
             </div> 

              <div class="col-sm-6">

                <div class="form-group">
                {!! Form::label('city', 'City', ['class' => 'form-label']) !!}
                    <div class="form-control-wrap">
                    {!! Form::text('city', $value =  $user->city , ['class' => 'form-control', 'placeholder' => 'City']) !!}
                
                    </div>
                </div>
             </div> 

        </div>

        

        
        <div class="row mt-2">
        
            <div class="col-sm-6">

                <div class="form-group">
                {!! Form::label('zip', 'Zip code', ['class' => 'form-label']) !!}
                    <div class="form-control-wrap">
                    {!! Form::text('zip', $value =  $user->zip , ['class' => 'form-control', 'placeholder' => 'Zip code']) !!}
                    

                    </div>
                </div>
             </div> 

              <div class="col-sm-6">

                <div class="form-group">
                {!! Form::label('address', 'Address', ['class' => 'form-label']) !!}
                    <div class="form-control-wrap">
                    {!! Form::text('address', $value =  $user->address , ['class' => 'form-control', 'placeholder' => 'Address']) !!}
                
                    </div>
                </div>
             </div> 

        </div> 

        
        <div class="row mt-2">
        
            <div class="col-sm-6">

                <div class="form-group">
                {!! Form::label('company_url', 'Company url', ['class' => 'form-label']) !!}
                    <div class="form-control-wrap">
                    {!! Form::text('company_url', $value =  $user->company_url , ['class' => 'form-control', 'placeholder' => 'Company url']) !!}
                    

                    </div>
                </div>
             </div> 

              <div class="col-sm-6">

                <div class="form-group">
                {!! Form::label('office_email', 'Official email', ['class' => 'form-label']) !!}
                    <div class="form-control-wrap">
                    {!! Form::text('office_email', $value =  $user->office_email , ['class' => 'form-control', 'placeholder' => 'Official email']) !!}
                
                    </div>
                </div>
             </div> 

        </div> 
        
        <div class="row mt-2">
        
            <div class="col-sm-6">

                <div class="form-group">
                {!! Form::label('office_phone', 'Office Number', ['class' => 'form-label']) !!}
                    <div class="form-control-wrap">
                    {!! Form::text('office_phone', $value =  $user->office_phone , ['class' => 'form-control', 'placeholder' => 'Office Number']) !!}
                    

                    </div>
                </div>
             </div> 

              <div class="col-sm-6">

                <div class="form-group">
                {!! Form::label('emg_phone', 'Emergency phone number', ['class' => 'form-label']) !!}
                    <div class="form-control-wrap">
                    {!! Form::text('emg_phone', $value =  $user->emg_phone , ['class' => 'form-control', 'placeholder' => 'Emergency phone number']) !!}
                
                    </div>
                </div>
             </div> 

        </div>
        
        <div class="row mt-2">
            <div class="col-sm-2">
                <div class="form-group">
                     {!! Form::label('title', 'Title', ['class' => 'form-label']) !!}
                    <select id="title" name="title" class="form-control select" required>
                            <option value="MR">MR</option>
                            <option value="MRS">MRS</option>
                        </select>
                </div>
            </div>

            <div class="col-sm-5">
               <div class="form-group">
                {!! Form::label('fname', 'First name', ['class' => 'form-label']) !!}
                    <div class="form-control-wrap">
                    {!! Form::text('fname', $value =  $user->fname , ['class' => 'form-control', 'placeholder' => 'First name']) !!}
                
                    </div>
                </div>
            </div>     

            <div class="col-sm-5">
               <div class="form-group">
                {!! Form::label('lname', 'Last name', ['class' => 'form-label']) !!}
                    <div class="form-control-wrap">
                    {!! Form::text('lname', $value =  $user->lname , ['class' => 'form-control', 'placeholder' => 'Last name']) !!}
                
                    </div>
                </div>
            </div>      

 


        </div>    
              
 
        <div class="row mt-2">
            <div class="col-sm-6">

  

                <!-- Email -->
                <div class="form-group">
                    {!! Form::label('email', 'Email', ['class' => 'form-label']) !!}
                    <div class="form-control-wrap">
                        {!! Form::email('email', $value = null, ['class' => 'form-control', 'placeholder' => 'email']) !!}
                    </div>
                </div>
            </div>

            <div class="col-sm-6">

  

                <!-- Email -->
                <div class="form-group">
                    {!! Form::label('phone', 'Phone', ['class' => 'form-label']) !!}
                    <div class="form-control-wrap">
                        {!! Form::text('phone', $value = null, ['class' => 'form-control', 'placeholder' => 'Phone']) !!}
                    </div>
                </div>
            </div>
        </div>


        <div class="row mt-2">
             

            <div class="col-sm-6">
               <div class="form-group">
                {!! Form::label('mobile', 'Mobile', ['class' => 'form-label']) !!}
                    <div class="form-control-wrap">
                    {!! Form::text('mobile', $value =  $user->mobile , ['class' => 'form-control', 'placeholder' => 'Mobile']) !!}
                
                    </div>
                </div>
            </div>     

            <div class="col-sm-6">
               <div class="form-group">
                {!! Form::label('position', 'Position', ['class' => 'form-label']) !!}
                    <div class="form-control-wrap">
                    {!! Form::text('position', $value =  $user->position , ['class' => 'form-control', 'placeholder' => 'Position']) !!}
                
                    </div>
                </div>
            </div>      


        </div> 

          


        
        <div class="row mt-2">
             

            <div class="col-sm-6">
               <div class="form-group">
                {!! Form::label('skype_id', 'Skype id', ['class' => 'form-label']) !!}
                    <div class="form-control-wrap">
                    {!! Form::text('skype_id', $value =  $user->skype_id , ['class' => 'form-control', 'placeholder' => 'Skype id']) !!}
                
                    </div>
                </div>
            </div>      
 
            <div class="col-sm-6">
                 <div class="form-group">
                    {!! Form::label('is_active', 'Status:', ['class' => 'form-label']) !!}
                    <div class="form-control-wrap">
                        {!! Form::select('is_active',array(1=>'Active', 0=>'Pending',2=>'Cancel'),null, ['class' => 'form-control']) !!}
                    </div>
                </div>
             </div>
        </div> 
        
         <div class="row mt-2">
           
            <div class="col-sm-6">
                     <div class="form-group">
                        {!! Form::label('package_id', 'Package:', ['class' => 'form-label']) !!}
                        <div class="form-control-wrap">
                            
                            {!! Form::select('package_id',[''=>'Choose Package']+$Packages ,null, ['class' => 'form-control']) !!}
        
                        </div>
                    </div>
            </div>
        </div> 
             
        

           
       
        <div class="row mt-2">
             <div class="col-sm-6">

                <div class="form-group">
                    {!! Form::submit('Update', ['class' => 'btn btn-lg btn-primary'] ) !!}
                </div>
            </div>
        </div>


        {!! Form::close()  !!}

 
        </div>

    </div>

   
 



   

</div>
@endsection 
