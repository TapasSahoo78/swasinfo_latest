@php
    $code = Auth::user()->mfi->code;
@endphp
@extends('mfi.layouts.app')
@push('style')
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
@endpush
@section('pagetitlesection')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link custom-cumb">{{ __('Branch') }}</a>
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
                        <h1 class="m-0 text-dark">No of Branches: {{ $listBranch->count() }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-4">
                        @can('add-branch')
                            <button class="model-slide-btn" id="addbranch-btn">
                                <span><i class="fa fa-plus" aria-hidden="true"></i></span>
                                ADD BRANCH
                            </button>
                        @endcan
                    </div><!-- /.col -->
                </div>
                {{-- <div class="row align-items-center"> --}}

                <form action="{{ route('mfi.administrator.branch.list', ['slug' => $code]) }}" method="GET">
                    <div class="row align-items-center mt-5">
                        {{--  <h6>Advanced Search</h3> --}}

                        <div class="col-sm-4">
                            <input type="text" name="branch" id="branch" class="form-control"
                                placeholder="Search By Branch Name " value="{{ !empty($_REQUEST['branch']) ? $_REQUEST['branch'] : '' }}">
                        </div>
                        <div class="col-sm-4">
                            <input type="text" name="brcode" id="brcode" class="form-control"
                                placeholder="Search By Branch Code" value="{{ !empty($_REQUEST['brcode']) ? $_REQUEST['brcode'] : '' }}">
                        </div>

                        <div class="col-sm-2">
                            <input type="submit" value="Advance Search" class="btn btn-primary">
                        </div>
                        <div class="col-sm-2">
                            <a class="btn btn-warning btn-md" href="{{ route('mfi.administrator.branch.list', ['slug' => $code]) }}">Reset</a>
                        </div>

                    </div>
                </form>
                {{-- </div> --}}

                <!-- /.row -->
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
                            <table class="table  text-nowrap custom-data-table">
                                <thead>
                                    <tr>
                                        <th>Branch Details</th>
                                        <th>Area Of Operation</th>
                                        {{--  <th>Branch Head</th>  --}}
                                        <th>Created On</th>
                                        <th>Address</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($listBranch as $branch)
                                        <tr class="{{ $branch->status == 1 ? 'active-row' : 'inactive-row' }}">
                                            <td><b>Name : </b>{{ $branch->name }}<br>
                                                <b>Code : </b>{{ $branch->code }}<br>
                                            </td>
                                            <td>{{ !empty($branch->oprationArea) ? $branch->oprationArea->zone_name : '---' }}
                                            </td>

                                            <td>{{ date('d-m-Y', strtotime($branch->created_at)) }}</td>
                                            <td>{{ $branch->full_address }}</td>
                                            <td>
                                                @switch($branch->status)
                                                    @case(1)
                                                        <a title="{{ $branch->is_head_branch == 0 ? '' : 'HQ Branch' }}"
                                                            href="javascript:void(0)" data-value="0" data-table="branches"
                                                            data-message="inactive" data-uuid="{{ $branch->uuid }}"
                                                            class="active-status changeStatus {{ $branch->is_head_branch == 0 ? '' : 'disabled-anchortag' }}">Active</a>
                                                    @break

                                                    @case(0)
                                                        <a title="{{ $branch->is_head_branch == 0 ? '' : 'HQ Branch' }}"
                                                            href="javascript:void(0)" data-value="1"
                                                            data-uuid="{{ $branch->uuid }}" data-table="branches"
                                                            data-message="active"
                                                            class="inactive-status changeStatus {{ $branch->is_head_branch == 0 ? '' : 'disabled-anchortag' }}">Inactive</a>
                                                    @break

                                                    @default
                                                        <a href="javascript:void(0)"
                                                            class="badge badge-danger text-dark">Deleted</a>
                                                @endswitch
                                            </td>

                                            <td>

                                                <div class="dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <img src="{{ asset('assets/img/three-dot-btn.png') }}"
                                                            alt="">
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        @can('edit-branch')
                                                            <a class="dropdown-item editData" data-table="branches"
                                                                data-uuid="{{ $branch->uuid }}"
                                                                data-form-modal="slide-from-right"
                                                                href="javascript:void(0)">Edit</a>
                                                        @endcan
                                                        @can('branch-operation-area')
                                                            <a class="dropdown-item editActionAreaData"
                                                                data-table="branch_action_of_areas"
                                                                data-uuid="{{ $branch->uuid }}"
                                                                data-form-modal="action-of-work-from-right"
                                                                href="javascript:void(0)">Area Of Operation</a>
                                                        @endcan
                                                        @can('delete-branch')
                                                            @if ($branch->is_head_branch == 0)
                                                                <a class="dropdown-item deleteData" data-table="branches"
                                                                    data-uuid="{{ $branch->uuid }}"
                                                                    href="javascript:void(0)">Delete</a>
                                                            @endif
                                                        @endcan
                                                    </div>
                                                </div>

                                            </td>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No
                                                    Data Yet</td>
                                            </tr>
                                        @endforelse
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
            <h2>Branch Name <span class="close-btn"><i class="fa fa-times" aria-hidden="true"></i></span></h2>

            <form action="{{ route('mfi.administrator.branch.save', ['slug' => $code]) }}" class="formsubmit" method="post">
                <div class="row">

                    <div class="col-md-6">
                        <div class="single-input">
                            <div class="form-group">
                                <label for="branch-name">Branch Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name"
                                    aria-describedby="emailHelp" placeholder="Enter Branch Name">
                                <input type="hidden" class="form-control" id="uuid" name="uuid">
                                <input type="hidden" class="form-control" id="id" name="id">

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="single-input">
                            <div class="form-group">
                                <label for="branch-name">Branch Code <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="code" id="code"
                                    aria-describedby="emailHelp" placeholder="Enter Branch Code" minlength="1"
                                    maxlength="12">

                            </div>
                        </div>
                    </div>
                </div>

                <div class="multiple-input">
                    <div class="form-group">
                        <label>Address <span class="text-danger">*</span></label>
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
                    <div class="btns-block no-scroll-btns">
                        <button type="submit">ADD</button>
                        <button onclick="this.form.reset();" type="reset">RESET</button>
                    </div>
            </form>

        </div>

        <!-- add baranch form-end-->

        <!-- Branch Area of Work -->

        <div id="action-of-work-from-right" class="slide-from-right">
            <h2>Area Of Operation <span class="close-btn"><i class="fa fa-times" aria-hidden="true"></i></span></h2>

            <form action="{{ route('mfi.administrator.branch.action.area.update', ['slug' => $code]) }}" class="formsubmit"
                method="post">
                <div class="single-input">
                    <div class="form-group">
                        <label for="branch-name">Area / Zone Name {{--  <span class="text-danger">*</span>  --}}</label>
                        <input type="text" class="form-control" id="zone_name" name="zone_name"
                            aria-describedby="emailHelp" placeholder="Enter Zone Name">
                        <input type="hidden" class="form-control" id="branch_uuid" name="branch_uuid">
                        <input type="hidden" class="form-control" id="branch_opreation_id" name="branch_opreation_id">

                        <input type="hidden" class="form-control" id="branch_id" name="branch_id">
                    </div>
                </div>
                <div class="single-input">
                    <div class="form-group">
                        <label for="branch-name">Country Name</label>
                        <select name="country_name" id="country">
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
                </div>
                <div class="single-input">
                    <div class="form-group">
                        <label for="state-name">State Name</label>
                        <select name="states_name"  id="states_name"
                            >
                            <option value="">Select State</option>
                            <!-- <option value="">Select Country</option> -->
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
                </div>
                <div class="single-input">
                    <div class="form-group">
                        <label for="city-name">City Name</label>
                        <select name="cities_name[]" class="select2" id="cities_name" multiple
                            data-placeholder="Select State">
                            <!-- <option value="">Select City</option> -->
                            @forelse ($cities as $city)
                                <option value="{{ $city->name }}" data-id="{{ $city->name }}">
                                    {{ !empty($city->name) ? $city->name : '' }}
                                </option>
                            @empty
                                <option value="" data-id="">{{ 'No City Available' }}
                                </option>
                            @endforelse
                        </select>
                        <input type="hidden" class="form-control" id="id" name="id">
                    </div>
                </div>
                <div class="single-input">
                    <div class="form-group">
                        <label for="city-name">Zip Code</label>
                        <select name="zip_codes[]" class="select2 zip_codes" id="zip_codes" multiple="multiple" required
                            data-placeholder="Select Zipcode">
                            <!-- <option value="">Select Zipcode</option> -->
                        </select>
                    </div>
                </div>
                <div class="btns-block">
                    <button type="submit">ADD</button>
                    <button onclick="this.form.reset();">RESET</button>
                </div>
            </form>

        </div>

        <!-- /.content-wrapper -->
    @endsection
    @push('scripts')
        <script>
            $(document).ready(function() {
                $("#addbranch-btn").click(function() {
                    $("#slide-from-right").find('button[type="submit"]').html('Add');

                    $("#slide-from-right").addClass("show-side-form");
                    $('#slide-from-right').find('.formsubmit').trigger("reset");
                    $("#slide-from-right").addClass("add-form");
                    $("#slide-from-right").find('button[type="reset"]').html('Reset');
                    $("#slide-from-right").find('button[type="reset"]').removeClass('reload');
                });

                $("#close-btn").click(function() {
                    $("#slide-from-right").removeClass("show-side-form");
                });
            });
        </script>
        <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/admin/js/datatableajax.js') }}"></script>
        <script src="{{ asset('assets/admin/js/branch/area-of-operation.js') }}"></script>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(function() {

                $(document).ready(function() {
                    $('.select2').select2();
                    $(".zip_codes").select2({
                        tags: true,
                        tokenSeparators: [',', ' ']
                    });
                });



            })
        </script>
    @endpush
