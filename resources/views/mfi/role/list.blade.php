@php
    $code = Auth::user()->mfi->code;
@endphp
@extends('mfi.layouts.app')
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
                        <h1 class="m-0 text-dark">Roles: {{ $mfiRoles->count() }}</h1>
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
                            <table class="table text-nowrap custom-data-table" id="roleTable">
                                <thead>
                                    <tr>
                                        <th>Role Name</th>
                                        <th>Role Description</th>
                                        {{--  <th>Branch Head</th>  --}}
                                        <th>Created On</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($mfiRoles as $role)
                                        <tr>
                                            <td>{{ $role->role->name }}</td>
                                            <td>{{ !empty($role->role->description) ? $role->role->description : '---' }}</td>

                                            <td>{{ date('d-m-Y', strtotime($role->role->created_at)) }}</td>
                                            <td>
                                                @switch($role->status)
                                                    @case(1)
                                                        <a href="javascript:void(0)" data-value="0" data-table="mfi_roles"
                                                            data-message="inactive" data-uuid="{{ $role->id }}" data-mfiroleid="{{ $role->id }}"
                                                            class="active-status changeStatus">Active</a>
                                                    @break

                                                    @case(0)
                                                        <a href="javascript:void(0)" data-value="1" data-uuid="{{ $role->id }}" data-mfiroleid="{{ $role->id }}"
                                                            data-table="mfi_roles" data-message="active"
                                                            class="inactive-status changeStatus">Inactive</a>
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
                                                        <a class="dropdown-item editData" data-table="roles"
                                                            data-uuid="{{ $role->role->uuid }}"
                                                            data-form-modal="slide-from-right"
                                                            href="javascript:void(0)">Edit</a>
                                                        <a class="dropdown-item edit-permissions"
                                                            href="{{ route('mfi.administrator.role.attach.permission', ['slug' => $slug, 'id' => $role->role->id]) }}">Permissions</a>
                                                        <a class="dropdown-item deleteData" data-table="roles"
                                                            data-uuid="{{ $role->role->uuid }}"
                                                            href="javascript:void(0)">Delete</a>
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

        <!-- add role form -->

        <div id="slide-from-right" class="slide-from-right">
            <h2>Role<span class="close-btn"><i class="fa fa-times" aria-hidden="true"></i></span></h2>

            <form action="{{ route('mfi.administrator.role.save', ['slug' => $code]) }}" class="formsubmit" method="post">
                <div class="single-input">
                    <div class="form-group">
                        <label for="branch-name">Role Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp"
                            placeholder="Enter Role Name">
                        <input type="hidden" class="form-control" id="uuid" name="uuid">
                        <input type="hidden" class="form-control" id="id" name="id">


                    </div>
                </div>

                <div class="single-input">
                    <div class="form-group">
                        <label for="branch-name">Role Description <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="description" name="description"
                            aria-describedby="emailHelp" placeholder="Enter Description">
                    </div>
                </div>


                {{--  <select name="cars" id="cars">
                    <option value="volvo">City</option>
                    <option value="saab">Saab</option>
                    <option value="mercedes">Mercedes</option>
                    <option value="audi">Audi</option>
                </select>

                <select name="cars" id="cars">
                    <option value="volvo">State</option>
                    <option value="saab">Saab</option>
                    <option value="mercedes">Mercedes</option>
                    <option value="audi">Audi</option>
                </select>
            </div>

            <div class="single-input">
                <label>Select Branch Head</label>
                <select name="cars" id="cars">
                    <option value="volvo">- select -</option>
                    <option value="saab">Saab</option>
                    <option value="mercedes">Mercedes</option>
                    <option value="audi">Audi</option>
                </select>
            </div>  --}}

                <div class="btns-block">
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
    @endpush
