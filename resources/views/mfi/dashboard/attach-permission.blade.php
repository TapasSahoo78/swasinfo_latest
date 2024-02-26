@extends('mfi.layouts.app')
@push('style')
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
@endpush
@section('pagetitlesection')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ Route::currentRouteName() }}" class="nav-link custom-cumb">{{ __('Attach Permission') }}</a>
    </li>
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper p-5">

        <div class="container-fluid">

            <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
                <div>
                    <h2 class="text-2xl text-slate-800 font-bold mb-6">Permissions</h2>
                    <form method="post">
                        @csrf
                        <div class="mb-3">
                            <div class="card p-3">
                                <!-- Start -->
                                <label class="flex items-center">
                                    <input type="checkbox" class="form-checkbox" name="permission[]" value="view-dashboard"
                                        @if ($roleData->hasPermission('view-dashboard')) checked @endif />
                                    <span class="text-sm ml-2">View Dashboard Page</span>
                                </label>
                                <!-- <p class="font-weight-light text-small">N.B: If This is Not checked user will be redirected
                                    to Accounts Page</p> -->
                                <!-- End -->
                            </div>
                        </div>

                        <div class="row">

                            @forelse ($permissions as $chunk)
                                <div class="col-md-3  mb-3">

                                    <div class="permission-card">
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
                                </div>
                            @empty
                            @endforelse
                            @error('permission')
                                <span class="text-danger text-sm">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="text-center mt-3">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-warning btn-md">Submit</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- /.content-wrapper -->
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $("#addbranch-btn").click(function() {
                $("#slide-from-right").addClass("show-side-form");
            });

            $("#close-btn").click(function() {
                $("#slide-from-right").removeClass("show-side-form");
            });
        });
    </script>
    <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/datatableajax.js') }}"></script>
@endpush
