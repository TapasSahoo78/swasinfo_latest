@extends('admin.layouts.app')
@push('styles')

@endpush
@section('content')
<div>
    <h2 class="text-2xl text-slate-800 font-bold mb-6">{{$pageTitle}}</h2>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <form class="row g-3" method="post" action="{{ route('admin.permission.save') }}" enctype="multipart/form-data">
            @csrf
            <div class="col-md-4">
              <label for="name" class="form-label">Name</label>
              <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
            </div>
            @error('name')
                {{ $message }}
            @enderror
             <input type="submit" class="btn btn-primary" value="Submit">
          </form>
    </div>
</div>
@endsection

@push('style')

@endpush
