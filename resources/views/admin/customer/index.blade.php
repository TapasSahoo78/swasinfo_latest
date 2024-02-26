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
                    <h1 class="m-0 text-dark">No of Customers: {{ count($users) }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-4 right_btn">
                    {{-- <a class="btn btn-primary" href="#">
                                <span><i class="fa fa-plus" aria-hidden="true"></i></span>
                                ADD CUSTOMER
                            </a> --}}
                </div><!-- /.col -->
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
            <div class="row">
                <div class="col-12">
                    <!-- /.card-header -->

                    <div class="card-body table-responsive p-0" style="height: 700px;">
                    <div class="table-responsive" style="height:410px">
                    <table class="table  text-nowrap custom-data-table" id="dataTable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>User Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Profile Image</th>
                                    {{-- <th>Address</th> --}}
                                    <th>Created On</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $data)
                                <tr>
                                    <td>{{ $data->first_name?$data->first_name:'---' }}
                                    </td>
                                    <td>{{ $data->username }}
                                    </td>
                                    <td>{{ $data->email }}
                                    </td>
                                    <td>{{ $data->mobile_number?$data->mobile_number:'---' }}</td>
                                    <td><img class="ml-1" src="{{ $data->customer_picture }}" width="40" height="40" alt="Icon 01" /></td>
                                    <td>{{ date('d-m-Y', strtotime($data->created_at)) }}</td>
                                    <td>
                                        @switch($data->is_active)
                                        @case(1)
                                        <a href="javascript:void(0)" data-value="0" data-table="users" data-message="inactive" data-uuid="{{ $data->uuid }}" class="active-status changeUserStatus text-success">Active</a>
                                        @break
                                        @case(0)
                                        <a href="javascript:void(0)" data-value="1" data-uuid="{{ $data->uuid }}" data-table="users" data-message="active" class="inactive-status changeUserStatus ">Inactive</a>
                                        @break

                                        @default

                                        @endswitch

                                    </td>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        @switch($data->is_blocked)
                                        @case(1)
                                        <a href="javascript:void(0)" data-block="0" data-uuid="{{ $data->uuid }}" data-table="users" data-message="Unblock" class="inline-flex font-medium bg-slate-100 text-slate-500 rounded-full text-center px-2.5 py-0.5 changeUserBlock">Blocked</a>
                                        @break

                                        @case(0)
                                        <a href="javascript:void(0)" data-block="1" data-table="users" data-message="block" data-uuid="{{ $data->uuid }}" class="inline-flex font-medium bg-emerald-100 text-emerald-600 rounded-full text-center px-2.5 py-0.5 changeUserBlock">Unblocked</a>
                                        @break
                                        @endswitch
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <img src="{{ asset('assets/img/three-dot-btn.png') }}" alt="">
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="{{ route('admin.agent.report', $data->uuid) }}">Report</a>
                                                <a class="dropdown-item" data-table="users"  href="{{ route('admin.customer.view.details', $data->uuid) }}">Details</a>

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




<!-- add baranch form-end-->

<!-- /.content-wrapper -->
@endsection
@push('scripts')


<script src="{{ asset('assets/admin/js/customer.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
            $(document).ready(function() {
               
           

          
      $.noConflict();
        var dataTable = $('#dataTable').DataTable({// Enable search
            searching: true,// Make the table responsive
            paging: true,
            order: [],
            buttons: [
                    {
                        extend: 'csv', // Export as CSV
                        text: 'Export CSV',
                        exportOptions: {
                            columns: [0,1,2,3,4,5,6,7,8] // Define which columns to export (e.g., columns 0 and 2)
                        },
                        title: 'Amtron Employee Data'
                    },
                    {
                        extend: 'pdf', // Export as PDF
                        text: 'Export PDF',
                        exportOptions: {
                            columns: [0,1,2,3,4,5,6,7,8] // Define which columns to export (e.g., columns 0 and 2)
                        },
                        title: 'Amtron Employee Data'
                    }
                ],
            columns: [
                { data: 'column1' },
                { data: 'column2' },
                { data: 'column3' },
                { data: 'column4' },
                { data: 'column5' },
                { data: 'column6' },
                { data: 'column7' },
                { data: 'column8' },
                { data: 'column9' }
            ]
        });

        $('#exportDropdown').change(function () {
        var selectedFormat = $(this).val();
            
        if (selectedFormat === 'csv') {
            // Export as CSV
            dataTable.button('.buttons-csv').trigger();
        } else if (selectedFormat === 'pdf') {
            // Export as PDF
            dataTable.button('.buttons-pdf').trigger();
        }
    });

        // Add search functionality
     
        $('#custom-search-input').on('keyup', function () {
            console.log('Input value:', this.value);
            dataTable.search(this.value).draw();
        });

    });
    
        </script>
<script src="{{ asset('assets/admin/js/datatableajax.js') }}"></script>

<script src="{{ asset('assets/admin/js/customer-kyc-verification.js') }}"></script>
<script src="{{ asset('assets/admin/js/customer-kyc-document-verification.js') }}"></script>
@endpush