@php
    $code = auth()->user()->mfi->code;
@endphp
@extends('mfi.layouts.app')
@push('style')
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css"> --}}

    <style>
        @import url("https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap");

        :root {
            --primary: #333;
            --secondary: #333;
            --errorColor: red;
            --stepNumber: 6;
            --container-customWidth: 600px;
            --bgColor: #333;
            --inputBorderColor: lightgray;
        }


        ::selection {
            color: #fff;
            background: var(--primary);
        }

        .container-custom {
            background: #fff;
            text-align: center;
            border-radius: 5px;
        }

        .container-custom header {
            font-size: 35px;
            font-weight: 600;
            margin: 0 0 30px 0;
        }

        .container-custom .form-outer {
            width: 100%;
            overflow: hidden;
        }

        .container-custom .form-outer form {
            display: flex;
            width: calc(100% * var(--stepNumber));
        }

        .form-outer form .page {
            width: calc(100% / var(--stepNumber));
            transition: margin-left 0.3s ease-in-out;
        }

        form .page .field button {
            width: 100%;
            height: calc(100% + 5px);
            border: none;
            background: var(--secondary);
            margin-top: -20px;
            border-radius: 5px;
            color: #fff;
            cursor: pointer;
            font-size: 18px;
            font-weight: 500;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: 0.5s ease;
        }

        form .page .field button {
            width: 100%;
            height: calc(100% + 5px);
            border: none;
            background: #f9d95c;
            margin-top: -20px;
            border-radius: 5px;
            color: #fff;
            cursor: pointer;
            font-size: 18px;
            font-weight: 500;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: 0.5s ease;
            color: #000;
            font-weight: 500;
        }

        form .page .btns button {
            margin-top: -20px !important;
        }

        form .page .btns button.prev {
            margin-right: 3px;
            font-size: 17px;
        }

        form .page .btns button.next {
            margin-left: 3px;
        }

        .container-custom .steps-progress-bar {
            display: flex;
            margin: 40px 0;
            user-select: none;
        }

        .container-custom .steps-progress-bar .step {
            text-align: center;
            width: 100%;
            position: relative;
        }

        .container-custom .steps-progress-bar .step p {
            font-weight: 500;
            font-size: 18px;
            color: #000;
            margin-bottom: 8px;
        }

        .steps-progress-bar .step .bullet {
            height: 30px;
            width: 30px;
            border: 2px solid #000;
            display: inline-block;
            border-radius: 50%;
            position: relative;
            transition: 0.2s;
            font-weight: 500;
            font-size: 17px;
            line-height: 25px;
        }

        .steps-progress-bar .step .bullet.active {
            border-color: #f9d95c;
            background: #f9d95c;
        }

        .steps-progress-bar .step .bullet span {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }

        .steps-progress-bar .step .bullet.active span {
            display: none;
        }

        .steps-progress-bar .step .bullet:before,
        .steps-progress-bar .step .bullet:after {
            position: absolute;
            content: "";
            bottom: 11px;
            right: -102px;
            height: 3px;
            width: 91px;
            background: #262626;
        }

        .steps-progress-bar .step .bullet.active:after {
            background: #f9d95c;
            transform: scaleX(0);
            transform-origin: left;
            animation: animate 0.3s linear forwards;
        }

        .plus_btn {
            display: flex;
            justify-content: flex-end;
        }

        .plus_btn button {
            border: 1px solid #f9d95c;
            background: #f9d95c;
            color: #fff;
            border-radius: 50%;
            height: 36px;
            width: 36px;
        }

        @keyframes animate {
            100% {
                transform: scaleX(1);
            }
        }

        .steps-progress-bar .step:last-child .bullet:before,
        .steps-progress-bar .step:last-child .bullet:after {
            display: none;
        }

        .steps-progress-bar .step p.active {
            color: var(--primary);
            transition: 0.2s linear;
        }

        .steps-progress-bar .step .check {
            position: absolute;
            left: 50%;
            top: 70%;
            font-size: 15px;
            transform: translate(-50%, -50%);
            display: none;
        }

        .steps-progress-bar .step .check.active {
            display: block;
            color: #fff;
        }

        @media screen and (max-width: 660px) {

            .steps-progress-bar .step p {
                display: none;
            }

            .steps-progress-bar .step .bullet::after,
            .steps-progress-bar .step .bullet::before {
                display: none;
            }

            .steps-progress-bar .step .bullet {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .steps-progress-bar .step .check {
                position: absolute;
                left: 50%;
                top: 50%;
                font-size: 15px;
                transform: translate(-50%, -50%);
                display: none;
            }

            .step {
                display: flex;
                align-items: center;
                justify-content: center;
            }
        }




        .page .single-input label {
            display: block;
            margin: 10px 0px;
        }


        .page .single-input input,
        .page .single-input select {
            margin-bottom: 0px;
        }

        .page .single-input textarea {
            width: 100%;
        }

        .add-more-field {
            border: 1px solid #0000004a;
            padding: 20px;
            border-radius: 10px;
            position: relative;
            margin-bottom: 30px;
        }

        .btns-actions-postion {
            position: absolute;
            bottom: -23px;
            right: 20px;
        }

        .btns-actions-postion button {
            border: 1px solid #f9d95c;
            background: #f9d95c;
            color: #fff;
            border-radius: 50%;
            height: 36px;
            width: 36px;
        }
    </style>
@endpush
@section('pagetitlesection')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link custom-cumb">{{ __('Customer') }}</a>
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
                        <h1 class="m-0 text-dark">No of Customers: {{ count($listCustomers) }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-4">
                        @can('add-customer')
                            <button class="model-slide-btn" id="addbranch-btn">
                                <span><i class="fa fa-plus" aria-hidden="true"></i></span>
                                ADD CUSTOMER
                            </button>
                        @endcan

                    </div><!-- /.col -->
                </div>
                <form action="{{ route('mfi.customer.list', ['slug' => $code]) }}" method="GET">
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
                                href="{{ route('mfi.customer.list', ['slug' => $code]) }}">Reset</a>
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
                            <table class="table  text-nowrap custom-data-table" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Branch</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Created On</th>
                                        <th>Kyc Status</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($listCustomers as $data)
                                        <tr>
                                            <td>{{ $data->first_name }}
                                            </td>
                                            <td>{{ $data->branches?->first()->name }}
                                            </td>
                                            <td>{{ $data->mobile_number }}</td>
                                            <td>{{ $data->personalDetail?->address }}</td>

                                            <td>{{ date('d-m-Y', strtotime($data->created_at)) }}</td>
                                            @if (is_null($data->kycDetails))
                                                <td>
                                                    <div class="verify-badge">
                                                        <span><i class="fa fa-times" aria-hidden="true"></i></span><br>
                                                        <a class="badge badge-primary text-dark editKycData"
                                                            data-table="customer_kyc_verifications"
                                                            data-uuid="{{ $data->uuid }}"
                                                            data-form-modal="action-of-kyc-work-from-right"
                                                            href="javascript:void(0)">Verify</a>
                                                    </div>

                                                </td>
                                            @elseif ($data->kycDetails?->is_verified_all == 1)
                                                <td>
                                                    <div class="verify-badge"><span class="verified"><i class="fa fa-check"
                                                                aria-hidden="true"></i></span></div>
                                                </td>
                                            @elseif($data->kycDetails?->is_verified_all == 0)
                                                <td>
                                                    <div class="verify-badge">
                                                        <span><i class="fa fa-times" aria-hidden="true"></i></span><br>
                                                        <a class="badge badge-primary text-dark editKycData"
                                                            data-table="customer_kyc_verifications"
                                                            data-uuid="{{ $data->uuid }}"
                                                            data-form-modal="action-of-kyc-work-from-right"
                                                            href="javascript:void(0)">Verify</a>
                                                    </div>
                                                </td>
                                            @endif
                                            <td>
                                                @switch($data->is_active)
                                                    @case(1)
                                                        <a href="javascript:void(0)" data-value="0" data-table="users"
                                                            data-message="inactive" data-uuid="{{ $data->uuid }}"
                                                            class="active-status changeUserStatus ">Active</a>
                                                    @break

                                                    @case(0)
                                                        <a href="javascript:void(0)" data-value="1" data-uuid="{{ $data->uuid }}"
                                                            data-table="users" data-message="active"
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
                                                        @can('edit-customer')
                                                            <a class="dropdown-item editCustomerData" data-table="customers"
                                                                data-uuid="{{ $data->uuid }}" data-cid="{{ $data->id }}"
                                                                data-form-modal="slide-from-right" href="javascript:void(0)"
                                                                data-title="{{ $data->title }}"
                                                                data-branch="{{ $data->branches->first()->uuid }}"
                                                                data-name="{{ $data->first_name }}"
                                                                data-email="{{ $data->email }}"
                                                                data-aadhaar="{{ $data->personalDetail?->aadhaar_no }}"
                                                                data-mobile="{{ $data->mobile_number }}"
                                                                data-alternative-mobile="{{ $data->personalDetail?->alternative_phone }}"
                                                                data-loan-id="{{ $data->personalDetail?->loan_id }}"
                                                                data-landmark="{{ $data->personalDetail?->landmark }}"
                                                                data-location-image="{{ $data->location_picture }}"
                                                                data-aadhaar-image="{{ $data->aadhaar_picture }}"
                                                                data-profile-image="{{ $data->profile_picture }}"
                                                                data-address="{{ $data->personalDetail?->address }}"
                                                                data-aadhaar-address="{{ $data->personalDetail?->aadhaar_address }}"
                                                                data-family-details="{{ !empty($data->familyDetails) ? json_encode($data->familyDetails) : [] }}"
                                                                data-property-details="{{ !empty($data->propertyDetails) ? json_encode($data->propertyDetails) : [] }}"
                                                                data-other-loan-details="{{ !empty($data->otherLoansDetails) ? json_encode($data->otherLoansDetails) : [] }}"
                                                                data-bank-details-account-holder="{{ $data->bankDetails?->account_holder }}"
                                                                data-bank-details-account-no="{{ $data->bankDetails?->account_no }}"
                                                                data-bank-details-ifsc-code="{{ $data->bankDetails?->ifsc_code }}">Edit</a>
                                                        @endcan
                                                        @can('verify-customer-kyc')
                                                            @if ($data->kycDetails?->is_verified_all != 1)
                                                                <a class="dropdown-item editKycData"
                                                                    data-table="customer_kyc_verifications"
                                                                    data-uuid="{{ $data->uuid }}"
                                                                    data-form-modal="action-of-kyc-work-from-right"
                                                                    href="javascript:void(0)">Kyc Verification</a>
                                                            @endif
                                                        @endcan
                                                        @can('create-customer-demand')
                                                            @if ($data->kycDetails?->is_verified_all == 1)
                                                                <a class="dropdown-item createDemand" data-table="users"
                                                                    data-id="{{ $data->id }}"
                                                                    data-form-modal="slide-from-right-demand"
                                                                    href="javascript:void(0)">Create Demand</a>
                                                            @endcan
                                                        @endif
                                                        @can('delete-customer')
                                                            <a class="dropdown-item deleteData" data-table="users"
                                                                data-uuid="{{ $data->uuid }}"
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
            <h2>Customer <span class="close-btn" id="close-customer-btn"><i class="fa fa-times"
                        aria-hidden="true"></i></span></h2>

            <div class="container-custom">
                <div class="steps-progress-bar">
                    <div class="step">
                        <p>Personal Details</p>
                        <div class="bullet">
                            <span>1</span>
                        </div>
                        <div class="check fas fa-check"></div>
                    </div>
                    <div class="step">
                        <p>Family Detail</p>
                        <div class="bullet">
                            <span>2</span>
                        </div>
                        <div class="check fas fa-check"></div>
                    </div>
                    <div class="step">
                        <p>Property Details</p>
                        <div class="bullet">
                            <span>3</span>
                        </div>
                        <div class="check fas fa-check"></div>
                    </div>
                    <div class="step">
                        <p>Other Loans</p>
                        <div class="bullet">
                            <span>4</span>
                        </div>
                        <div class="check fas fa-check"></div>
                    </div>
                    <div class="step">
                        <p>Bank Details</p>
                        <div class="bullet">
                            <span>5</span>
                        </div>
                        <div class="check fas fa-check"></div>
                    </div>

                </div>
                <div class="form-outer">
                    <form action="{{ route('mfi.customer.store', ['slug' => $code]) }}" id="personal_details" data-step="1"
                        class="customerformsubmit formsubmit fileupload step1">
                        <input type="hidden" name="customer_id" id="customer_id">
                        <div class="page slide-page">
                            <div class="row align-items-start">
                                <div class="col-md-6">
                                    <div class="single-input">
                                        <div class="form-group">
                                            <label>Select Title<span class="text-danger">*</span></label>
                                            <select name="title" id="title" required>
                                                <option value="">Select Title</option>
                                                <option value="mr">
                                                    Mr
                                                </option>
                                                <option value="mrs">
                                                    Mrs
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    @if (checkIsHeadBranch())
                                        <div class="single-input">
                                            <div class="form-group">
                                                <label for="branch-name">Branch <span class="text-danger">*</span></label>
                                                <select name="branch_id" id="branch_id">
                                                    <option value="">Select Branch</option>
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
                                    @else
                                        <input type="hidden" class="form-control" placeholder="Enter Name" name="branch_id"
                                            id="branch_id" value="{{ getBranchUUID() }}">
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <div class="single-input">
                                        <div class="form-group">
                                            <label>Name<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Enter Name"
                                                name="name" id="name" required>
                                            <input type="hidden" class="form-control" placeholder="Enter Name"
                                                name="customer_personal_id" id="customer_personal_id">
                                            <input type="hidden" class="form-control" placeholder="Enter Name"
                                                name="lead_uuid" id="lead_uuid">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="single-input">
                                        <div class="form-group">
                                            <label>Email <span>(optional)</span></label>
                                            <input type="email" class="form-control" placeholder="Enter Email"
                                                name="email" id="email">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="single-input">
                                        <div class="form-group">
                                            <label>Aadhaar Card<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Aadhaar card"
                                                name="aadhaar_no" id="aadhaar_no" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="single-input">
                                        <div class="form-group">
                                            <label>Mobile<span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" placeholder="Enter Mobile Number"
                                                name="mobile_number" id="mobile_number" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="single-input">
                                        <div class="form-group">
                                            <label>Alternative Number <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" placeholder="Enter Alternative Number"
                                                name="alternative_phone" id="alternative_phone" required>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="single-input">
                                        <div class="form-group">
                                            <label>Select Loan Product<span class="text-danger">*</span></label>
                                            <select name="loan_id" id="loan_id" required>
                                                <option value="">Select Loan Product</option>
                                                @forelse ($listLoans as $loans)
                                                    <option value="{{ $loans->id }}" data-id="{{ $loans->uuid }}">
                                                        {{ !empty($loans->name) ? $loans->name : '' }}
                                                    </option>
                                                @empty
                                                    <option value="" data-id="">{{ 'No Loans Available' }}
                                                    </option>
                                                @endforelse
                                            </select>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="single-input">
                                        <div class="form-group">
                                            <label>Landmark<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="LandMark"
                                                name="landmark" id="landmark" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="single-input">
                                        <div class="form-group">
                                            <label>Location(image)</label>
                                            <input type="file" class="form-control-file" name="location_image"
                                                id="location_image" required>

                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="single-input">
                                        <div class="form-group">
                                            <label>Upload aadhaar<span class="text-danger">*</span></label>
                                            <input type="file" class="form-control-file" name="aadhaar_image"
                                                id="aadhaar_image" required>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="single-input">
                                        <div class="form-group">
                                            <label>Upload Pic<span class="text-danger">*</span></label>
                                            <input type="file" class="form-control-file" name="customer_image"
                                                id="customer_image" required>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="single-input">
                                        <div class="form-group">
                                            <label>Address<span class="text-danger">*</span></label>
                                            <textarea rows="6" cols="6" name="address" id="address" required></textarea>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="single-input">
                                        <div class="form-group">
                                            <label>Aadhaar Address<span class="text-danger">*</span></label>
                                            <textarea rows="6" cols="6" name="aadhaar_address" id="aadhaar_address" required></textarea>
                                        </div>
                                    </div>
                                </div>


                            </div>

                            <div class="row field btns mt-5 justify-content-content">

                                <!-- <div class="col-md-3">
                                                                                                                                                                            <button class="prev-1 prev p-3 d-flex align-items-center justify-content-center">Previous</button>
                                                                                                                                                                        </div> -->
                                <div class="col-md-3">
                                    <button class="next-1 next p-3 d-flex align-items-center justify-content-center"
                                        type="button">Next</button>
                                </div>
                            </div>

                        </div>
                        <div class="page">
                            <div class="col-12 plus_btn">
                                <button type="button" class="family-add-more  m-1"><i class="fa fa-plus-circle"
                                        aria-hidden="true"></i></button>
                            </div>
                            <div class="append-family-more-field">
                                <div class="add-more-field">
                                    <div class="row align-items-start">
                                        <div class="col-md-6">
                                            <div class="single-input">
                                                <div class="form-group">
                                                    <label>Member name<span class="text-danger">*</span></label>
                                                    <input type="Text" class="form-control member_name"
                                                        placeholder="Member Name" name="member_name[]">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="single-input">
                                                <div class="form-group">
                                                    <label>Age<span class="text-danger">*</span></label>
                                                    <input type="Number" class="form-control age" placeholder="age"
                                                        name="age[]">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="single-input">
                                                <div class="form-group">
                                                    <label>Relation<span class="text-danger">*</span></label>
                                                    <select name="relation[]" class="relation">
                                                        <option value="">Relation</option>
                                                        <option value="father">
                                                            Father
                                                        </option>
                                                        <option value="mother">
                                                            Mother
                                                        </option>
                                                        <option value="brother">
                                                            Brother
                                                        </option>
                                                        <option value="sister">
                                                            Sister
                                                        </option>
                                                        <option value="father_in_law">
                                                            Father In Law
                                                        </option>
                                                        <option value="mother_in_law">
                                                            Mother In Law
                                                        </option>
                                                        <option value="sister_in_law">
                                                            Sister In Law
                                                        </option>
                                                        <option value="brother_in_law">
                                                            Brother In Law
                                                        </option>
                                                    </select>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="single-input">
                                                <div class="form-group">
                                                    <label>Occupation<span class="text-danger">*</span></label>
                                                    <select name="occupation_id[]" class="occupation_id">
                                                        <option value="">Select Occupation</option>
                                                        @forelse ($listOccupation as $occupation)
                                                            <option value="{{ $occupation->id }}"
                                                                data-id="{{ $occupation->uuid }}">
                                                                {{ !empty($occupation->name) ? $occupation->name : '' }}
                                                            </option>
                                                        @empty
                                                            <option value="" data-id="">
                                                                {{ 'No Occupations Available' }}
                                                            </option>
                                                        @endforelse
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <!-- <div class="btns-actions-postion">
                                                                                                                                                                                <button type="button" class="family-delete-one  m-1"><i class="fa fa-minus-circle"
                                                                                                                                                                                        aria-hidden="true"></i></button>
                                                                                                                                                                            </div> -->
                                </div>
                            </div>


                            <div class="row field btns mt-5 justify-content-content">

                                <div class="col-md-3">
                                    <button type="button"
                                        class="prev-2 prev p-3 d-flex align-items-center justify-content-center">Previous</button>
                                </div>
                                <div class="col-md-3">
                                    <button type="button"
                                        class="next-2 next p-3 d-flex align-items-center justify-content-center">Next</button>
                                </div>
                            </div>
                        </div>

                        <div class="page">
                            <div class="col-12 plus_btn">
                                <button type="button" class="property-add-more  m-1"><i class="fa fa-plus-circle"
                                        aria-hidden="true"></i></button>
                            </div>
                            <div class="append-property-more-field">
                                <div class="add-more-field">
                                    <div class="row align-items-start">
                                        <div class="col-md-6">
                                            <div class="single-input">
                                                <div class="form-group">
                                                    <label>Property Type<span class="text-danger">*</span></label>
                                                    <select name="property_type[]" class="property_type">
                                                        <option value="">Property Type</option>
                                                        <option value="public">
                                                            Public
                                                        </option>
                                                        <option value="private">
                                                            Private
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="single-input">
                                                <div class="form-group">
                                                    <label>Property condition<span class="text-danger">*</span></label>
                                                    <select name="property_condition[]" id="property_condition">
                                                        <option value="">Property condition</option>
                                                        <option value="own">
                                                            Own
                                                        </option>
                                                        <option value="rented">
                                                            Rented
                                                        </option>
                                                    </select>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="single-input">
                                                <div class="form-group">
                                                    <label>Year<span class="text-danger">*</span></label>
                                                    <input type="year" class="form-control" name="year[]"
                                                        id="year">
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="btns-actions-postion">
                                        <!-- <button type="button" class="property-add-more  m-1"><i class="fa fa-plus-circle"
                                                                                                                                                                                        aria-hidden="true"></i></button> -->
                                        <!-- <button class="property-delete-one  m-1"><i class="fa fa-minus-circle" aria-hidden="true"></i></button> -->
                                    </div>
                                </div>
                            </div>


                            <div class="row field btns mt-5 justify-content-content">

                                <div class="col-md-3">
                                    <button type="button"
                                        class="prev-3 prev p-3 d-flex align-items-center justify-content-center">Previous</button>
                                </div>
                                <div class="col-md-3">
                                    <button type="button"
                                        class="next-3 next p-3 d-flex align-items-center justify-content-center">Next</button>
                                </div>
                            </div>
                        </div>
                        <div class="page">
                            <div class="col-12 plus_btn">
                                <button type="button" class="other-loan-add-more  m-1"><i class="fa fa-plus-circle"
                                        aria-hidden="true"></i></button>
                            </div>
                            <div class="append-other-loans-more-field">
                                <div class="add-more-field">
                                    <div class="row align-items-start">
                                        <div class="col-md-6">
                                            <div class="single-input">
                                                <div class="form-group">
                                                    <label>Company Name<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" placeholder="Company Name"
                                                        name="company[]" id="company">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="single-input">
                                                <div class="form-group">
                                                    <label>Total loan amount<span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" name="total_loan_amount[]"
                                                        id="total_loan_amount">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="single-input">
                                                <div class="form-group">
                                                    <label>Emi frequency<span class="text-danger">*</span></label>

                                                    <select name="emi_frequency[]" class="emi_frequency">
                                                        <option value="">Emi frequency</option>
                                                        <option value="daily">
                                                            Daily
                                                        </option>
                                                        <option value="weekly">
                                                            Weekly
                                                        </option>
                                                        <option value="biweekly">
                                                            Biweekly
                                                        </option>
                                                        <option value="monthly">
                                                            Monthly
                                                        </option>
                                                    </select>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="single-input">
                                                <div class="form-group">
                                                    <label>Total Paid Emi<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="total_paid_emi[]"
                                                        class="total_paid_emi">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="btns-actions-postion">
                                        <!-- <button type="button" class="add-more  m-1"><i class="fa fa-plus-circle"
                                                                                                                                                                                        aria-hidden="true"></i></button>
                                                                                                                                                                                <button type="button" class="delete-one  m-1"><i class="fa fa-minus-circle"
                                                                                                                                                                                        aria-hidden="true"></i></button> -->
                                    </div>
                                </div>
                            </div>
                            <div class="row field btns mt-5 justify-content-content">

                                <div class="col-md-3">
                                    <button type="button"
                                        class="prev-4 prev p-3 d-flex align-items-center justify-content-center">Previous</button>
                                </div>
                                <div class="col-md-3">
                                    <button type="button"
                                        class="next-4 next p-3 d-flex align-items-center justify-content-center">Next</button>
                                </div>
                            </div>
                        </div>
                        <div class="page">
                            <div class="row align-items-start">
                                <div class="col-md-6">
                                    <div class="single-input">
                                        <div class="form-group">
                                            <label>Account holder name<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Account holder Name"
                                                id="account_holder" name="account_holder">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="single-input">
                                        <div class="form-group">
                                            <label>Account no<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Account Number"
                                                name="account_no" id="account_no">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="single-input">
                                        <div class="form-group">
                                            <label>Ifsc Code<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Ifsc Code"
                                                name="ifsc_code" id="ifsc_code">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row field btns mt-5 justify-content-content">

                                <div class="col-md-3">
                                    <button type="button"
                                        class="prev-5 prev p-3 d-flex align-items-center justify-content-center">Previous</button>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit"
                                        class="p-3 submit3 update-btn  d-flex align-items-center justify-content-center">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>


        <div id="action-of-kyc-work-from-right" class="slide-from-right no-scroll-form">
            <h2>Kyc verification <span class="close-btn"><i class="fa fa-times" aria-hidden="true"></i></span></h2>

            <form action="{{ route('mfi.customer.kyc.details.update', ['slug' => $code]) }}" class="formsubmit fileupload"
                method="post" id="submit_kyc" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <div class="single-input">
                            <div class="form-group">
                                <label for="branch-name">Is Verified All <span class="text-danger">*</span></label>
                                <div class="isvarified-new">
                                    <label>
                                        <input type="radio" name="verified_all" value="1">Yes
                                    </label>
                                    <label>
                                        <input type="radio" name="verified_all" value="0" checked>No
                                    </label>
                                </div>
                                <input type="hidden" class="form-control" id="customer_uuid" name="customer_uuid">
                                <input type="hidden" class="form-control" id="customer_kyc_id" name="customer_kyc_id">

                                <input type="hidden" class="form-control" id="customer_user_id" name="customer_user_id">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="single-input">
                            <div class="form-group">
                                <label for="branch-name">Is Loan Recommended <span class="text-danger">*</span></label>
                                <div class="isvarified-new">
                                    <label>
                                        <input type="radio" name="loan_recommended" value="1">Yes
                                    </label>
                                    <label>
                                        <input type="radio" name="loan_recommended" value="0" checked>No
                                    </label>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="single-input">
                            <div class="form-group">
                                <label for="branch-name">Select purpose</label>
                                <select name="purpose_id" id="purpose_id">
                                    <option value="">Select Purpose</option>
                                    @forelse ($listPurpose as $purpose)
                                        <option value="{{ $purpose->id }}" data-id="{{ $purpose->id }}">
                                            {{ !empty($purpose->name) ? $purpose->name : '' }}
                                        </option>
                                    @empty
                                        <option value="" data-id="">{{ 'No Purposes Available' }}
                                        </option>
                                    @endforelse
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="single-input">
                            <div class="form-group">
                                <label for="principal_amount">Credit Score <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="credit_score" id="credit_score"
                                    aria-describedby="Principal Amount" placeholder="Enter Credit Score">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="single-input">
                            <div class="form-group">
                                <label for="principal_amount">Family Income/Month <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="family_income_month"
                                    id="family_income_month" aria-describedby="Principal Amount"
                                    placeholder="Enter Family Income/Month">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="single-input">
                            <div class="form-group">
                                <label for="principal_amount">Monthly Loan Liability <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="monthly_loan_liability"
                                    id="monthly_loan_liability" aria-describedby="Principal Amount"
                                    placeholder="Enter Monthly Loan Liability">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="single-input">
                            <div class="form-group">
                                <label>Upload Picture<span class="text-danger">*</span></label>
                                <input type="file" class="form-control-file" name="kyc_profile_image"
                                    id="kyc_profile_image">
                                <div id="kyc" style="display: none;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="dynamic_field">
                    <div class="col-md-11">
                        <div class="single-input">
                            <div class="form-group">
                                <label>Video Link<span class="text-danger">*</span></label>
                                <input type="text" class="form-control validate_error" name="video_url[]" id="video_url">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">
                        {{--  <div class="col-md-1"> --}}
                        <a href="javascript:void(0);" style="margin-top: 36px;" class="btn btn-success " id="add_button"
                            title="Add field" data-count="1"><i class="fa fa-plus" aria-hidden="true"></i></a>
                        {{-- </div> --}}
                    </div>
                </div>
                <div class="row" id="dynamic_document_field">
                    <div class="col-md-11">
                        <div class="single-input">
                            <div class="form-group">
                                <label>Document<span class="text-danger">*</span></label>
                                <input type="file" class="form-control-file" name="document_file[]" id="document_file">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">
                        {{-- <div class="col-md-1"> --}}
                        <a href="javascript:void(0);" style="margin-top: 36px;" class="btn btn-success "
                            id="add_document_button" title="Add field" data-count="1"><i class="fa fa-plus"
                                aria-hidden="true"></i></a>
                        {{-- </div> --}}
                    </div>
                </div>

                <div class="btns-block no-scroll-btns">
                    <button type="submit">ADD</button>

                </div>
            </form>

        </div>

        <div id="slide-from-right-demand" class="slide-from-right">
            <h2>Demand <span class="close-btn"><i class="fa fa-times" aria-hidden="true"></i></span></h2>

            <form action="{{ route('mfi.customer.demand.store', ['slug' => $code]) }}" class="formsubmit" method="post">
                {{--  <div class="single-input">
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
                    </select>
                </div>
            </div>  --}}

                <input type="hidden" class="form-control" id="user_id" name="user_id">
                <div class="form-group">
                    <label for="agent-group">Select Loan Product <span class="text-danger">*</span></label>
                    <select name="loan_id" id="loan_id">
                        <option value="">Select Loan Product</option>
                        @forelse ($listLoans as $loans)
                            <option value="{{ $loans->id }}" data-id="{{ $loans->uuid }}"
                                data-principal-amount="{{ $loans->principal_amount }}">
                                {{ !empty($loans->name) ? $loans->name : '' }}
                            </option>
                        @empty
                            <option value="" data-id="">{{ 'No Loans Available' }}
                            </option>
                        @endforelse
                    </select>
                </div>
                <div class="single-input">
                    <div class="form-group">
                        <label for="agent-group">Loan Amount <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="loan_amount" name="loan_amount"
                            aria-describedby="emailHelp" placeholder="Enter Loan Amount">

                    </div>
                </div>
                <div class="single-input">
                    <label for="agent-group">Select Group </label>
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

                <div class="single-input">
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
                        </select>
                    </div>
                </div>

                <div class="single-input">
                    <div class="form-group">
                        <label for="agent-group">Emi Start Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="emi_start_date" name="emi_start_date">

                    </div>
                </div>

                <div class="single-input">
                    <div class="form-group">
                        <label for="tenure">Tenure (In weeks) <span class="text-danger">*</span></label>
                        <!-- <div class="input-group mb-3"> -->
                        <input type="number" class="form-control" id="tenure" name="tenure" placeholder="Tenure"
                            aria-label="Tenure" aria-describedby="basic-addon2" min="12" max="24">
                        <!-- <div class="input-group-append">
                                                                                                                                                                                                            <span class="input-group-text" id="basic-addon2">In weeks</span>
                                                                                                                                                                                                        </div> -->
                        <!-- </div> -->
                    </div>
                </div>



                <div class="single-input">
                    <div class="form-group">
                        <label for="agent-group">Remarks</label>
                        <textarea rows="5" cols="30" class="form-control" name="remarks" id="remarks"></textarea>
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

                    // $("#submit3").removeClass('update-btn');
                    $("#slide-from-right").addClass("show-side-form");
                    var personal_details = $("#personal_details").trigger("reset");
                    $(".append-family-more-field").html(familyMoreField());
                    $(".append-property-more-field").html(propertyMoreField());
                    $(".append-other-loans-more-field").html(otherLoanMoreField());
                    initMultiStepForm();
                    $(".customerformsubmit").data('step', 1);
                    const slidePage = document.querySelector(".slide-page");
                    const progressText = document.querySelectorAll(".step p");
                    const progressCheck = document.querySelectorAll(".step .check");
                    const bullet = document.querySelectorAll(".step .bullet");
                    slidePage.style.marginLeft = `0%`;
                    $.each(progressCheck, function(index, value) {
                        // $(value).removeClass('active');
                        if (index != 0) {
                            bullet[index].classList.remove("active");
                            progressCheck[index].classList.remove("active");
                            progressText[index].classList.remove("active");
                        }
                    });

                    // $("#slide-from-right").find('button[type="submit"]').addClass('update-btn');
                });

                $("#close-btn").click(function() {
                    $("#slide-from-right").removeClass("show-side-form");
                });
            });
            var familyDetailAction = "{{ route('mfi.customer.family.details.save', ['slug' => $code]) }}";

            var propertyDetailAction = "{{ route('mfi.customer.property.details.save', ['slug' => $code]) }}";

            var otherLoanDetailAction = "{{ route('mfi.customer.other.loans.details.save', ['slug' => $code]) }}";

            var bankDetailAction = "{{ route('mfi.customer.bank.details.save', ['slug' => $code]) }}";
            var personalDetailAction = "{{ route('mfi.customer.personal.details.save', ['slug' => $code]) }}";
            var loanUuid = "{{ request()->lead_uuid }}";
            let customerRedirectUrl = "{{ route('mfi.customer.list', ['slug' => $code]) }}";
        </script>
        <script>
            initMultiStepForm();

            function initMultiStepForm() {
                const progressNumber = document.querySelectorAll(".step").length;
                const slidePage = document.querySelector(".slide-page");
                const submitBtn = document.querySelector(".submit");
                const progressText = document.querySelectorAll(".step p");
                const progressCheck = document.querySelectorAll(".step .check");
                const bullet = document.querySelectorAll(".step .bullet");
                const pages = document.querySelectorAll(".page");
                const nextButtons = document.querySelectorAll(".next");
                const prevButtons = document.querySelectorAll(".prev");


                bullet[0].classList.add("active");
                progressCheck[0].classList.add("active");
                progressText[0].classList.add("active");
                const stepsNumber = pages.length;

                if (progressNumber !== stepsNumber) {
                    console.warn(
                        "Error, number of steps in progress bar do not match number of pages"
                    );
                }

                document.documentElement.style.setProperty("--stepNumber", stepsNumber);

                let current = 1;

                for (let i = 0; i < nextButtons.length; i++) {

                    nextButtons[i].addEventListener("click", function(event) {
                        event.preventDefault();
                        let inputsValid = true;
                        console.log(i);
                        if (i == 0) {
                            inputsValid = validateCustomerFrom('personalDetail');
                            console.log(inputsValid);
                        }
                        // else{
                        //     inputsValid = true;
                        // }
                        else if (i == 1) {
                            inputsValid = validateCustomerFrom('familyDetail');

                        } else if (i == 2) {
                            inputsValid = validateCustomerFrom('propertyDetail');

                        } else if (i == 3) {
                            inputsValid = validateCustomerFrom('otherLoanDetail');

                        } else if (i == 4) {
                            inputsValid = validateCustomerFrom('bankDetail');
                        }

                        if (inputsValid) {
                            slidePage.style.marginLeft = `-${(100 / stepsNumber) * current}%`;
                            bullet[current].classList.add("active");
                            progressCheck[current].classList.add("active");
                            progressText[current].classList.add("active");
                            current += 1;
                        }


                    });
                }

                for (let i = 0; i < prevButtons.length; i++) {
                    prevButtons[i].addEventListener("click", function(event) {
                        event.preventDefault();
                        slidePage.style.marginLeft = `-${(100 / stepsNumber) * (current - 2)}%`;
                        bullet[current - 1].classList.remove("active");
                        progressCheck[current - 1].classList.remove("active");
                        progressText[current - 1].classList.remove("active");
                        current -= 1;
                        $(".err_message").removeClass("d-block").hide();
                        $("form .form-control").removeClass("is-invalid");
                    });
                }
                // submitBtn.addEventListener("click", function() {
                // bullet[current - 1].classList.add("active");
                // progressCheck[current - 1].classList.add("active");
                // progressText[current - 1].classList.add("active");
                // current += 1;
                // setTimeout(function() {
                //     alert("Your Form Successfully Signed up");
                //     location.reload();
                // }, 800);
                // });

                function validateInputs(ths) {
                    let inputsValid = true;

                    const inputs = ths.parentElement.parentElement.querySelectorAll("input");
                    console.log(inputs);
                    for (let i = 0; i < inputs.length; i++) {
                        const valid = inputs[i].checkValidity();
                        console.log(valid);
                        if (!valid) {
                            inputsValid = false;
                            inputs[i].classList.add("invalid-input");
                        } else {
                            inputs[i].classList.remove("invalid-input");
                        }
                    }
                    return inputsValid;
                }
            }
        </script>


        {{--  <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>  --}}
        {{--  <script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>  --}}
        {{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script> --}}
        {{-- <script>
            $(document).ready(function() {
                $('#dataTable').DataTable();
            });
        </script> --}}

        <script src="{{ asset('assets/admin/js/datatableajax.js') }}"></script>
        <script src="{{ asset('assets/admin/js/customer.js') }}"></script>
        <script src="{{ asset('assets/admin/js/customer-kyc-verification.js') }}"></script>
        <script src="{{ asset('assets/admin/js/customer-kyc-document-verification.js') }}"></script>
    @endpush
