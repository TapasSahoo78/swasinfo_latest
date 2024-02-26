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
        <a href="#" class="nav-link custom-cumb">{{ __('Disburstment') }}</a>
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
                        <h1 class="m-0 text-dark">No of Disburstment: {{ $listDemand->count() }}</h1>
                    </div><!-- /.col -->
                   <!-- /.col -->
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
                                        <th>Disbursement Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($listDemand as $demand)
                                        <tr>
                                            <td>{{ $demand->customer?->full_name }} </td>
                                            <td>{{ $demand->loan?->name }} </td>
                                            <td>{{ $demand->loan_amount }} </td>
                                            <td>{{ date('d-m-Y', strtotime($demand->created_at)) }}</td>
                                            @if ($demand->disbursement_status == 1)
                                                <td><a href="javascript:void(0)"
                                                        class="approved-status updateStatus">Disbursed</a></td>
                                            @else
                                                <td><a href="javascript:void(0)"
                                                        class="pending-status updateStatus">Pending</a>
                                                </td>
                                            @endif

                                           
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

    

    <!-- add baranch form-end-->

    <!-- /.content-wrapper -->
@endsection
@push('scripts')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="{{ asset('assets/admin/js/datatableajax.js') }}"></script>
    <script src="{{ asset('assets/admin/js/group/group.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
   {{--   <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" defer></script>
    <script src="https://code.jquery.com/jquery-migrate-3.0.0.min.js"></script>  --}}
  
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
    {{--  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>  --}}
    {{--  <script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>  --}}

    {{--  <script src="https://code.jquery.com/ui/1.10.2/jquery-ui.min.js"></script>  --}}
     <script src="{{ asset('assets/admin/js/typeahead.bundle.min.js') }}"></script>
     <script src="{{ asset('assets/admin/js/typeahead.jquery.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/typeGlobalSearch.js') }}"></script>
@endpush
