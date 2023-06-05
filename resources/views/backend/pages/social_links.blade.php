@extends('backend.layouts.master')
@section('main-content')
<div class="row">
    <div class="col-md-12">
       @include('backend.layouts.notification')
    </div>
</div>
<div class="card shadow m-3">
    <h5 class="card-header">Social media links</h5>
    <div class="card-body">
      <form method="post" action="{{route('admin.social_links')}}" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">Face Book Name</label>
                    <input type="text" class="form-control" placeholder="Face book page name" name="facebook_name" value="{{old('facebook_name')}}{{isset($record->facebook_name) ? $record->facebook_name : ""}}">
                    @error('facebook_name')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">Face Book Link</label>
                    <input type="text" class="form-control" placeholder="facebook link i-e https://www.facebook.com/" name="facebook_link" value="{{old('facebook_link')}}{{isset($record->facebook_link) ? $record->facebook_link : ""}}">
                    @error('facebook_link')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">Twitter Name</label>
                    <input type="text" class="form-control" placeholder="Twitter name" name="twitter_name" value="{{old('twitter_name')}}{{isset($record->twitter_name) ? $record->twitter_name : ""}}">
                    @error('twitter_name')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">Twitter Link</label>
                    <input type="text" class="form-control" placeholder="Twitter link i-e https://twitter.com/" name="twitter_link" value="{{old('twitter_link')}}{{isset($record->twitter_link) ? $record->twitter_link : ""}}">
                    @error('twitter_link')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">Instagram Name</label>
                    <input type="text" class="form-control" placeholder="Instagram Name" name="instagram_name" value="{{old('instagram_name')}}{{isset($record->instagram_name) ? $record->instagram_name : ""}}">
                    @error('instagram_name')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">Instagram Link</label>
                    <input type="text" class="form-control" placeholder="Instagram link i-e https://www.instagram.com/" name="instagram_link" value="{{old('instagram_link')}}{{isset($record->instagram_link) ? $record->instagram_link : ""}}">
                    @error('instagram_link')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
            </div>
        </div>
        <button class="btn btn-success" type="submit">Save</button>
      </form>
    </div>
</div>
@endsection

