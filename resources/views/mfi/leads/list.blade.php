@php
    $code = Auth::user()->mfi->code;
@endphp
@extends('mfi.layouts.app')
@push('style')
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
@endpush
@section('pagetitlesection')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link custom-cumb">{{ __('Lead') }}</a>
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
                        <h1 class="m-0 text-dark">No of Leads: {{ $listLeads->count() }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-4">
                        @can('add-leads')
                            <button class="model-slide-btn" id="addbranch-btn">
                                <span><i class="fa fa-plus" aria-hidden="true"></i></span>
                                ADD LEAD
                            </button>
                        @endcan

                    </div><!-- /.col -->
                </div>
                <form action="{{ route('mfi.crm.lead.list', ['slug' => $code]) }}" method="GET">
                    <div class="row align-items-center mt-5">
                        {{--  <h6>Advanced Search</h3> --}}

                        <div class="col-sm-4">
                            <input type="text" name="lead_name" id="lead_name" class="form-control"
                                placeholder="Search By Lead Name "
                                value="{{ !empty($_REQUEST['lead_name']) ? $_REQUEST['lead_name'] : '' }}">
                        </div>
                        <div class="col-sm-4">
                            <input type="text" name="lead_email" id="lead_email" class="form-control"
                                placeholder="Search By Lead Email / Phone"
                                value="{{ !empty($_REQUEST['lead_email']) ? $_REQUEST['lead_email'] : '' }}">
                        </div>

                        <div class="col-sm-2">
                            <input type="submit" value="Advance Search" class="btn btn-primary">
                        </div>
                        <div class="col-sm-2">
                            <a class="btn btn-warning btn-md"
                                href="{{ route('mfi.crm.lead.list', ['slug' => $code]) }}">Reset</a>
                        </div>

                    </div>
                </form><!-- /.row -->
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
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Created On</th>
                                        <th>Verification Status</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($listLeads as $data)
                                        <tr>
                                            <td>{{ $data->name }}</td>
                                            <td>{{ !empty($data->email)?$data->email:'---' }}</td>
                                            <td>{{ $data->phone }}</td>
                                            {{--   <td>
                                        <div class="user-profile">
                                            <div class="img">
                                                <img src="{{asset('assets/img/user2-160x160.png')}}" alt="">
                                            </div>
                                            <p>Avijit Das</p>
                                        </div>
                                    </td>  --}}
                                            <td>{{ date('d-m-Y', strtotime($data->created_at)) }}</td>
                                            @if ($data->is_verified == 1)
                                                <td><a href="javascript:void(0)"
                                                        class="withdrawl-status updateStatus">verified</a></td>
                                            @else
                                                <td><a href="javascript:void(0)"
                                                        class="rejected-status updateStatus">unverified</a>
                                                </td>
                                            @endif
                                            <td>
                                                @switch($data->status)
                                                    @case(1)
                                                        <a href="javascript:void(0)" data-value="0" data-table="leads"
                                                            data-message="inactive" data-uuid="{{ $data->uuid }}"
                                                            class="active-status changeStatus">Active</a>
                                                    @break

                                                    @case(0)
                                                        <a href="javascript:void(0)" data-value="1" data-uuid="{{ $data->uuid }}"
                                                            data-table="leads" data-message="active"
                                                            class="inactive-status changeStatus">Inactive</a>
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
                                                        @can('edit-leads')
                                                            <a class="dropdown-item editData" data-table="leads"
                                                                data-uuid="{{ $data->uuid }}"
                                                                data-form-modal="slide-from-right"
                                                                href="javascript:void(0)">Edit</a>
                                                        @endcan
                                                        @can('verify-lead')
                                                            @if ($data->is_verified == 0)
                                                                <a class="dropdown-item viewStatus" data-table="leads"
                                                                    data-uuid="{{ $data->uuid }}"
                                                                    data-view-modal="slide-from-right-view"
                                                                    href="javascript:void(0)">Verify</a>
                                                            @endif
                                                        @endcan
                                                        <a class="dropdown-item edit-permissions"
                                                            href="{{ route('mfi.crm.lead.enquiry.list', ['slug' => $slug, 'id' => $data->id]) }}">Enquiry</a>
                                                        @if ($data->is_verified == 1)
                                                            <a class="dropdown-item saveCustomerData" data-table="leads"
                                                                data-uuid="{{ $data->uuid }}"
                                                                href="javascript:void(0)">Mark As Customer</a>
                                                        @endif
                                                        @can('delete-leads')
                                                            <a class="dropdown-item deleteData" data-table="leads"
                                                                data-uuid="{{ $data->uuid }}"
                                                                href="javascript:void(0)">Delete</a>
                                                        @endcan


                                                    </div>
                                                </div>

                                            </td>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">No
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
            <h2>Lead <span class="close-btn"><i class="fa fa-times" aria-hidden="true"></i></span></h2>

            <form action="{{ route('mfi.crm.lead.save', ['slug' => $code]) }}" class="formsubmit" method="post">
                <div class="row">
                    <div class="col-md-4">
                        <div class="single-input">
                            <div class="form-group">
                                <label for="branch-name">Branch <span class="text-danger">*</span></label>
                                <select name="branch_id" id="branch_id">
                                    <option value="">Select Branch</option>
                                    @forelse ($listBranch as $branch)
                                        <option value="{{ $branch->id }}" data-id="{{ $branch->uuid }}">
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
                    <div class="col-md-4">
                        <div class="single-input">
                            <div class="form-group">
                                <label for="enquery-name">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name"
                                    aria-describedby="emailHelp" placeholder="Enter Name">
                                <input type="hidden" class="form-control" id="uuid" name="uuid">
                                <input type="hidden" class="form-control" id="id" name="id">

                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="single-input">
                            <div class="form-group">
                                <label for="enquery-name">Email (Optional)</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    aria-describedby="emailHelp" placeholder="Enter Email">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="single-input">
                            <div class="form-group">
                                <label for="branch-name">Phone Number <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="phone" id="phone"
                                    aria-describedby="emailHelp" placeholder="Enter Phone Number">

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="single-input">
                            <div class="form-group">
                                <label for="branch-name">Aadhaar Card No. </label>
                                <input type="text" class="form-control" name="aadhaar_no" id="aadhaar_no"
                                    aria-describedby="emailHelp" placeholder="Enter Aadhaar Card No." minlength="1"
                                    maxlength="12">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="single-input">
                            <label for="agent-group">Select Group <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <select name="group_id" id="group_id">
                                    <option value="">Select Group</option>
                                    @forelse ($listGroups as $groups)
                                        <option value="{{ $groups->id }}" data-id="{{ $groups->uuid }}">
                                            {{ !empty($groups->code) ? $groups->code : '' }}
                                        </option>
                                    @empty
                                        <option value="" data-id="">{{ 'No Groups Available' }}
                                        </option>
                                    @endforelse
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="agent-group">Select Agent <span class="text-danger">*</span></label>
                            <select name="agent_id" id="agent_id">
                                <option value="">Select Agent</option>
                                @forelse ($agents as $agent)
                                    <option value="{{ $agent->id }}">{{ $agent->full_name }}</option>
                                @empty
                                    <option value="" data-id="">{{ 'No Agents Available' }}
                                    </option>
                                @endforelse
                            </select>
                        </div>
                    </div>
                </div>
                <div class="multiple-input">

                    <div class="form-group">
                        <label>Address </label>
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
                                <input type="text" id="address" name="address" class="form-control"
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
                    <div class="col-md-12">
                        <div class="single-input">
                            <div class="form-group">
                                <label for="agent-group">Note (Optional)</label>
                                <textarea rows="5" cols="30" class="form-control" name="note" id="note"></textarea>
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



        <div id="slide-from-right-view" class="slide-from-right">
            <h2>Enquiry Notes <span class="close-btn_view"><i class="fa fa-times" aria-hidden="true"></i></span></h2>

            <form action="{{ route('mfi.crm.lead.verify.lead', ['slug' => $code]) }}" class="formsubmit" method="post">

                <div class="single-input">
                    <div class="form-group">
                        <label for="branch-name">Is Verified <span class="text-danger">*</span></label>

                        <div class="isvarified-new">
                            <label>
                                <input type="radio" name="is_verified" value="1">Yes
                            </label>
                            <label>
                                <input type="radio" name="is_verified" value="0" checked="checked">No
                            </label>
                        </div>

                        <input type="hidden" class="form-control" id="lead_id" name="lead_id">
                    </div>
                </div>

                <div class="single-input">
                    <div class="form-group">
                        <label for="enquery-name">Notes <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="verified_note" name="verified_note"
                            aria-describedby="emailHelp" placeholder="Notes">

                    </div>
                </div>


                <div class="btns-block no-scroll-btns">
                    <button type="submit">Update</button>
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
                    $('#slide-from-right').find('button[type="submit"]').removeAttr('disabled');
                    // $("#" + formModal).find('button[type="reset"]').show();
                });

                $("#close-btn").click(function() {
                    $("#slide-from-right").removeClass("show-side-form");
                });
                $(".saveCustomerData").click(function() {
                    Swal.fire({
                        title: 'Are you sure want to save this lead as customer?',
                        icon: 'info',
                        confirmButtonText: 'Yes',
                        cancelButtonText: "No, cancel it!",
                    }).then((result) => {
                        if (result['isConfirmed']) {
                            // Put your function here

                            let lead_uuid = $(this).data('uuid');
                            let redirectUrl =
                                "{{ route('mfi.customer.list', ['slug' => $code]) }}?lead_uuid=" +
                                lead_uuid;
                            $(location).attr('href', redirectUrl);
                        }
                    });

                });
            });
        </script>

        <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/admin/js/datatableajax.js') }}"></script>
    @endpush
