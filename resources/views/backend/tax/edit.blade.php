@extends('backend.layouts.master')

@section('main-content')

<div class="card m-3">
    <h5 class="card-header">Edit Tax</h5>
    <div class="card-body">
      <form method="post" action="{{route('taxs.update',$tax->id)}}">
        @csrf
            @method('PATCH')
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Tax (If Any)</label>
          <input id="inputTitle" type="number" name="tax" placeholder="Enter tax"  value="{{$tax->tax}}" class="form-control">
          @error('tax')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="status" class="col-form-label">Status</label>
          <select name="status" class="form-control">
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
          </select>
          @error('status')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group mb-3">
          <button type="reset" class="btn btn-warning">Reset</button>
           <button class="btn btn-success" type="submit">Submit</button>
        </div>
      </form>
    </div>
</div>

@endsection
