@extends('admin.layouts.app')
@push('style')
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
@endpush
@section('pagetitlesection')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ Route::currentRouteName() }}" class="nav-link custom-cumb">{{ __('MFI') }}</a>
    </li>
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-8">
                        <!-- <h1 class="m-0 text-dark">No of MFIS: 0</h1> -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4">
                        <button class="model-slide-btn" id="addbranch-btn">
                            <span><i class="fa fa-plus" aria-hidden="true"></i></span>
                            {{ __('ADD MFI') }}
                        </button>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <!-- /.row -->
                <!-- Recent Assets -->
                <div class="row">
                    <div class="col-12">
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0" style="height: 700px;">
                            <table id="mfiTable" class="table  text-nowrap custom-data-table">
                                <thead>
                                    <tr>
                                        <th>{{ __('MFI Name') }}</th>
                                        <th>{{ __('MFI Code') }}</th>
                                        <th>{{ __('Registration Number') }}</th>
                                        <th>{{ __('Login Id') }}</th>
                                        <th>{{ __('Link') }}</th>
                                        <th>{{ __('Logo') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Created On') }}</th>
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <!-- /.card -->
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>

    <!-- add baranch form -->

    <div id="slide-from-right" class="slide-from-right no-scroll-form">
        <h2>MFI <span class="close-btn"><i class="fa fa-times" aria-hidden="true"></i></span></h2>

        <form action="{{ route('admin.mfi.save') }}" class="formsubmit fileupload" id="submit_branch" method="post"
            enctype="multipart/form-data">
            <input type="hidden" name="user_id" id="user_id">
            <input type="hidden" name="uuid" id="id">
            <div class="row">
                <div class="col-md-6">
                    <div class="single-input">
                        <div class="form-group">
                            <label for="branch-name">{{ __('Name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name"
                                aria-describedby="emailHelp" placeholder="Enter MFI Name">

                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="single-input">
                        <div class="form-group">
                            <label for="branch-name">{{ __('Code') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="code" name="code"
                                aria-describedby="emailHelp" placeholder="Enter MFI Code" minlength="1" maxlength="12">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="single-input">
                        <div class="form-group">
                            <label for="branch-name">Registration Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="registration_number" name="registration_number"
                                aria-describedby="emailHelp" placeholder="Enter MFI Registration Number" minlength="1"
                                maxlength="12">

                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="single-input">
                        <div class="form-group">
                            <label for="branch-name">Login Id <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="login_id" name="login_id"
                                aria-describedby="emailHelp" placeholder="Enter Login Id" minlength="6" maxlength="8">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="single-input">
                        <div class="form-group">
                            <label for="branch-name">Contact Person Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="contact_person_name" name="contact_person_name"
                                aria-describedby="emailHelp" placeholder="Enter Contact Person Name">

                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="single-input">
                        <div class="form-group">
                            <label for="branch-name">Contact Person Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="contact_person_email"
                                name="contact_person_email" aria-describedby="emailHelp"
                                placeholder="Enter Contact Person Email">

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="single-input">
                        <div class="form-group">
                            <label for="branch-name">Contact Person Phone <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="contact_person_phone"
                                name="contact_person_phone" aria-describedby="emailHelp"
                                placeholder="Enter Contact Person Phone" max="10">

                        </div>
                    </div>
                </div>
            </div>

            <div class="multiple-input">
                <div class="form-group">
                    <label>Address <span class="text-danger">*</span></label>
                    {{--  <input type="text" class="form-control" aria-describedby="emailHelp" placeholder="Street Address">  --}}
                    <div class="row">
                        <div class="col-md-6">
                            <select name="country_name" id="country_name">
                                <option value="">Select Country</option>
                                @forelse ($countryList as $country)
                                    <option value="{{ $country->name }}" data-id="{{ $country->name }}">
                                        {{ !empty($country->name) ? $country->name : '' }}
                                    </option>
                                @empty
                                    <option value="" data-id="">{{ 'No Countries Available' }}
                                    </option>
                                @endforelse
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select name="state_name" id="state_name">
                                <option value="">Select State</option>
                                @forelse ($states as $state)
                                    <option value="{{ $state->name }}" data-id="{{ $state->name }}">
                                        {{ !empty($state->name) ? $state->name : '' }}
                                    </option>
                                @empty
                                    <option value="" data-id="">{{ 'No State Available' }}
                                    </option>
                                @endforelse
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select name="city_name" id="city_name">
                                <option value="">Select City</option>
                                @forelse ($cities as $city)
                                    <option value="{{ $city->name }}" data-id="{{ $city->name }}">
                                        {{ !empty($city->name) ? $city->name : '' }}
                                    </option>
                                @empty
                                    <option value="" data-id="">{{ 'No City Available' }}
                                    </option>
                                @endforelse
                            </select>
                        </div>
                        <div class="col-md-6">
                            <input type="text" id="zip_code" name="zip_code" class="form-control"
                                aria-describedby="emailHelp" placeholder="Zip Code">
                        </div>
                        <div class="col-md-6">
                            <input type="text" id="full_address" name="full_address" class="form-control"
                                aria-describedby="emailHelp" placeholder="Address">
                        </div>
                        <div class="col-md-6">
                            <input type="text" id="landmark" name="landmark" class="form-control"
                                aria-describedby="emailHelp" placeholder="Landmark">
                        </div>
                    </div>
                </div>


            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="single-input">
                        <div class="form-group">
                            <label for="branch-name">Logo <span class="text-danger">*</span></label>
                            <input type="file" id="mfi_image" name="mfi_image">
                            <div id="logo" style="display: none;">

                            </div>
                        </div>
                    </div>
                </div>
            </div>


            {{--  <div class="single-input">
            <label>Select Branch Head</label>
            <select name="cars" id="cars">
                <option value="volvo">- select -</option>
                <option value="saab">Saab</option>
                <option value="mercedes">Mercedes</option>
                <option value="audi">Audi</option>
            </select>
        </div>  --}}

            <div class="btns-block no-scroll-btns">
                <button type="submit">ADD</button>
                <button type="reset">RESET</button>
            </div>
        </form>

    </div>

    <!-- add baranch form-end-->

    <!-- /.content-wrapper -->
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $("#addbranch-btn").click(function() {
                $("#slide-from-right").find('button[type="submit"]').html('Add');
                $("#slide-from-right").find('button[type="reset"]').html('Reset');
                $("#slide-from-right").find('button[type="reset"]').removeClass('reload');
                $("#logo").html("");
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
