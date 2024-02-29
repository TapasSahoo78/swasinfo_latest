@extends('admin.layouts.app')
@push('style')
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css"> --}}
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.0/css/buttons.dataTables.min.css">
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
    <a href="#" class="nav-link custom-cumb">{{ __('Report') }}</a>
</li>
@endsection
@section('content')
<style>
.dataTables_wrapper {
    padding: 11px 14px !important;
    }
select#exportDropdown {
    padding: 9px 12px;
    width: 200px;
    border: #ccc 1px solid;
    border-radius: 6px;
    margin: 12px;
    float: right;
    }
div#dataTable_paginate {
    margin-top: 8px;
    }
.count_secbtn {
    width: 100%;
    display: flex;
    justify-content: end;
}
.btn-xs {
    padding: 6px 12px;
    font-size: 17px;
    line-height: 1.5;
    border-radius: 5px;
    margin-bottom: 12px;
}
.card_con h4 {
    height: auto;
    font-size: 17px;
}
.card_con h4  span {
    padding-right: 5px;
    height: 40px !important;
    float: left;
     }
.count_sec .card {
    padding: 11px;
    justify-content: start;
}

</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-8">
                    <h1 class="m-0 text-dark">Report</h1>
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
            <div class="card">

                <div class="row">
                    <div class="col-12">
                        <!-- <div class="col-md-6">
                            <div class="form-group">
                                <label>Type<sup>*</sup></label>
                                <select id="Type" name="type" class="form-control">
                                <option value="">Select Type.</option>
                                    <option value="1">Dietitian</option>
                                    <option value="0">Trainer</option>
                                </select>
                                @error('name')
                                <span class="text-sm text-danger">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div> -->
                       
                        <div class="count_secbtn"><a href="#"  class="btn btn-xs btn-info pull-right">Export</a></div>
                        <section class="report-section">
                            <!-- <h2>App User Page Vist In last 7 days</h2> -->
                            <div class="card-body table-responsive p-0">
                                <?php if (isset($recentApiHits['0'])) { ?>
                                    <table id="dataTable" class="table  text-nowrap custom-data-table ">
                                    <?php } else { ?>
                                        <table class="table  text-nowrap custom-data-table ">
                                        <?php } ?>
                                        <thead>
                                            <tr>
                                                <th>Page Name</th>
                                                <th>IP Address</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                    
                                            @forelse ($recentApiHits as $data)
                                            <tr>
                                                <td><?php 
                                                    echo $data->request_page; ?>
                                                </td>
                                                <!-- <td>{{ $data->request_page?$data->request_page:'---' }}
                                                </td> -->
                                                <td>{{ $data->ip_address }}
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
                        </section>

                    </div>
                </div>
            </div>
            
           
            <div class="count_sec">
            <div class="count_secbtn"><a href="{{ route('admin.agent.reportexport', $id) }}" class="btn btn-xs btn-info pull-right">Export</a></div>
                <div class="row">
                <div class="col-md-3">
                        <div class="card card-body">
                            <div class="card_con">
                                <h4><span><i class="far fa-clock"></i></span><?php echo $apptime ; ?></h4>
                                    
                                <h5>Total Time Spend in the App</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card card-body">
                            <div class="card_con">
                                <h4><span><i class="fas fa-file-download"></i></span><?php echo $vistcount; ?></h4>
                                <h5>No. Of installing</h5>
                            </div>
                        </div>
                    </div>
                   
                    <div class="col-md-3">
                        <div class="card card-body">
                            <div class="card_con">
                                <h4><span><i class="far fa-eye"></i></span><?php echo $vistcount; ?></h4>
                                <h5>No. Of Visits in the app</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card card-body">
                            <div class="card_con">
                                <h4><span><i class="far fa-id-card"></i></span><?php echo $subscriptioncount; ?></h4>
                                <h5>Subscription purchases Count</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card card-body">
                            <div class="card_con">
                                <h4><span><i class="far fa-id-card"></i></span><?php echo $subscriptioncount; ?></h4>
                                <h5>No. Of uninstalling</h5>
                            </div>
                        </div>
                    </div>
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
<script src="https://cdn.datatables.net/buttons/2.3.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.0/js/buttons.html5.min.js"></script>
<script>
$(document).ready(function() {
    var dataTable = $('#dataTable').DataTable({
        // Enable search
        searching: true,
        // Make the table responsive
        order: [],
        buttons: [
            {
                extend: 'csv', // Export as CSV
                text: 'Export CSV',
                filename: 'Log File',
                exportOptions: {
                    columns: [0, 1, 2] // Define which columns to export (e.g., columns 0, 1, and 2)
                }
            },
            {
                extend: 'pdf', // Export as PDF
                text: 'Export PDF',
                filename: 'Log File',
                exportOptions: {
                    columns: [0, 1, 2] // Define which columns to export (e.g., columns 0, 1, and 2)
                }
            }
        ],
        columns: [
            { data: 'column1' },
            { data: 'column2' },
            { data: 'column3' }
            // Add more columns if necessary
        ]
    });

    // Add search functionality
    $('#custom-search-input').on('keyup', function() {
        dataTable.search(this.value).draw();
    });

    $('.count_secbtn a').on('click', function() {

        var selectedFormat = $(this).val();
      

     
            // Export as CSV
            dataTable.button('.buttons-csv').trigger();
        
    });
});


</script>



@endpush