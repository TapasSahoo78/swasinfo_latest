@extends('admin.layouts.app')
@push('style')
<link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
@endpush
@section('pagetitlesection')
<li class="nav-item d-none d-sm-inline-block">
    <a href="{{ Route::currentRouteName() }}" class="nav-link custom-cumb">{{ __('Dashboard') }}</a>
</li>
@endsection
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper p-5">

    <div class="container-fluid">

        <div class="profile-update">
            <form method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div>
                            <img src="{{ auth()->user()?->profile_picture }}" id="blah" class="rounded-full " width="80" height="80">
                        </div>
                        <label for="profile_image" class="block text-sm font-medium mb-1">Profile Image</label>
                        <input type="file" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])" id="profile_image" name="profile_image" accept="image/jpeg,image/png,image/jpg,image/gif">
                        @error('profile_image')
                        <span class="text-sm mt-1 text-danger">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <div class="modal-body generate-qr">
                            <div class="qrcode_box" id="generate-qr">
                                <div class="qr_code" style="width: 200px;
        margin: auto;">
                                    <?php
                                    $datas = url('/home') . '/' . auth()->user()->id;
                                    ?>
                                    {!! DNS2D::getBarcodeHTML($datas, 'QRCODE', 6, 6, 'black', true) !!}
                                </div>
                            </div>

                        </div>
                        <?php $uid = auth()->user()->id; ?>
                        <div class="text-center">
                            <a id="shareButton" class="btn btn-primary" href="{{ route('admin.agent.qrpage', $uid) }}">
                                <span><i class="fa fa-share-alt" aria-hidden="true"></i></span>
                                Share
                            </a>

                        </div>
                    </div>
                    {{-- <img src="" id="blah" class="rounded" width = "200" height = "200">  --}}

                </div>
                <div class="row">
                    <div class="col-6">
                        <label>First Name <span class="text-danger">*</span></label>
                        <input id="first_name" class="form-control" type="text" name="first_name" placeholder="First Name" value="{{ auth()->user()->first_name }}" />
                        @error('first_name')
                        <span class="text-sm mt-1 text-danger">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label>Last Name <span class="text-danger">*</span></label>
                        <input id="last_name" class="form-control" type="text" name="last_name" placeholder="Last Name" value="{{ auth()->user()->last_name }}" />
                        @error('last_name')
                        <span class="text-sm mt-1 text-danger">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label>Username <span class="text-danger">*</span></label>
                        <input type="text" name="username" class="form-control" id="customerUserName" value="{{ auth()->user()->username }}" placeholder="Username">
                        @error('username')
                        <span class="text-sm mt-1 text-danger">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label>Email <span class="text-danger">*</span></label>
                        <input id="email" class="form-control" type="email" name="email" value="{{ auth()->user()->email }}" readonly disabled />
                        @error('email')
                        <span class="text-sm mt-1 text-danger">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label>Phone <span class="text-danger">*</span></label>
                        <input id="mobile_number" class="form-control" type="number" name="mobile_number" value="{{ auth()->user()->mobile_number }}" />
                        @error('mobile_number')
                        <span class="text-sm mt-1 text-danger">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <?php if(auth()->user()->id == 1){ ?>
                    <div class="col-6">
                        <label>IGST %<span class="text-danger">*</span></label>
                        <input id="igst" class="form-control" type="number" name="igst" value="{{ auth()->user()->igst }}" />
                        @error('igst')
                        <span class="text-sm mt-1 text-danger">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>

                    <div class="col-6">
                        <label>CGST %<span class="text-danger">*</span></label>
                        <input id="cgst" class="form-control" type="number" name="cgst" value="{{ auth()->user()->cgst }}" />
                        @error('mobile_number')
                        <span class="text-sm mt-1 text-danger">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <?php  } ?>
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