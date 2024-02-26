
@extends('admin.layouts.app')

@push('style')

@endpush
@section('content')
<div>
    <h2 class="text-2xl text-slate-800 font-bold mb-6">{{$pageTitle}}</h2>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <form class="row g-3" method="post" action="{{ route('admin.role.save') }}" enctype="multipart/form-data">
            @csrf
            <div class="col-md-4">
              <label for="name" class="form-label">Name</label>
              <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
            </div>
            @error('name')
                {{ $message }}
            @enderror
            <div class="col-md-4">
              <label for="name" class="form-label">Short Code</label>
              <input type="text" class="form-control" name="short_code" value="{{ old('short_code') }}">
            </div>
            @error('short_code')
                {{ $message }}
            @enderror
            <div class="col-md-6">
                <label for="parent_id" class="form-label">Role Type</label>
                <select class="form-control" name="role_type">
                    <option value="admin"  >Admin</option>
                    <option value="seller">Seller</option>
                    <option value="customer" >Customer</option>
                    <option value="employee" >Employee</option>
                </select>
            </div>
            @error('role_type')
                {{ $message }}
            @enderror
             <input type="submit" class="btn btn-primary" value="Submit">
          </form>
    </div>
</div>
@endsection
@push('scripts')

@endpush
