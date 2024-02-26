@php
    $code = Auth::user()->mfi->code;
@endphp
@extends('mfi.layouts.app')
@push('style')
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" />
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
                        <h1 class="m-0 text-dark">No of Purposes: {{ $listPurpose->count() }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-4">
                        @can('add-purpose')
                            <button class="model-slide-btn" id="addbranch-btn">
                                <span><i class="fa fa-plus" aria-hidden="true"></i></span>
                                ADD Purpose
                            </button>
                        @endcan
                    </div><!-- /.col -->
                </div>
                 <form action="{{ route('mfi.administrator.purpose.list', ['slug' => $code]) }}" method="GET">
                    <div class="row align-items-center mt-5">
                        {{--  <h6>Advanced Search</h3> --}}

                        <div class="col-sm-4">
                            <input type="text" name="purpose_name" id="purpose_name" class="form-control"
                                placeholder="Search By Purpose "
                                value="{{ !empty($_REQUEST['purpose_name']) ? $_REQUEST['purpose_name'] : '' }}">
                        </div>
                        <div class="col-sm-2">
                            <input type="submit" value="Advance Search" class="btn btn-primary">
                        </div>
                        <div class="col-sm-2">
                            <a class="btn btn-warning btn-md"
                                href="{{ route('mfi.administrator.purpose.list', ['slug' => $code]) }}">Reset</a>
                        </div>
                        <div class="col-sm-4">
                            {{-- <input type="text" name="lead_email" id="lead_email" class="form-control"
                                placeholder="Search By Lead Email / Phone"
                                value="{{ !empty($_REQUEST['lead_email']) ? $_REQUEST['lead_email'] : '' }}"> --}}
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
                                        <th>Purpose</th>
                                        <th>Note</th>
                                        <th>Created On</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($listPurpose as $purpose)
                                        <tr class="{{ $purpose->status == 1 ? 'active-row' : 'inactive-row' }}">
                                            <td>{{ $purpose->name }}</td>
                                            <td>{{ $purpose->note }}</td>
                                            <td>{{ date('d-m-Y', strtotime($purpose->created_at)) }}</td>
                                            <td>
                                                @switch($purpose->status)
                                                    @case(1)
                                                        <a href="javascript:void(0)" data-value="0" data-table="purposes"
                                                            data-message="inactive" data-uuid="{{ $purpose->uuid }}"
                                                            class="active-status changeUserStatus ">Active</a>
                                                    @break

                                                    @case(0)
                                                        <a href="javascript:void(0)" data-value="1" data-uuid="{{ $purpose->uuid }}"
                                                            data-table="purposes" data-message="active"
                                                            class="inactive-status changeUserStatus ">Inactive</a>
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
                                                        @can('edit-purpose')
                                                            <a class="dropdown-item editData" data-table="purposes"
                                                                data-uuid="{{ $purpose->uuid }}"
                                                                data-form-modal="slide-from-right"
                                                                href="javascript:void(0)">Edit</a>
                                                        @endcan
                                                        @can('delete-purpose')
                                                            <a class="dropdown-item deleteData" data-table="purposes"
                                                                data-uuid="{{ $purpose->uuid }}"
                                                                href="javascript:void(0)">Delete</a>
                                                        @endcan

                                                    </div>
                                                </div>

                                            </td>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No
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
            <h2>Purpose <span class="close-btn"><i class="fa fa-times" aria-hidden="true"></i></span></h2>

            <form action="{{ route('mfi.administrator.purpose.save', ['slug' => $code]) }}" class="formsubmit" method="post">

                {{--  <div class="single-input">
                <div class="form-group">
                    <label for="branch-name">Branch</label>
                    <select name="branch_id[]" id="branch_id"  multiple="multiple">
                        <option value="0">Select Branch</option>
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
            </div>  --}}
                {{--  <div class="single-input">
                <div class="form-group">
                    <label for="branch-name">Loan Type</label>
                    <select name="lone_type_id" id="lone_type_id" class="form-control">
                        <option value="0">Select Loan type</option>
                        @forelse ($listLoan as $loan)
                            <option value="{{ $loan->uuid }}" data-id="{{ $loan->uuid }}">
                                {{ !empty($loan->name) ? $loan->name : '' }}
                            </option>
                        @empty
                            <option value="" data-id="">{{ 'No Loan Types Available' }}
                            </option>
                        @endforelse
                    </select>
                </div>
            </div>  --}}

                <div class="single-input">
                    <div class="form-group">
                        <label for="branch-name">Purpose Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp"
                            placeholder="Enter Purpose Name">
                        <input type="hidden" class="form-control" id="uuid" name="uuid">
                        <input type="hidden" class="form-control" id="id" name="id">

                    </div>
                </div>

                <div class="single-input">
                    <div class="form-group">
                        <label for="branch-name">Purpose Note <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="note" name="note" aria-describedby="emailHelp"
                            placeholder="Enter Purpose note">
                    </div>
                </div>
                {{--  <div class="single-input">
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" value="0" name="is_repayment" id="is_repayment">Repayment Available
                    </label>
                </div>
            </div>  --}}

                {{--  <select name="cars" id="cars">
                    <option value="volvo">City</option>
                    <option value="saab">Saab</option>
                    <option value="mercedes">Mercedes</option>
                    <option value="audi">Audi</option>
                </select>

                <select name="cars" id="cars">
                    <option value="volvo">State</option>
                    <option value="saab">Saab</option>
                    <option value="mercedes">Mercedes</option>
                    <option value="audi">Audi</option>
                </select>
            </div>

            <div class="single-input">
                <label>Select Branch Head</label>
                <select name="cars" id="cars">
                    <option value="volvo">- select -</option>
                    <option value="saab">Saab</option>
                    <option value="mercedes">Mercedes</option>
                    <option value="audi">Audi</option>
                </select>
            </div>  --}}

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
                $('#branch_id').select2();
            });
        </script>
        <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/admin/js/datatableajax.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"
            integrity="sha512-RtZU3AyMVArmHLiW0suEZ9McadTdegwbgtiQl5Qqo9kunkVg1ofwueXD8/8wv3Af8jkME3DDe3yLfR8HSJfT2g=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        {{--  <script type="text/javascript">
    </script>  --}}
    @endpush
