@extends('admin.layouts.app')
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
<<<<<<<< HEAD:resources/views/admin/brand/edit.blade.php

@section('pagetitlesection')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link custom-cumb">{{ __('Brand') }}</a>
    </li>
@endsection

========
@section('pagetitlesection')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link custom-cumb">{{ __('ADMIN USERS') }}</a>
    </li>
@endsection
>>>>>>>> 5278a15d54d297b514d5e419999275e8d42c3132:resources/views/restaurant/dashboard/edit-user.blade.php
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-8">
<<<<<<<< HEAD:resources/views/admin/brand/edit.blade.php
                        <h1 class="m-0 text-dark">Edit Brand</h1>
                    </div><!-- /.col -->
                    {{-- <div class="col-sm-4 right_btn">
                        <a class="btn btn-primary " href="{{ route('admin.product.category.list') }}">
                            <span><i class="fa fa-list" aria-hidden="true"></i></span>
                            Category List
========
                        <h1 class="m-0 text-dark">Edit User</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-4 right_btn">
                        <a class="btn btn-primary" href="{{ route('admin.user.list') }}">
                            <span><i class="fa fa-list" aria-hidden="true"></i></span>
                            User List
>>>>>>>> 5278a15d54d297b514d5e419999275e8d42c3132:resources/views/restaurant/dashboard/edit-user.blade.php
                        </a>
                    </div><!-- /.col --> --}}
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <!-- /.row -->
                <!-- Recent Assets -->
                <div class="card p-3">
<<<<<<<< HEAD:resources/views/admin/brand/edit.blade.php
                    <form method="post" action="{{ route('admin.product.brand.edit', $data->uuid) }}" id="customerForm"
========
                    <form method="post" {{-- action="{{ route('admin.invitation.store') }}" --}} id="customerForm"
>>>>>>>> 5278a15d54d297b514d5e419999275e8d42c3132:resources/views/restaurant/dashboard/edit-user.blade.php
                        enctype="multipart/form-data">
                        @csrf
                        {{-- <input type="hidden" name="id" value="{{isset($data)?$data->id:''}}"> --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
<<<<<<<< HEAD:resources/views/admin/brand/edit.blade.php
                                    <label>Name<sup>*</sup></label>
                                    <input id="name" class="form-control" type="text" name="name"
                                        placeholder="Brand" value="{{ old('name', $data->name) }}" />
                                    @error('name')
========
                                    <label>First Name<sup>*</sup></label>
                                    <input id="first_name" class="form-control" type="text" name="first_name"
                                        placeholder="First Name" value="{{ $userDetails->first_name }}" />
                                    @error('first_name')
>>>>>>>> 5278a15d54d297b514d5e419999275e8d42c3132:resources/views/restaurant/dashboard/edit-user.blade.php
                                        <span class="text-sm text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
<<<<<<<< HEAD:resources/views/admin/brand/edit.blade.php



                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    {{-- <input id="category_name" class="" type="text" name="category_name"
                                        placeholder="Category" value="{{ old('category_name') }}" /> --}}
                                    <textarea name="description" id="" class="form-control" cols="30" rows="5"
                                        placeholder="Description">{{ $data->description }}</textarea>
                                    @error('description')
                                        <span class="text-sm text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Brand Image</label>
                                    <input id="brand_image" class="form-control" type="file" name="brand_image"
                                        placeholder="Brand" value="{{ old('brand_image') }}" />
                                    @error('brand_image')
                                        <span class="text-sm text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <img src="{{ asset('images/' . $data->brand_image) }}" alt="Your Image" width="200" height="100">
                            </div>

                        </div>

========
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Last Name<sup>*</sup></label>
                                    <input id="last_name" class="form-control" type="text" name="last_name"
                                        placeholder="Last Name" value="{{ $userDetails->first_name }}" />
                                    @error('last_name')
                                        <span class="text-sm text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email<sup>*</sup></label>
                                    <input id="email" class="form-control" type="text" name="email"
                                        placeholder="Email" value="{{$userDetails->email }}" readonly/>
                                    @error('email')
                                        <span class="text-sm text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Phone<sup>*</sup></label>
                                    <input id="mobile_number" class="form-control" type="text" name="mobile_number"
                                        placeholder="Phone" value="{{ $userDetails->mobile_number }}" />
                                    @error('mobile_number')
                                        <span class="text-sm text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Assign Role<sup>*</sup></label>
                                    <select id="role_id" class="form-control" name="role_id">
                                        <option value="">Select Role</option>
                                        @forelse ($roles as $role)
                                            <option value="{{ $role->id }}"
                                                @if ($userDetails->roles->first()->id == $role->id) selected @endif>{{ $role->name }}
                                            </option>
                                        @empty
                                        @endforelse
                                    </select>
                                    @error('role_id')
                                        <span class="text-sm text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">

                            </div>
                        </div>
>>>>>>>> 5278a15d54d297b514d5e419999275e8d42c3132:resources/views/restaurant/dashboard/edit-user.blade.php
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <button class="btn btn-primary" type="submit">Update</button>
                            </div>
                            <div class="col-md-4">

                            </div>
                            <div class="col-md-4">

                            </div>

                        </div>

                    </form>
                </div>

            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>

    <!-- add baranch form -->




    <!-- add baranch form-end-->

    <!-- /.content-wrapper -->
@endsection
<<<<<<<< HEAD:resources/views/admin/brand/edit.blade.php

@push('scripts')
    {{-- <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>  --}}
    {{-- <script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap.min.js') }}"></script> --}}
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script> --}}
    {{-- <script>
            $(document).ready(function() {
                $('#dataTable').DataTable();
            });
        </script> --}}

========
@push('scripts')
    {{-- <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>  --}}
    {{-- <script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap.min.js') }}"></script> --}}
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script> --}}
    {{-- <script>
            $(document).ready(function() {
                $('#dataTable').DataTable();
            });
        </script> --}}

>>>>>>>> 5278a15d54d297b514d5e419999275e8d42c3132:resources/views/restaurant/dashboard/edit-user.blade.php
    <script src="{{ asset('assets/admin/js/datatableajax.js') }}"></script>
    <script src="{{ asset('assets/admin/js/customer.js') }}"></script>
    <script src="{{ asset('assets/admin/js/customer-kyc-verification.js') }}"></script>
    <script src="{{ asset('assets/admin/js/customer-kyc-document-verification.js') }}"></script>
@endpush