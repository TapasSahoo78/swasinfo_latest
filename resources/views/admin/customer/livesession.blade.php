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
    <a href="#" class="nav-link custom-cumb">{{ __('Live Session') }}</a>
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
                    <h1 class="m-0 text-dark">No of Live Session: {{ count($session) }}</h1>
                </div><!-- /.col -->
                <!-- /.col -->
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
                        <table class="table  text-nowrap custom-data-table" id= <?php if(count($session) != 0){ echo "dataTable"; } ?>>
                            <thead>
                                <tr>


                                    <th>Trainer Name</th>
                                    <th>Topic</th>
                                    <th>Date And Time</th>

                                    <th>Status</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($session as $data)
                                <tr>
                                    <td>{{ $data->trainer->first_name }}
                                    </td>
                                    <td>{{ $data->topic }}
                                    </td>
                                    <td style="color:red">{{ date('d-m-Y H:i:s', strtotime($data->date_and_time)) }}</td>
                                    <td>
                                                @switch($data->status)
                                                    @case(1)
                                                        <a href="javascript:void(0)" data-value="0" data-table="users"
                                                            data-message="Not Approved" data-id="{{ $data->id }}"
                                                            class="active-status changeSessionStatus text-success">Authorised Approved</a>
                                                    @break
                                                    @case(0)
                                                        <a href="javascript:void(0)" data-value="1" data-id="{{ $data->id }}"
                                                            data-table="users" data-message="Approved"
                                                            class="inactive-status changeSessionStatus ">Authorised Not Approved</a>
                                                    @break

                                                    @default
                                                        <a href="javascript:void(0)"
                                                            class="badge badge-danger text-dark">Deleted</a>
                                                @endswitch
                                            </td>
                                 
                                    <td>{{ date('d-m-Y', strtotime($data->created_at)) }}</td>

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




<!-- add baranch form-end-->

<!-- /.content-wrapper -->
@endsection
@push('scripts')



<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
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



        $.noConflict();
        var dataTable = $('#dataTable').DataTable({ // Enable search
            searching: true, // Make the table responsive
            order: [],
            buttons: [{
                    extend: 'csv', // Export as CSV
                    text: 'Export CSV',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4] // Define which columns to export (e.g., columns 0 and 2)
                    },
                    title: 'Amtron Employee Data'
                },
                {
                    extend: 'pdf', // Export as PDF
                    text: 'Export PDF',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4] // Define which columns to export (e.g., columns 0 and 2)
                    },
                    title: 'Amtron Employee Data'
                }
            ],
            columns: [{
                    data: 'column1'
                },
                {
                    data: 'column2'
                },
                {
                    data: 'column3'
                },
                {
                    data: 'column4'
                },
                {
                    data: 'column5'
                }

            ]
        });

        $('#exportDropdown').change(function() {
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

        $('#custom-search-input').on('keyup', function() {
            console.log('Input value:', this.value);
            dataTable.search(this.value).draw();
        });

    });

        $('.custom-data-table').on('click', '.changeSessionStatus,.changeUserBlock', function (e) {
        var $this = $(this);
        var uuid = $this.data('id');
      
        if ($this.hasClass('changeSessionStatus')) {
            var value = {
                'is_active': $this.data('value')
            };
        } else {
            var value = {
                'is_blocked': $this.data('block')
            };
        }
        var find = $this.data('table');
        var message = $this.data('message') ?? 'test message';
        Swal.fire({
            title: 'Are you sure you want to ' + message + ' it?',
            text: 'The status will be changed to ' + message,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, ' + message + ' it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "put",
                    url: baseUrl + 'ajax/updateSessionStatus',
                    data: { 'uuid': uuid, 'find': find, 'value': value },
                    cache: false,
                    dataType: "json",
                    beforeSend: function () {

                    },
                    success: function (response) {
                        if (response.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Status Updated!',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            location.reload();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'We are facing some technical issue now.',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                    },
                    error: function (response) {
                        Swal.fire({
                            icon: 'error',
                            title: 'We are facing some technical issue now. Please try again after some time',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                    /* ,
                    complete: function(response){
                        location.reload();
                    } */
                });
            }
        });


        
    });
</script>

<script src="{{ asset('assets/admin/js/datatableajax.js') }}"></script>
<script src="{{ asset('assets/admin/js/customer.js') }}"></script>
<script src="{{ asset('assets/admin/js/customer-kyc-verification.js') }}"></script>
<script src="{{ asset('assets/admin/js/customer-kyc-document-verification.js') }}"></script>
@endpush