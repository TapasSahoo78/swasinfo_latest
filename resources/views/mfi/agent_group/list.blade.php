@php
    $code = auth()->user()->mfi->code;
@endphp
@extends('mfi.layouts.app')
@push('style')
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link href="//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush


@section('pagetitlesection')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link custom-cumb">{{ __('Group') }}</a>
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
                        <h1 class="m-0 text-dark">No of Group: {{ $listGroups->count() }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-4">
                        @can('add-group')
                            <button class="model-slide-btn" id="addbranch-btn">
                                <span><i class="fa fa-plus" aria-hidden="true"></i></span>
                                ADD Group
                            </button>
                        @endcan

                    </div><!-- /.col -->
                </div>
               {{--  <form action="{{ route('mfi.group.list', ['slug' => $code]) }}" method="GET">
                    <div class="row align-items-center mt-5">

                        <div class="col-sm-4">
                            <select name="leader_id" id="leader_id" class="form-control">
                                <option value="">Select Leader</option>
                                @forelse ($leaders as $leader)
                                    <option value="{{ $leader->id }}"@if (!empty($_REQUEST['leader_id']) && $_REQUEST['leader_id'] == $leader->id) selected @endif>{{ $leader->full_name }}</option>
                                @empty
                                    <option value="" data-id="">{{ 'No Leaders Available' }}
                                    </option>
                                @endforelse
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <input type="text" name="gcode" id="gcode" class="form-control"
                                placeholder="Search By Group Code"
                                value="{{ !empty($_REQUEST['gcode']) ? $_REQUEST['gcode'] : '' }}">
                        </div>

                        <div class="col-sm-2">
                            <input type="submit" value="Advance Search" class="btn btn-primary">
                        </div>
                        <div class="col-sm-2">
                            <a class="btn btn-warning btn-md"
                                href="{{ route('mfi.group.list', ['slug' => $code]) }}">Reset</a>
                        </div>

                    </div>
                </form> --}}<!-- /.row -->
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
                                        <th>Group Code</th>
                                        <th>Leader</th>
                                        <th>Created On</th>
                                        <th>Address</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($listGroups as $group)
                                        <tr>
                                            <td>{{ $group->code }} </td>
                                            <td>{{ !empty($group->user) ? $group->user->full_name : '---' }}</td>

                                            <td>{{ date('d-m-Y', strtotime($group->created_at)) }}</td>
                                            <td>{{ $group->full_address }}</td>
                                            <td>
                                                @switch($group->status)
                                                    @case(1)
                                                        <a href="javascript:void(0)" data-value="0" data-table="groups"
                                                            data-message="inactive" data-uuid="{{ $group->uuid }}"
                                                            class="active-status changeStatus">Active</a>
                                                    @break

                                                    @case(0)
                                                        <a href="javascript:void(0)" data-value="1" data-uuid="{{ $group->uuid }}"
                                                            data-table="groups" data-message="active"
                                                            class="inactive-status changeStatus ">Inactive</a>
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
                                                        @can('edit-group')
                                                            <a class="dropdown-item editGroupData" data-table="groups"
                                                                data-uuid="{{ $group->uuid }}"
                                                                data-form-modal="slide-from-right"
                                                                href="javascript:void(0)">Edit</a>
                                                        @endcan
                                                        @can('delete-group')
                                                            <a class="dropdown-item deleteData" data-table="groups"
                                                                data-uuid="{{ $group->uuid }}"
                                                                href="javascript:void(0)">Delete</a>
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

        <div id="slide-from-right" class="slide-from-right">
            <h2>Group <span class="close-btn"><i class="fa fa-times" aria-hidden="true"></i></span></h2>

            <form action="{{ route('mfi.group.add', ['slug' => $code]) }}" class="formsubmit" method="post">
                @csrf()
                <div class="single-input">
                    <div class="form-group">
                        <label for="branch-name">Branch<span class="text-danger">*</span></label>
                        <select name="branch_id" id="branch_id">
                            <option value="">Select Branch</option>
                            @forelse ($listBranch as $branch)
                                <option value="{{ $branch->id }}" data-id="{{ $branch->id }}">
                                    {{ !empty($branch->name) ? $branch->name : '' }}
                                </option>
                            @empty
                                <option value="" data-id="">{{ 'No Branches Available' }}
                                </option>
                            @endforelse
                        </select>
                    </div>
                </div>
                <div class="single-input">
                    <div class="form-group">
                        <label for="agent-group">Group Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="code" name="code"
                            aria-describedby="emailHelp" placeholder="Enter Group Code">
                        <input type="hidden" class="form-control" id="uuid" name="uuid">
                        <input type="hidden" class="form-control" id="id" name="id">
                    </div>
                </div>
                {{-- <div class="single-input">
                    <div class="form-group">
                        <label for="agent-group">Frequency <span class="text-danger">*</span></label>
                        <select name="frequency" id="frequency">
                            <option value="">Select</option>
                            <option value="Weekly">
                                Weekly
                            </option>
                            <option value="Biweekly">
                                Biweekly
                            </option>
                            <option value="Monthly">
                                Monthly
                            </option>
                        </select>
                    </div>
                </div> --}}
                <div class="form-group">
                    <label for="agent-group">Select Leader <span class="text-danger">*</span></label>
                    <select name="leader_user_id" id="leader_user_id">
                        <option value="">Select Leader</option>
                        @forelse ($leaders as $leader)
                            <option value="{{ $leader->id }}">{{ $leader->full_name }}</option>
                        @empty
                            <option value="" data-id="">{{ 'No Leaders Available' }}
                            </option>
                        @endforelse
                    </select>
                </div>
                {{-- <div class="single-input">
                    <label for="agent-group">Recovery Day <span class="text-danger">*</span></label>
                    <div class="form-group">
                        <select class="select2 branch_change" name="days[]" id="days" multiple="multiple"
                            data-placeholder="Select Agent Days" style="width: 100%;">
                            <option value="">Select Days</option>
                            @forelse ($days as $day)
                                <option value="{{ $day }}">{{ $day }}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                </div> --}}

                <div class="form-group">
                    <label for="agent-group">Select Agent <span class="text-danger">*</span></label>
                    <select name="user_id[]" id="user_id" class="select2 branch_change" multiple="multiple" data-placeholder="Select Agent " style="width: 100%;">
                        <option value="">Select Agent</option>
                        @forelse ($agents as $agent)
                            <option value="{{ $agent->id }}">{{ $agent->full_name }}</option>
                        @empty
                            <option value="" data-id="">{{ 'No Agents Available' }}
                            </option>
                        @endforelse
                    </select>
                </div>
                <div class="form-group">
                    <label for="agent-group">Country <span class="text-danger">*</span></label>
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
                <div class="form-group">
                    <label for="agent-group">State <span class="text-danger">*</span></label>
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
                <div class="form-group">
                    <label for="agent-group">City <span class="text-danger">*</span></label>
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
                <div class="single-input">
                    <div class="form-group">
                        <label for="agent-group">Zip Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="zip_code" name="zip_code"
                            aria-describedby="emailHelp" placeholder="Enter Zip Code">
                    </div>
                </div>
                <div class="form-group">
                    <label for="agent-group">Full Address <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="full_address" name="full_address"
                        aria-describedby="emailHelp" placeholder="Enter Full Address">
                </div>
                <div class="form-group">
                    <label for="agent-group">Landmark </label>
                    <input type="text" class="form-control" id="landmark" name="landmark" aria-describedby="emailHelp"
                        placeholder="Enter A Landmark">
                </div>

                <div class="single-input">
                    <div class="form-group">
                        <label for="agent-group">Remarks</label>
                        <textarea rows="5" cols="30" class="form-control" name="remarks" id="remarks"></textarea>
                    </div>
                </div>

                <div class="btns-block">
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

                    $("#slide-from-right").addClass("show-side-form");
                    $('#slide-from-right').find('.formsubmit').trigger("reset");
                    $("#slide-from-right").addClass("add-form");
                    $("#slide-from-right").find('button[type="reset"]').html('Reset');
                    $("#slide-from-right").find('button[type="reset"]').removeClass('reload');
                });

                $("#close-btn").click(function() {
                    $("#slide-from-right").removeClass("show-side-form");
                });
                $('#days').select2();
                $('#user_id').select2();
            });
        </script>
        <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/admin/js/datatableajax.js') }}"></script>
        <script src="{{ asset('assets/admin/js/group/group.js') }}"></script>
        <script src="//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @endpush
