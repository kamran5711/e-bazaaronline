@extends('backend.layouts.master')

@section('main-content')

<div class="card m-3">
    <h5 class="card-header">Edit Discount</h5>
    <div class="card-body">
      <form method="post" action="{{route('discounts.update',$discount->id)}}">
        @csrf
            @method('PATCH')
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Discount</label>
          <input id="inputTitle" type="number" name="discount" placeholder="Enter tax"  value="{{$discount->discount}}" class="form-control">
          @error('discount')
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
