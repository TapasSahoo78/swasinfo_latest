@php
    $code = Auth::user()->mfi->code;
@endphp
@extends('mfi.layouts.app')
@push('style')
    {{--  <link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">  --}}
    {{--  <link href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css" rel="stylesheet">  --}}
@endpush
@section('pagetitlesection')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link custom-cumb">{{ __('Enquiry') }}</a>
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
                        <h1 class="m-0 text-dark">No of Enquiry: {{ $listEnquiries->count() }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-4">
                        @can('add-enquiries')
                            <button class="model-slide-btn" id="addbranch-btn">
                                <span><i class="fa fa-plus" aria-hidden="true"></i></span>
                                ADD ENQUIRY
                            </button>
                        @endcan
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
                            <table class="table  text-nowrap custom-data-table" id="enquiryTable">
                                <thead>
                                    <tr>
                                        <th>Lead Details</th>
                                        <th>Message</th>
                                        <th>Min Amount</th>
                                        <th>Max Amount</th>
                                        <th>Created On</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($listEnquiries as $data)
                                        <tr>
                                            <td><b>Name : </b>{{ $data->lead?->name }}<br>
                                                <b>Phone : </b>{{ $data->lead?->phone }}<br>
                                                <b>Email : </b>{{ $data->lead?->email }}
                                            </td>
                                            <td>{{ $data->message }}</td>
                                            <td>{{ $data->min_amount }}</td>
                                            <td>{{ $data->max_amount }}</td>
                                            {{--   <td>
                                        <div class="user-profile">
                                            <div class="img">
                                                <img src="{{asset('assets/img/user2-160x160.png')}}" alt="">
                                            </div>
                                            <p>Avijit Das</p>
                                        </div>
                                    </td>  --}}
                                            <td>{{ date('d-m-Y', strtotime($data->created_at)) }}</td>

                                            @if ($data->status == 1)
                                                <td><a href="javascript:void(0)"
                                                        class="withdrawl-status updateStatus">Open</a></td>
                                            @elseif($data->status == 2)
                                                <td><a href="javascript:void(0)"
                                                        class="approved-status updateStatus">Assigned</a></td>
                                            @elseif($data->status == 3)
                                                <td><a href="javascript:void(0)"
                                                        class="process-status updateStatus">In-Process</a></td>
                                            @elseif($data->status == 4)
                                                <td><a href="javascript:void(0)"
                                                        class="hold-status updateStatus">On-Hold</a></td>
                                            @elseif($data->status == 5)
                                                <td><a href="javascript:void(0)"
                                                        class="pending-status updateStatus">Closed</a></td>
                                            @else
                                                <td><a href="javascript:void(0)"
                                                        class="rejected-status updateStatus">Cancelled</a></td>
                                            @endif
                                            {{--  <td>
                                                @switch($data->status)
                                                    @case(1)
                                                        <a href="javascript:void(0)" data-value="0" data-table="enquiries"
                                                            data-message="inactive" data-uuid="{{ $data->uuid }}"
                                                            class="badge badge-success text-dark changeStatus {{ $data->is_head_branch == 0 ? '' : 'disabled-anchortag' }}">Active</a>
                                                    @break

                                                    @case(0)
                                                        <a href="javascript:void(0)" data-value="1" data-uuid="{{ $data->uuid }}"
                                                            data-table="enquiries" data-message="active"
                                                            class="badge badge-danger text-dark changeStatus {{ $data->is_head_branch == 0 ? '' : 'disabled-anchortag' }}">Inactive</a>
                                                    @break

                                                    @default
                                                        <a href="javascript:void(0)"
                                                            class="badge badge-danger text-dark">Deleted</a>
                                                @endswitch
                                            </td>  --}}

                                            <td>

                                                <div class="dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <img src="{{ asset('assets/img/three-dot-btn.png') }}"
                                                            alt="">
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        @can('edit-enquiries')
                                                            <a class="dropdown-item editData" data-table="enquiries"
                                                                data-uuid="{{ $data->uuid }}"
                                                                data-form-modal="slide-from-right"
                                                                href="javascript:void(0)">Edit</a>
                                                        @endcan
                                                        @can('change-enquiry-status')
                                                            <a class="dropdown-item viewStatus" data-table="enquiries"
                                                                data-uuid="{{ $data->uuid }}"
                                                                data-view-modal="slide-from-right-view"
                                                                href="javascript:void(0)">View Status</a>
                                                        @endcan
                                                        @can('delete-enquiries')
                                                            <a class="dropdown-item deleteData" data-table="enquiries"
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

    <div id="slide-from-right" class="slide-from-right">
        <h2>Enquiry <span class="close-btn"><i class="fa fa-times" aria-hidden="true"></i></span></h2>

        <form action="{{ route('mfi.crm.enquiry.save', ['slug' => $code]) }}" class="formsubmit" method="post">
            <input type="hidden" class="form-control" id="uuid" name="uuid">
            <input type="hidden" class="form-control" id="id" name="id">
            <div class="single-input">
                <div class="form-group">
                    <label for="branch-name">Lead <span class="text-danger">*</span></label>
                    <select name="lead_id" id="lead_id">
                        <option value="">Select Lead</option>
                        @forelse ($listLeads as $leads)
                            <option value="{{ $leads->uuid }}" data-id="{{ $leads->uuid }}">
                                {{ !empty($leads->name) ? $leads->name : '' }}
                            </option>
                        @empty
                            <option value="" data-id="">{{ 'No Leads Available' }}
                            </option>
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="single-input">
                <div class="form-group">
                    <label for="branch-name">Loan Product <span class="text-danger">*</span></label>
                    <select name="loan_id" id="loan_id">
                        <option value="">Select Loan Product</option>
                        @forelse ($listLoans as $loans)
                            <option value="{{ $loans->uuid }}" data-id="{{ $loans->uuid }}">
                                {{ !empty($loans->name) ? $loans->name : '' }}
                            </option>
                        @empty
                            <option value="" data-id="">{{ 'No Loans Available' }}
                            </option>
                        @endforelse
                    </select>
                </div>
            </div>

            <div class="single-input">
                <div class="form-group">
                    <label for="enquery-name">Min Amount <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="min_amount" name="min_amount"
                        aria-describedby="emailHelp" placeholder="Enter Min Amount">

                </div>
            </div>
            <div class="single-input">
                <div class="form-group">
                    <label for="enquery-name">Max Amount <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="max_amount" name="max_amount"
                        aria-describedby="emailHelp" placeholder="Enter Max Amount">

                </div>
            </div>
            <div class="single-input">
                <div class="form-group">
                    <label for="enquery-name">Message <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="message" name="message"
                        aria-describedby="emailHelp" placeholder="Enter Message Here">

                </div>
            </div>

            <div class="btns-block">
                <button type="submit">ADD</button>
                <button type="reset">RESET</button>
            </div>
        </form>

    </div>
    <div id="slide-from-right-view" class="slide-from-right">
        <h2>Enquiry Notes <span class="close-btn_view"><i class="fa fa-times" aria-hidden="true"></i></span></h2>

        <form action="{{ route('mfi.crm.enquiry.update.status', ['slug' => $code]) }}" class="formsubmit"
            method="post">

            <div class="single-input">
                <div class="form-group">
                    <label for="branch-name">Enquiry Status <span class="text-danger">*</span></label>
                    <select name="status" id="status">
                        <option value="">Select Status</option>
                        <option value="1">Open</option>
                        <option value="2">
                            Assigned
                        </option>
                        <option value="3">
                            In-Process
                        </option>
                        <option value="4">
                            On-Hold
                        </option>
                        <option value="5">
                            Closed
                        </option>
                        <option value="0">
                            Cancelled
                        </option>
                    </select>
                    <input type="hidden" class="form-control" id="enquiry_id" name="enquiry_id">

                </div>
            </div>

            <div class="single-input">
                <div class="form-group">
                    <label for="enquery-name">Notes <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="notes" name="notes"
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
                $("#slide-from-right").addClass("add-form");
                $("#slide-from-right").find('button[type="reset"]').html('Reset');
                $("#slide-from-right").find('button[type="reset"]').removeClass('reload');
            });

             $(".close-btn_view").click(function() {
                $("#slide-from-right-view").removeClass("show-side-form");
            });

            // $("#close-btn").click(function() {
            //     $("#slide-from-right").removeClass("show-side-form");
            // });

        });
        $(document).ready(function() {
            loadData();
        })
        const loadData = () => {
            //   $('#bannerTable').DataTable().destroy();
            var dataTable = $('#enquiryTable').DataTable({
                processing: true,
                serverSide: false,
                autoWidth: false,
                responsive: true,
                searching: false,


            });
        }
    </script>
    {{--  <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>  --}}
    <script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
    {{--  <script src="{{ asset('assets/admin/js/datatableajax.js') }}"></script>  --}}
    {{--  <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>  --}}
@endpush
