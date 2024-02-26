@extends('mfi.layouts.app')
@push('style')
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
@endpush
@section('pagetitlesection')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ Route::currentRouteName() }}" class="nav-link custom-cumb">{{ __('Change Password') }}</a>
    </li>
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper p-5">

        <div class="container-fluid">
            <div class="profile-update change-password">
                <form method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="p-relative">
                                <div class="form-group">
                                    <label>Old Password</label>
                                    <span class="et-icon"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                                    <input id="password" class="form-control" type="password" name="current_password">
                                 
                                    @error('current_password')
                                        <span class="text-danger text-sm">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                               
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>New Password</label>
                                <span class="et-icon"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                                <input id="new_password" class="form-control" type="password" name="new_password">

                            </div>
                            @error('new_password')
                                <span class="text-danger text-sm">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <span class="et-icon"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                                <input id="confirm_password" class="form-control" type="password" name="confirm_password">

                            </div>
                            @error('confirm_password')
                                <span class="text-danger text-sm">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="col-12">
                            <input type="submit" value="Update">
                        </div>
                    </div>
                </form>
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
@endpush
