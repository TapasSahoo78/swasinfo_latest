@php
    $code = auth()->user()->mfi->code;
@endphp
@extends('mfi.layouts.app')
@push('style')
    {{--  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">  --}}
    <link href="//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    {{--   <link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet">  --}}
    {{--  <link href="https://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.min.css" rel="stylesheet">  --}}

    {{--   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />  --}}
    <style>
        .hh-grayBox {

            margin-bottom: 20px;
            margin-top: 20px;
        }

        .pt45 {
            padding-top: 45px;
        }

        .order-tracking {
            text-align: center;
            /* width: 25%; */
            position: relative;
            display: block;
        }

        .order-tracking .is-complete {
            display: block;
            position: relative;
            border-radius: 50%;
            height: 30px;
            width: 30px;
            border: 0px solid #AFAFAF;
            background-color: #f7be16;
            margin: 0 auto;
            transition: background 0.25s linear;
            -webkit-transition: background 0.25s linear;
            z-index: 2;
        }

        .order-tracking .is-complete:after {
            display: block;
            position: absolute;
            content: '';
            height: 14px;
            width: 7px;
            top: -2px;
            bottom: 0;
            left: 5px;
            margin: auto 0;
            border: 0px solid #AFAFAF;
            border-width: 0px 2px 2px 0;
            transform: rotate(45deg);
            opacity: 0;
        }

        .order-tracking.completed .is-complete {
            border-color: #27aa80;
            border-width: 0px;
            background-color: #27aa80;
        }

        .order-tracking.completed .is-complete:after {
            border-color: #fff;
            border-width: 0px 3px 3px 0;
            width: 7px;
            left: 11px;
            opacity: 1;
        }

        .order-tracking p {
            color: #A4A4A4;
            font-size: 16px;
            margin-top: 8px;
            margin-bottom: 0;
            line-height: 20px;
        }

        .order-tracking p span {
            font-size: 14px;
        }

        .order-tracking.completed p {
            color: #000;
        }

        .order-tracking::before {
            content: '';
            display: block;
            height: 3px;
            width: calc(100% - 40px);
            background-color: #f7be16;
            top: 13px;
            position: absolute;
            left: calc(-50% + 20px);
            z-index: 0;
        }

        .order-tracking:first-child:before {
            display: none;
        }

        .order-tracking.completed:before {
            background-color: #27aa80;
        }
    </style>
@endpush


@section('pagetitlesection')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link custom-cumb">{{ __('Demand') }}</a>
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
                        <h1 class="m-0 text-dark">No of Demand: {{ $listDemand->count() }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-4">
                        <button class="model-slide-btn" id="addbranch-btn">
                            <span><i class="fa fa-plus" aria-hidden="true"></i></span>
                            CREATE DEMAND
                        </button>
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
                            <table class="table  text-nowrap custom-data-table" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>Customer Name</th>
                                        <th>Loan Product</th>
                                        <th>Loan Amount</th>
                                        <th>Created On</th>
                                        <th>Status</th>
                                        <th>Disbursement Status</th>
                                        {{--  <th>Status</th>  --}}
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($listDemand as $demand)
                                        <tr>
                                            <td>{{ $demand->customer?->full_name }} </td>
                                            <td>{{ $demand->loan?->name }} </td>
                                            <td>{{ $demand->loan_amount }} </td>

                                            <td>{{ date('d-m-Y', strtotime($demand->created_at)) }}</td>
                                            @if ($demand->demand_status == 0)
                                                <td><a href="javascript:void(0)"
                                                        class="rejected-status updateStatus">Rejected</a></td>
                                            @elseif($demand->demand_status == 1)
                                                <td><a href="javascript:void(0)"
                                                        class="pending-status updateStatus">Pending</a></td>
                                            @elseif($demand->demand_status == 2)
                                                <td><a href="javascript:void(0)"
                                                        class="approved-status updateStatus">Approved</a></td>
                                            @elseif($demand->demand_status == 3)
                                                <td><a href="javascript:void(0)"
                                                        class="withdrawl-status updateStatus">withdrawal</a>
                                                </td>
                                            @elseif($demand->demand_status == 4)
                                                <td><a href="javascript:void(0)"
                                                        class="hold-status updateStatus">On-Hold</a>
                                                </td>
                                            @endif
                                            @if ($demand->disbursement_status == 1)
                                                <td><a href="javascript:void(0)"
                                                        class="approved-status updateStatus">Disbursed</a></td>
                                            @else
                                                <td><a href="javascript:void(0)"
                                                        class="pending-status updateStatus">Pending</a>
                                                </td>
                                            @endif

                                            <td>

                                                <div class="dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <img src="{{ asset('assets/img/three-dot-btn.png') }}"
                                                            alt="">
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item editData"
                                                            data-table="customer_demands" data-uuid="{{ $demand->uuid }}"
                                                            data-form-modal="slide-from-right"
                                                            href="javascript:void(0)">Edit</a>
                                                        <a class="dropdown-item viewStatus" data-table="customer_demands"
                                                            data-uuid="{{ $demand->uuid }}"
                                                            data-view-modal="slide-from-right-view"
                                                            href="javascript:void(0)">View Demand Status</a>

                                                        <a class="dropdown-item deleteData" data-table="customer_demands"
                                                            data-uuid="{{ $demand->uuid }}"
                                                            href="javascript:void(0)">Delete</a>
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
        <h2>Demand <span class="close-btn"><i class="fa fa-times" aria-hidden="true"></i></span></h2>

        <form action="{{ route('mfi.customer.demand.store', ['slug' => $code]) }}" class="formsubmit" method="post">

            <div class="form-group">
                <label for="agent-group">Customer <span class="text-danger">*</span></label>

                <select class="form-control" id="user_id" name="user_id">
                    <option value="">- Search Customer -</option>
                    {{-- <option value="">Select Customer</option> --}}
                    @forelse ($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->full_name }}</option>
                    @empty
                        <option value="" data-id="">{{ 'No Customers Available' }}
                        </option>
                    @endforelse
                </select>
                {{--   <input type="search" class="form-control search typeahead" value="{{ request()->search ?? '' }}"
                    placeholder="Search a Product" name="search">  --}}
                {{--  <div class="input-group-text srech-box">  --}}
                {{-- <select name="user_id" class="select2" id="user_id" data-placeholder="Select Customer">

                    <option value="">Select Customer</option>
                    @forelse ($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->full_name }}</option>
                    @empty
                        <option value="" data-id="">{{ 'No Customers Available' }}
                        </option>
                    @endforelse
                </select> --}}
                <input type="hidden" class="form-control" id="uuid" name="uuid">
                <input type="hidden" class="form-control" id="id" name="id">
            </div>
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


    <div id="slide-from-right-view" class="slide-from-right no-scroll-form">

        <h2>Status Log <span class="close-btn_view"><i class="fa fa-times" aria-hidden="true"></i></span></h2>

        <div class="container">
            <div id="loan-process-show"></div>


        </div>

        {{--   <div class="row">
            <div class="col-md-12">
                <div class="progress-track">
                    <ul id="progressbar">
                        <li class="step0 active " id="step1">Pending</li>
                        <li class="step0 active text-center" id="step2">Rejected</li>
                        <li class="step0 active text-right" id="step3">On Hold</li>
                        <li class="step0 text-right" id="step4">Approved</li>
                        <li class="step0 text-right" id="step5">Disbursed</li>
                    </ul>
                </div>
            </div>
        </div>  --}}
        {{--  <div class="row d-flex justify-content-center">
            <div class="col-12">
                <ul id="progressbar" class="text-center">
                    <li class="active step0"></li>
                    <li class="active step0"></li>
                    <li class="active step0"></li>
                    <li class="step0"></li>
                    <li class="step0"></li>
                </ul>
            </div>
        </div>  --}}

        <form action="{{ route('mfi.customer.update.demand.status', ['slug' => $code]) }}" class="formsubmit"
            method="post">
            {{--  <div class="row">
                <div class="col-md-6">

                </div>
            </div>  --}}

            <div class="single-input">
                <div class="form-group">
                    <label for="branch-name">Change Status <span class="text-danger">*</span></label>
                    <select name="demand_status" id="demand_status">
                        <option value="">Select Status</option>
                        <option value="1">Pending</option>
                        <option value="2">
                            Approved
                        </option>
                        <option value="3">
                            Withdrawl
                        </option>
                        <option value="4">
                            On-Hold
                        </option>
                        <option value="0">
                            Rejected
                        </option>
                    </select>
                    <input type="hidden" class="form-control" id="demand_id" name="demand_id">

                </div>
            </div>
            <div class="single-input" style="display:none;" id="disbursedListShow">
                <div class="form-group">
                    <label for="branch-name">Disbursement Status <span class="text-danger">*</span></label>
                    <select name="disbursement_status" id="disbursement_status">
                        <option value="">Select Disbursement Status</option>
                        <option value="0">Pending</option>
                        <option value="1">
                            Disbursed
                        </option>
                    </select>
                </div>
            </div>

            <div class="single-input">
                <div class="form-group">
                    <label for="enquery-name">Notes </label>
                    <input type="text" class="form-control" id="notes" name="notes"
                        aria-describedby="emailHelp" placeholder="Notes">

                </div>
            </div>


            <div class="btns-block">
                <button type="submit">Update</button>
            </div>
        </form>

    </div>

    <!-- add baranch form-end-->

    <!-- /.content-wrapper -->
@endsection
@push('scripts')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="{{ asset('assets/admin/js/datatableajax.js') }}"></script>
    <script src="{{ asset('assets/admin/js/group/group.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        /* var user_id= $('#user_id').val(); */
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
            $(".close-btn_view").click(function() {
                $("#slide-from-right-view").removeClass("show-side-form");
            });
            /* $('#user_id').select2();
             */
            /*  $("#user_id").select2({

                 ajax: {
                     url: '{{ route('ajax.autocomplete') }}',
                     type: "get",
                     delay: 50,
                     dataType: 'json',
                     data: function(params) {
                         return {
                             name: params.term,
                             _token: "{{ csrf_token() }}"
                         };
                     },
                     processResults: function(response) {
                         return {
                             results: $.map(response, function(item) {
                                 return {
                                     id: item.id,
                                     text: item.name
                                 }
                             })
                         };
                     },
                 }
             }) */
        });
    </script>
    {{--  <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>  --}}
    {{--  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>  --}}
    {{--  <script>
            $(document).ready(function() {
                $('#dataTable').DataTable();
            });
        </script>  --}}
    {{--    <script type="text/javascript">
        $(document).ready(function() {
            var path = "{{ route('ajax.autocomplete') }}";

            $("#user_id").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: path,
                        type: 'GET',
                        dataType: "json",
                        data: {
                            search: request.term
                        },
                        success: function(data) {
                             if (data.customer.length > 0) {
                                    response($.map(data.customer, function (item) {
                                        return {
                                            label: item.name+" - "+item.aadhaar_no+" - "+"$"+item.loan_amount+" - "+item.credit_score,
                                            val: item.uuid
                                        };
                                    }))
                                    $('#user_id').val(ui.item.uuid);
                                } else {
                                    response([{ label: 'No results found.', val: 0 }]);
                                }
                        }
                    });
                }
            });
        });
    </script>  --}}
    <script src="{{ asset('assets/admin/js/typeahead.jquery.min.js') }}" defer></script>
    <script src="{{ asset('assets/admin/js/typeahead.bundle.min.js') }}" defer></script>
    <script src="{{ asset('assets/frontend/js/ajax-custom.js') }}"></script>
    {{-- <script src="{{ asset('assets/admin/js/demand/demand.js') }}"></script> --}}
@endpush
