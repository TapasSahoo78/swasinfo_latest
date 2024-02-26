@php
    $code = Auth::user()->mfi->code;
@endphp
@extends('mfi.layouts.app')
@push('style')
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
@endpush
@section('pagetitlesection')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link custom-cumb">{{ __('Occupation') }}</a>
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
                        <h1 class="m-0 text-dark">No of Occupations: {{ $listOccupation->count() }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-4">
                        @can('add-occupation')
                            <button class="model-slide-btn" id="addbranch-btn">
                                <span><i class="fa fa-plus" aria-hidden="true"></i></span>
                                ADD OCCUPATION
                            </button>
                        @endcan

                    </div><!-- /.col -->
                </div>
                <form action="{{ route('mfi.administrator.occupation.list', ['slug' => $code]) }}" method="GET">
                    <div class="row align-items-center mt-5">
                        {{--  <h6>Advanced Search</h3> --}}

                        <div class="col-sm-4">
                            <input type="text" name="occupation_name" id="occupation_name" class="form-control"
                                placeholder="Search By Occupation "
                                value="{{ !empty($_REQUEST['occupation_name']) ? $_REQUEST['occupation_name'] : '' }}">
                        </div>
                        <div class="col-sm-2">
                            <input type="submit" value="Advance Search" class="btn btn-primary">
                        </div>
                        <div class="col-sm-2">
                            <a class="btn btn-warning btn-md"
                                href="{{ route('mfi.administrator.occupation.list', ['slug' => $code]) }}">Reset</a>
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
                                        <th>Occupation</th>
                                        <th>Note</th>
                                        <th>Created On</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($listOccupation as $occupation)
                                        <tr class="{{ $occupation->status == 1 ? 'active-row' : 'inactive-row' }}">
                                            <td>{{ $occupation->name }}</td>
                                            <td>{{ $occupation->note }}</td>
                                            <td>{{ date('d-m-Y', strtotime($occupation->created_at)) }}</td>
                                            <td>
                                                @switch($occupation->status)
                                                    @case(1)
                                                        <a href="javascript:void(0)" data-value="0" data-table="occupations"
                                                            data-message="inactive" data-uuid="{{ $occupation->uuid }}"
                                                            class="active-status changeStatus ">Active</a>
                                                    @break

                                                    @case(0)
                                                        <a href="javascript:void(0)" data-value="1"
                                                            data-uuid="{{ $occupation->uuid }}" data-table="occupations"
                                                            data-message="active" class="inactive-status changeStatus ">Inactive</a>
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
                                                        @can('edit-occupation')
                                                            <a class="dropdown-item editData" data-table="occupations"
                                                                data-uuid="{{ $occupation->uuid }}"
                                                                data-form-modal="slide-from-right"
                                                                href="javascript:void(0)">Edit</a>
                                                        @endcan
                                                        @can('delete-occupation')
                                                            <a class="dropdown-item deleteData" data-table="occupations"
                                                                data-uuid="{{ $occupation->uuid }}"
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
            <h2>Occupation <span class="close-btn"><i class="fa fa-times" aria-hidden="true"></i></span></h2>

            <form action="{{ route('mfi.administrator.occupation.save', ['slug' => $code]) }}" class="formsubmit"
                method="post">

                <div class="single-input">
                    <div class="form-group">
                        <label for="branch-name">Occupation <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp"
                            placeholder="Enter Occupation">
                        <input type="hidden" class="form-control" id="uuid" name="uuid">
                        <input type="hidden" class="form-control" id="id" name="id">

                    </div>
                </div>

                <div class="single-input">
                    <div class="form-group">
                        <label for="branch-name">Note <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="note" id="note" aria-describedby="emailHelp"
                            placeholder="Enter Note">
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
            });
        </script>
        <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/admin/js/datatableajax.js') }}"></script>
    @endpush
