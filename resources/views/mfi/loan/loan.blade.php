@php
    $code = Auth::user()->mfi->code;
@endphp
@extends('mfi.layouts.app')
@push('style')
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link href="//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('pagetitlesection')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link custom-cumb">{{ __('Loan') }}</a>
    </li>
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">No of Loan Products: {{ $listLoan->count() }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        @can('add-loan')
                            <button class="model-slide-btn" id="addbranch-btn">
                                <span><i class="fa fa-plus" aria-hidden="true"></i></span>
                                ADD LOAN PRODUCT
                            </button>
                        @endcan

                    </div><!-- /.col -->
                </div>
                <form action="{{ route('mfi.administrator.loan.list', ['slug' => $code]) }}" method="GET">
                    <div class="row align-items-center mt-5">
                        {{--  <h6>Advanced Search</h3> --}}

                        <div class="col-sm-4">
                            <input type="text" name="loan_product_name" id="loan_product_name" class="form-control"
                                placeholder="Search By Loan Product Name "
                                value="{{ !empty($_REQUEST['loan_product_name']) ? $_REQUEST['loan_product_name'] : '' }}">
                        </div>
                        <div class="col-sm-4">
                            <input type="text" name="loan_code" id="loan_code" class="form-control"
                                placeholder="Search By Loan Code"
                                value="{{ !empty($_REQUEST['loan_code']) ? $_REQUEST['loan_code'] : '' }}">
                        </div>

                        <div class="col-sm-2">
                            <input type="submit" value="Advance Search" class="btn btn-primary">
                        </div>
                        <div class="col-sm-2">
                            <a class="btn btn-warning btn-md"
                                href="{{ route('mfi.administrator.loan.list', ['slug' => $code]) }}">Reset</a>
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
                                        <th>Loan Product</th>
                                        <th>Loan Code</th>
                                        <th>Principal Amount</th>
                                        <th>Maturity Amount</th>
                                        <th>Tenure</th>
                                        <!-- <th>No Of Kist</th> -->
                                        <th>Created On</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($listLoan as $loan)
                                        <tr>
                                            <td>{{ $loan->name }}</td>
                                            <td>{{ $loan->code }}</td>
                                            <td>{{ $loan->principal_amount }}</td>
                                            <td>{{ $loan->maturity_amount }}</td>
                                            <td>{{ $loan->tenure }}</td>
                                            <!-- <td>{{ $loan->no_of_kist }}</td> -->

                                            <td>{{ date('d-m-Y', strtotime($loan->created_at)) }}</td>
                                            <td>

                                                @switch($loan->status)
                                                    @case(1)
                                                        <a href="javascript:void(0)" data-value="0" data-table="loans"
                                                            data-message="inactive" data-uuid="{{ $loan->uuid }}"
                                                            class="active-status changeStatus ">{{ getStatusName($loan->status) }}</a>
                                                    @break

                                                    @case(0)
                                                        <a href="javascript:void(0)" data-value="1" data-uuid="{{ $loan->uuid }}"
                                                            data-table="loans" data-message="active"
                                                            class="inactive-status changeStatus">{{ getStatusName($loan->status) }}</a>
                                                    @break

                                                    @default
                                                        <a href="javascript:void(0)"
                                                            class="badge badge-danger text-dark">{{ getStatusName($loan->status) }}</a>
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
                                                        @can('edit-loan')
                                                            <a class="dropdown-item editLoanData" data-table="loans"
                                                                data-uuid="{{ $loan->uuid }}"
                                                                data-form-modal="slide-from-right"
                                                                href="javascript:void(0)">Edit</a>
                                                        @endcan
                                                        <a class="dropdown-item editLoanEmiData" data-table="loan_emis"
                                                            data-uuid="{{ $loan->uuid }}"
                                                            data-form-modal="emi-setting-right"
                                                            href="javascript:void(0)">Loan EMI</a>
                                                        @can('delete-loan')
                                                            <a class="dropdown-item deleteData" data-table="loans"
                                                                data-uuid="{{ $loan->uuid }}"
                                                                href="javascript:void(0)">Delete</a>
                                                        @endcan
                                                    </div>
                                                </div>

                                            </td>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center">No
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
            <h2>Loan Product <span class="close-btn"><i class="fa fa-times" aria-hidden="true"></i></span></h2>

            <form action="{{ route('mfi.administrator.loan.save', ['slug' => $code]) }}" id="loan-form" method="post">
                @csrf()
                <div class="row">
                    <div class="col-md-6">
                        <div class="single-input">
                            <label for="branch-name">Branch <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <select class="select2 branch_change" id="branches" name="branches[]" multiple="multiple"
                                    data-placeholder="Select Branch" style="width: 100%;">
                                    <option value="all">All</option>
                                    @foreach ($branches as $branche)
                                        <option value="{{ $branche->id }}">{{ $branche->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">

                        <div class="single-input">
                            <div class="form-group">
                                <label for="applicability">Applicability<span class="text-danger">*</span></label>
                                <select name="applicability" id="applicability" class="form-control">
                                    <option value="">--Select Applicability--</option>
                                    <option value="group-loan">
                                        Group Loan
                                    </option>
                                    <option value="individual-loan">
                                        Individual Loan
                                    </option>
                                    <option value="vehicle-loan">
                                        Vehicle Loan
                                    </option>
                                    <option value="business-loan">
                                        Business Loan
                                    </option>
                                    <option value="other-loan">
                                        Other Loan
                                    </option>

                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="single-input">
                            <div class="form-group">
                                <label for="branch-name">Loan Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name"
                                    aria-describedby="Principal Amount" placeholder="Enter Loan Name">
                                <input type="hidden" class="form-control" id="uuid" name="uuid">
                                <input type="hidden" class="form-control" id="id" name="id">
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">

                        <div class="single-input">
                            <div class="form-group">
                                <label for="branch-name">Loan Code <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="code" id="code"
                                    aria-describedby="Principal Amount" placeholder="Enter Loan Code" minlength="1"
                                    maxlength="25">
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="single-input">
                            <div class="form-group">
                                <label for="principal_amount">Principal Amount <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="principal_amount" id="principal_amount"
                                    aria-describedby="Principal Amount" placeholder="Enter Maturity Amount">
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="single-input">
                            <div class="form-group">
                                <label for="maturity_amount">Maturity Amount <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="maturity_amount" id="maturity_amount"
                                    aria-describedby="Maturity Amount" placeholder="Enter Maturity Amount">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="single-input">
                            <div class="form-group">
                                <label for="tenure">Tenure (In weeks) <span class="text-danger">*</span></label>
                                <!-- <div class="input-group mb-3"> -->
                                <input type="text" class="form-control" id="tenure" name="tenure"
                                    placeholder="Tenure" aria-label="Tenure" aria-describedby="basic-addon2">
                                <!-- <div class="input-group-append">
                                                                                                <span class="input-group-text" id="basic-addon2">In weeks</span>
                                                                                            </div> -->
                                <!-- </div> -->
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-md-6">
                                                                                <div class="single-input">
                                                                                    <div class="form-group">
                                                                                        <label for="no_of_kist">No. Of Kist <span class="text-danger">*</span></label>
                                                                                        <input type="number" class="form-control" name="no_of_kist" id="no_of_kist" aria-describedby="emailHelp" placeholder="Enter No. Of Kist">
                                                                                    </div>
                                                                                </div>

                                                                            </div> -->
                </div>
                <div class="btns-block no-scroll-btns">
                    <button type="submit">ADD</button>
                    <button type="reset">RESET</button>
                </div>
            </form>
        </div>
        <div id="emi-setting-right" class="slide-from-right no-scroll-form">
            <h2>Loan EMI <span class="close-btn"><i class="fa fa-times" aria-hidden="true"></i></span></h2>
            <h3><span id="loan_name_view"></span> : -<span id="loan_code_view"></span> (₹<span id="loan_amount_view"></span>)
            </h3>

            <form action="{{ route('mfi.administrator.loan.update.emi', ['slug' => $code]) }}" id="emi-form-submit"
                method="post">
                @csrf()
                <input type="hidden" class="form-control" id="loan_id" name="loan_id">
                <input type="hidden" class="form-control" id="emi_maturity_amount">

                <div id="append_emi_setting"></div>
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
        <script src="{{ asset('assets/mfi/js/loan/loan.js') }}"></script>


        <script src="//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(function() {

                $(document).ready(function() {
                    $('.select2').select2();
                });



            })
        </script>
    @endpush
