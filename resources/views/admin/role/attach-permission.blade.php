@extends('admin.layouts.app')

@push('style')
@endpush
@section('content')

    <div class="content-wrapper">
        <div>


                <div class="content-header">
                    <h1 class="m-0 text-dark">{{ $pageTitle }}</h1>
                </div>

                    <div class="content">
                            <form method="post">
                                @csrf
                                <div class="col-md-12 mb-3">
                                    <div class="card card-body nb_box">
                                        <!-- Start -->
                                        <label class="flex items-center">
                                            <input type="checkbox" class="form-checkbox" name="permission[]"
                                                value="view-dashboard" @if ($roleData->hasPermission('view-dashboard')) checked @endif />
                                            <span class="text-sm ml-2">View Dashboard Page</span>
                                        </label>
                                        <p class="font-weight-light text-small">N.B: If This is Not checked user will be
                                            redirected to Accounts Page</p>
                                        <!-- End -->
                                    </div>
                                </div>

                                <div class="flex flex-wrap-items-center pb-5">
                                    <div class="permission_box">
                                        @forelse ($permissions as $chunk)
                                            <div class="card card-body col-md-3 mr-2 mb-2">
                                                @forelse ($chunk as $permission)
                                                    <div class="p-2">
                                                        <!-- Start -->
                                                        <label class="flex items-center">
                                                            <input type="checkbox" class="form-checkbox" name="permission[]"
                                                                value="{{ $permission->slug }}"
                                                                @if ($roleData->hasPermission($permission->slug)) checked @endif />
                                                            <span class="text-sm ml-2">{{ $permission->name }}</span>
                                                        </label>
                                                        <!-- End -->
                                                    </div>
                                                @empty
                                                @endforelse
                                            </div>
                                        @empty
                                        @endforelse


                                </div>
                                <div class="text-center mt-3">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary btn-md">Submit</button>
                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
@endpush
