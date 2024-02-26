@php
    $code = Auth::user()->mfi->code;
@endphp
@extends('mfi.layouts.app')
@push('style')
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
@endpush
@section('pagetitlesection')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link custom-cumb">{{ __('Account') }}</a>
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
                        <h1 class="m-0 text-dark">No of Accounts: {{ $listAccount->count() }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-4">
                        @can('add-accounts')
                            <button class="model-slide-btn" id="addbranch-btn">
                                <span><i class="fa fa-plus" aria-hidden="true"></i></span>
                                ADD ACCOUNT
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
                            <table class="table  text-nowrap custom-data-table">
                                <thead>
                                    <tr>
                                        <th>Account Type</th>
                                        {{-- <th>Account Sub Type</th> --}}
                                        <th>Account Name</th>
                                        <th>Opening Balance</th>
                                        <th>Created On</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($listAccount as $account)
                                        <tr {{ $account->status == 1 ? 'active-row' : 'inactive-row' }}>
                                            @if ($account->account_type == 1)
                                                <td>{{ 'Assets Account' }}</td>
                                            @else
                                                <td>{{ 'Liabilities Account' }}</td>
                                            @endif

                                            <td>{{ $account->account_name }}</td>
                                            <td>₹{{ $account->opening_balance }}</td>
                                            {{--   <td>
                                        <div class="user-profile">
                                            <div class="img">
                                                <img src="{{asset('assets/img/user2-160x160.png')}}" alt="">
                                            </div>
                                            <p>Avijit Das</p>
                                        </div>
                                    </td>  --}}
                                            <td>{{ date('d-m-Y', strtotime($account->created_at)) }}</td>
                                            <td>
                                                @switch($account->status)
                                                    @case(1)
                                                        <a href="javascript:void(0)" data-value="0" data-table="accounts"
                                                            data-message="inactive" data-uuid="{{ $account->uuid }}"
                                                            class="active-status changeStatus ">Active</a>
                                                    @break

                                                    @case(0)
                                                        <a href="javascript:void(0)" data-value="1" data-uuid="{{ $account->uuid }}"
                                                            data-table="accounts" data-message="active"
                                                            class="inactive-status changeStatus ">Inactive</a>
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
                                                        @can('edit-accounts')
                                                            <a class="dropdown-item editData" data-table="accounts"
                                                                data-uuid="{{ $account->uuid }}"
                                                                data-form-modal="slide-from-right"
                                                                href="javascript:void(0)">Edit</a>
                                                        @endcan
                                                        @can('delete-accounts')
                                                            <a class="dropdown-item deleteData" data-table="accounts"
                                                                data-uuid="{{ $account->uuid }}"
                                                                href="javascript:void(0)">Delete</a>
                                                        @endcan
                                                    </div>
                                                </div>

                                            </td>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No
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
            <h2>Account  <span id="close-btn"><i class="fa fa-times" aria-hidden="true"></i></span></h2>

            <form action="{{ route('mfi.administrator.account.save', ['slug' => $code]) }}" class="formsubmit" method="post">
                <div class="single-input">
                    <div class="form-group">
                        <label for="branch-name">Branch<span class="text-danger">*</span></label>
                        <select name="branch_id" id="branch_id">
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
                        <input type="hidden" class="form-control" id="uuid" name="uuid">
                        <input type="hidden" class="form-control" id="id" name="id">
                    </div>
                </div>
                <div class="single-input">
                    <div class="form-group">
                        <label for="branch-name">Account Type <span class="text-danger">*</span></label>
                        <select name="account_type" id="account_type">
                            <option value="">Select Account</option>
                            <option value="1">Assets Account</option>
                            <option value="2">Liabilities Account</option>
                        </select>
                        {{-- <span class="text-danger text-sm errAcntType" style="display:none">Please Choose Account Type</span> --}}

                    </div>
                </div>
                {{-- <button type="button" class="btn btn-warning create" style="display:none">Create</button> --}}
                {{--  <div class="single-input accountSubType" style="display: none;">
                    <div class="form-group">
                        <label for="branch-name">Account Sub Type <span class="text-danger">*</span></label>
                        <select name="account_sub_type" id="account_sub_type" class="type">
                            <option value="">Select Account</option>
                            <option value="1">Bank Account</option>
                            <option value="2">Cash Account</option>
                            <option value="3">UPI Account</option>
                        </select>
                    </div>
                </div> --}}
                <div class="single-input">
                    <div class="form-group">
                        <label for="branch-name"><span class="loan_account">Account Name</span> <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="account_name" name="account_name"
                            aria-describedby="emailHelp" placeholder='Enter Account Name'>
                    </div>
                </div>
                {{-- <div class="single-input accountNumber bankSection" id="accounts_number" >
                    <div class="form-group">
                        <label for="branch-name"><span class="loan_account_num">Account Number</span> <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="account_number" id="account_number"
                            aria-describedby="emailHelp" placeholder="Enter Account Number"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');">
                    </div>
                </div> --}}
                {{-- <div class="single-input accountIfscNo bankSection" id="ifsc" style="display: none;">
                    <div class="form-group">
                        <label for="branch-name">IFSC Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="ifsc_code" name="ifsc_code"
                            aria-describedby="emailHelp" placeholder="Enter IFSC Code">
                    </div>
                </div>
                <div class="single-input accountHolderName bankSection" id="holder_name" style="display: none;">
                    <div class="form-group">
                        <label for="branch-name">Account Holder Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="account_holder_name" name="account_holder_name"
                            aria-describedby="emailHelp" placeholder="Account Holder Name">
                    </div>
                </div>
                <div class="single-input upiNo upiSection" id="upi_no" style="display: none;">
                    <div class="form-group">
                        <label for="upi_id">UPI Id <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="upi_id" name="upi_id"
                            aria-describedby="emailHelp" placeholder="Enter UPI Id">
                    </div>
                </div> --}}
                <div class="single-input">
                    <div class="form-group">
                        <label for="opening_balance">Opening Balance <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="opening_balance" id="opening_balance"
                            aria-describedby="emailHelp" placeholder="Enter Opening Balance"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');">
                    </div>
                </div>
                <div class="single-input">
                    <div class="form-group">
                        <label for="agent-group">Note</label>
                        <textarea rows="5" cols="30" class="form-control" name="note" id="note"></textarea>
                    </div>
                </div>
                <div class="btns-block no-scroll-btns">
                    <button type="submit">ADD</button>
                    <button type="reset" class="btn_reset">RESET</button>
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
                    $(".create").show();
                    $("#slide-from-right").addClass("add-form");
                    $("#slide-from-right").addClass("show-side-form");
                    $("#slide-from-right").find('button[type="reset"]').html('Reset');
                    $("#slide-from-right").find('button[type="reset"]').removeClass('reload');
                });

                $("#close-btn").click(function() {
                    $("#slide-from-right").removeClass("show-side-form");
                });
            });
        </script>
       {{--  <script>
            $('.custom-data-table').on('click', '.accountEditForm', function(e) {
                var $this = $(this);
                var uuid = $this.data('uuid');
                var find = $this.data('table');
                var formModal = $this.data('form-modal');
                var message = $this.data('message') ?? 'test message';

                $.ajax({
                    type: "get",
                    url: baseUrl + 'ajax/edit-data',
                    data: {
                        'uuid': uuid,
                        'find': find
                    },
                    cache: false,
                    dataType: "json",
                    beforeSend: function() {

                    },
                    success: function(response) {
                        if (response.status) {
                            let update = $("#" + formModal).find('button[type="submit"]').html('Update');
                            $.each(response.data, function(index, valueMessage) {
                                console.log(index);
                                $("#" + index).val(valueMessage);
                                if (index == 'account_sub_type') {
                                    switch (valueMessage) {
                                        case '1':
                                            $('#accounts_number,#ifsc,#holder_name').show();
                                            $('#upi_no').hide();
                                            break;
                                        case '2':
                                            $('#accounts_number,#ifsc,#holder_name,#upi_no').hide();
                                            break;

                                        default:
                                            $('#accounts_number,#ifsc,#holder_name').hide();
                                            $('#upi_no').show();
                                            break;
                                    }
                                }
                            });
                            var account_sub_type = $('#account_sub_type').val();
                            var account_type = $('#account_type').val();
                            if (account_type == 2) {
                                var msg = 'Loan';
                            } else {
                                var msg = '';
                            }
                            if (account_sub_type == '1') {
                                var message = msg + ' Bank Account Name';
                                var accountNum = msg + ' Bank Account Number';
                            } else if (account_sub_type == '2') {
                                var message = msg + ' Cash Account Name';
                                var accountNum = msg + ' Cash Account Number';
                            } else if (account_sub_type == '3') {
                                var message = msg + 'UPI Account Name';
                                var accountNum = msg + ' UPI Account Number';
                            } else {
                                var message = '';
                                var accountNum = '';
                            }
                            $(".loan_account").text(message);
                            $(".loan_account_num").text(accountNum);
                            $('#account_name').attr("placeholder", message);
                            $('#account_number').attr("placeholder", accountNum);

                            $("#" + formModal).addClass("show-side-form");
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'We are facing some technical issue now.',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                    },
                    error: function(response) {
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
            });
        </script> --}}

        <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/admin/js/datatableajax.js') }}"></script>
        {{-- <script src="{{ asset('assets/admin/js/account/account.js') }}"></script> --}}
    @endpush
