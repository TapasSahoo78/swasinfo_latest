@php
    $code = Auth::user()->mfi->code;
@endphp
@extends('mfi.layouts.app')
@push('style')
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
@endpush
@section('pagetitlesection')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link custom-cumb">{{ __('User') }}</a>
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
                        <h1 class="m-0 text-dark">No of Users: {{ $listUsers->count() }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-4">
                        @can('add-user')
                            <button class="model-slide-btn" id="addbranch-btn">
                                <span><i class="fa fa-plus" aria-hidden="true"></i></span>
                                ADD USER
                            </button>
                        @endcan
                    </div><!-- /.col -->
                </div>
                <form action="{{ route('mfi.administrator.user.list', ['slug' => $code]) }}" method="GET">
                    <div class="row align-items-center mt-5">
                        {{--  <h6>Advanced Search</h3> --}}

                        <div class="col-sm-4">
                            {{-- <input type="text" name="name" id="name" class="form-control"
                                placeholder="Search By Branch Name "
                                value="{{ !empty($_REQUEST['name']) ? $_REQUEST['name'] : '' }}"> --}}
                            <select name="branch" id="branch" class="form-control">
                                <option value="0">Select Branch</option>
                                @forelse ($listBranch as $branch)
                                    <option value="{{ $branch->id }}"@if (!empty($_REQUEST['branch']) && $_REQUEST['branch'] == $branch->id) selected @endif
                                        data-id="{{ $branch->id }}">
                                        {{ !empty($branch->name) ? $branch->name : '' }}
                                    </option>
                                @empty
                                    <option value="" data-id="">{{ 'No Branches Available' }}
                                    </option>
                                @endforelse
                            </select>

                        </div>

                        <div class="col-sm-4">
                            <input type="text" name="first_name" id="first_name" class="form-control"
                                placeholder="Search By User Name"
                                value="{{ !empty($_REQUEST['first_name']) ? $_REQUEST['first_name'] : '' }}">

                        </div>

                        <div class="col-sm-2">
                            <input type="submit" value="Advance Search" class="btn btn-primary">
                        </div>

                        <div class="col-sm-2">
                            <a class="btn btn-warning btn-md"
                                href="{{ route('mfi.administrator.user.list', ['slug' => $code]) }}">Reset</a>
                        </div>

                    </div>
                </form>
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
                                        <th>Name</th>
                                        <th>Branch</th>
                                        <th>Role</th>
                                        {{-- <th>Email</th> --}}
                                        <th>Phone</th>
                                        <th>Login Id</th>
                                        <th>Address</th>
                                        <th>Created On</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($listUsers as $users)
                                        {{--  @dd($users->address)  --}}
                                        <tr>
                                            <td>{{ $users->first_name }}</td>
                                            <td>{{ $users->branches?->first()->name }}</td>
                                            <td>{{ $users->roles?->first()->name }}</td>
                                            <td>{{ $users->mobile_number }}</td>
                                            <td>{{ $users->login_id }}</td>
                                            <td>{{ $users->address?->full_address }}</td>
                                            <td>{{ date('d-m-Y', strtotime($users->created_at)) }}</td>
                                            {{--  <td>{{ $branch->full_address }}</td>  --}}
                                            <td>
                                                @switch($users->is_active)
                                                    @case(1)
                                                        <a href="javascript:void(0)" data-value="0" data-table="users"
                                                            data-message="inactive" data-uuid="{{ $users->uuid }}"
                                                            class="active-status text-success changeUserStatus {{ $users->id === auth()->user()->id ? 'disabled-anchortag' : '' }} ">Active</a>
                                                    @break

                                                    @case(0)
                                                        <a href="javascript:void(0)" data-value="1" data-uuid="{{ $users->uuid }}"
                                                            data-table="users" data-message="active"
                                                            class="inactive-status changeUserStatus {{ $users->id === auth()->user()->id ? 'disabled-anchortag' : '' }} ">Inactive</a>
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
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"
                                                        style="{{ checkIsHeadBranch() && $users->id === auth()->user()->id ? 'display:none' : 'display:show;' }}">
                                                        @can('edit-user')
                                                            @if (checkIsHeadBranch())
                                                                @if ($users->id != auth()->user()->id)
                                                                    <a class="dropdown-item editData" data-table="users"
                                                                        data-uuid="{{ $users->uuid }}"
                                                                        data-form-modal="slide-from-right"
                                                                        href="javascript:void(0)">Edit</a>
                                                                @endif
                                                            @else
                                                                <a class="dropdown-item editData" data-table="users"
                                                                    data-uuid="{{ $users->uuid }}"
                                                                    data-form-modal="slide-from-right"
                                                                    href="javascript:void(0)">Edit</a>
                                                            @endif
                                                        @endcan
                                                        <a class="dropdown-item edit-permissions"
                                                            href="{{ route('mfi.administrator.user.attach.user.permission', ['slug' => $slug, 'id' => $users->id]) }}">Permissions</a>
                                                        @can('delete-user')
                                                            @if (checkIsHeadBranch())
                                                                @if ($users->id == auth()->user()->id)
                                                                    <a class="dropdown-item deleteData" data-table="users"
                                                                        data-uuid="{{ $users->uuid }}"
                                                                        href="javascript:void(0)"
                                                                        style="display: none;">Delete</a>
                                                                @else
                                                                    <a class="dropdown-item deleteData" data-table="users"
                                                                        data-uuid="{{ $users->uuid }}"
                                                                        href="javascript:void(0)">Delete</a>
                                                                @endif
                                                            @endif
                                                        @endcan

                                                    </div>
                                                </div>

                                            </td>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center">No
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
            <h2>User <span class="close-btn"><i class="fa fa-times" aria-hidden="true"></i></span></h2>

            <form action="{{ route('mfi.administrator.user.save', ['slug' => $code]) }}" class="formsubmit" method="post">
                <div class="row">

                    <div class="col-md-6">

                        <div class="single-input">
                            <div class="form-group">
                                <label for="branch-name">Branch<span class="text-danger">*</span></label>
                                <select name="branch_id" id="branch_id">
                                    <option value="0">Select Branch</option>
                                    @forelse ($listBranch as $branch)
                                        <option value="{{ $branch->uuid }}" data-id="{{ $branch->uuid }}">
                                            {{ !empty($branch->name) ? $branch->name : '' }}
                                        </option>
                                    @empty
                                        <option value="" data-id="">{{ 'No Branches Available' }}
                                        </option>
                                    @endforelse
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">

                        <div class="single-input">
                            <div class="form-group">
                                <label for="branch-name">Role<span class="text-danger">*</span></label>
                                <select name="role_id" id="role_id">
                                    <option value="">Select role</option>
                                    @forelse ($mfiRoles as $role)
                                        <option value="{{ $role->uuid }}" data-id="{{ $role->uuid }}">
                                            {{ !empty($role->name) ? $role->name : '' }}
                                        </option>
                                    @empty
                                        <option value="" data-id="">{{ 'No Roles Available' }}
                                        </option>
                                    @endforelse
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div class="single-input">
                            <div class="form-group">
                                <label for="branch-name">Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name"
                                    aria-describedby="emailHelp" placeholder="Enter Name">
                                <input type="hidden" class="form-control" id="uuid" name="uuid">
                                <input type="hidden" class="form-control" id="id" name="id">
                            </div>
                        </div>

                    </div>

                    <div class="col-md-6">
                        <div class="single-input">
                            <div class="form-group">
                                <label for="branch-name">Email<span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email"
                                    aria-describedby="emailHelp" placeholder="Enter Email">

                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="single-input">
                            <div class="form-group">
                                <label for="branch-name">Phone<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="phone" name="phone"
                                    aria-describedby="emailHelp" placeholder="Enter Phone" max="10">
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



                <div class="multiple-input">
                    <div class="form-group">
                        <label>Address<span class="text-danger">*</span></label>
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
    @endpush
