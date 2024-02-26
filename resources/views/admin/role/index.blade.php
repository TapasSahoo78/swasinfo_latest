
@extends('admin.layouts.app')
@push('style')
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
@endpush
@section('pagetitlesection')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link custom-cumb">{{ __('Roles') }}</a>
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
                        <h1 class="m-0 text-dark">Roles: {{ $roleList->count() }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-4">
                        {{--  <button class="model-slide-btn" id="addbranch-btn">
                            <span><i class="fa fa-plus" aria-hidden="true"></i></span>
                            ADD Role
                        </button>  --}}
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
                        <div class="table-responsive" style="height:410px">
                        <table class="table  text-nowrap custom-data-table" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>Role Name</th>
                                        <th>Role Type</th>
                                        <th>Created On</th>
                                        {{-- <th>Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($roleList as $role)
                                        <tr>
                                            <td>{{ $role->name }}</td>
                                            <td>{{ $role->role_type }}</td>
                                            <td>{{ date('d-m-Y', strtotime($role->created_at)) }}</td>
                                           {{--  <td>
                                                @switch($role->status)
                                                    @case(1)
                                                        <a href="javascript:void(0)" data-value="0" data-table="roles"
                                                            data-message="inactive" data-uuid="{{ $role->uuid }}"
                                                            class="active-status changeStatus">Active</a>
                                                    @break

                                                    @case(0)
                                                        <a href="javascript:void(0)" data-value="1" data-uuid="{{ $role->uuid }}"
                                                            data-table="roles" data-message="active"
                                                            class="inactive-status changeStatus">Inactive</a>
                                                    @break

                                                    @default
                                                        <a href="javascript:void(0)"
                                                            class="badge badge-danger text-dark">Deleted</a>
                                                @endswitch
                                            </td> --}}

                                            <td>

                                                <div class="dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <img src="{{ asset('assets/img/three-dot-btn.png') }}"
                                                            alt="">
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item edit-permissions"
                                                            href="{{ route('admin.role.attach.permission', ['id' => $role->id]) }}">Permissions</a>
                                                    </div>
                                                </div>

                                            </td>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">No
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

        <!-- add role form -->



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
        var dataTable = $('#dataTable').DataTable({// Enable search
            searching: true,// Make the table responsive
            order: [],
            buttons: [
                    {
                        extend: 'csv', // Export as CSV
                        text: 'Export CSV',
                        exportOptions: {
                            columns: [0,1,2] // Define which columns to export (e.g., columns 0 and 2)
                        },
                        title: 'Amtron Employee Data'
                    },
                    {
                        extend: 'pdf', // Export as PDF
                        text: 'Export PDF',
                        exportOptions: {
                            columns: [0,1,2] // Define which columns to export (e.g., columns 0 and 2)
                        },
                        title: 'Amtron Employee Data'
                    }
                ],
            columns: [
                { data: 'column1' },
                { data: 'column2' },
                { data: 'column3' },
                { data: 'column4' }
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
        <!-- <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/admin/js/datatableajax.js') }}"></script> -->
        
        
    @endpush
