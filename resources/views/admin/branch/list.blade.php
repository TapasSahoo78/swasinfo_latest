@extends('admin.layouts.app')
@push('style')
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
@endpush
@section('pagetitlesection')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ Route::currentRouteName() }}" class="nav-link custom-cumb">{{ __('Branch') }}</a>
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
                        <h1 class="m-0 text-dark">No of Branches: {{ $listBranch->count() }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-4">
                        <button class="model-slide-btn" id="addbranch-btn">
                            <span><i class="fa fa-plus" aria-hidden="true"></i></span>
                            ADD BRANCH
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
                            <table class="table table-head-fixed text-nowrap custom-data-table">
                                <thead>
                                    <tr>
                                        <th>Branch Name</th>
                                        <th>Branch Code</th>
                                        {{--  <th>Branch Head</th>  --}}
                                        <th>Created On</th>
                                        <th>Address</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($listBranch as $branch)
                                        <tr>
                                            <td>{{ $branch->name }}</td>
                                            <td>{{ $branch->code }}</td>
                                            {{--   <td>
                                        <div class="user-profile">
                                            <div class="img">
                                                <img src="{{asset('assets/img/user2-160x160.png')}}" alt="">
                                            </div>
                                            <p>Avijit Das</p>
                                        </div>
                                    </td>  --}}
                                            <td>{{ date('d-m-Y', strtotime($branch->created_at)) }}</td>
                                            <td>{{ $branch->full_address }}</td>
                                            <td>
                                                @switch($branch->status)
                                                    @case(1)
                                                        <a href="javascript:void(0)" data-value="0" data-table="branches"
                                                            data-message="inactive" data-uuid="{{ $branch->uuid }}"
                                                            class="badge badge-success text-dark changeStatus">Active</a>
                                                    @break

                                                    @case(0)
                                                        <a href="javascript:void(0)" data-value="1" data-uuid="{{ $branch->uuid }}"
                                                            data-table="branches" data-message="active"
                                                            class="badge badge-danger text-dark changeStatus">Inactive</a>
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
                                                        <a class="dropdown-item" href="#">Edit</a>
                                                        <a class="dropdown-item deleteData" data-table="branches"
                                                            data-uuid="{{ $branch->uuid }}"
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

        <!-- add baranch form -->

        <div id="slide-from-right" class="slide-from-right">
            <h2>Branch Name <span class="close-btn"><i class="fa fa-times" aria-hidden="true"></i></span></h2>

            <form action="{{ route('admin.branch.save') }}" class="formsubmit" method="post">

                <div class="single-input">
                    <div class="form-group">
                        <label for="branch-name">Branch Name</label>
                        <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp"
                            placeholder="Enter Branch Name">

                    </div>
                </div>

                <div class="single-input">
                    <div class="form-group">
                        <label for="branch-name">Branch Code</label>
                        <input type="text" class="form-control" name="code" id="code" aria-describedby="emailHelp"
                            placeholder="Enter Branch Code" minlength="1" maxlength="12">

                    </div>
                </div>

                <div class="multiple-input">
                    <div class="form-group">
                        <label>Address</label>
                        {{--  <input type="text" class="form-control" aria-describedby="emailHelp" placeholder="Street Address">  --}}
                        <input type="text" id="landmark" name="landmark" class="form-control" aria-describedby="emailHelp"
                            placeholder="Landmark">
                        <input type="text" id="country_name" name="country_name" class="form-control"
                            aria-describedby="emailHelp" placeholder="Country">
                        <input type="text" id="state_name" name="state_name" class="form-control"
                            aria-describedby="emailHelp" placeholder="State">
                        <input type="text" id="city_name" name="city_name" class="form-control"
                            aria-describedby="emailHelp" placeholder="City">
                        <input type="text" id="zip_code" name="zip_code" class="form-control"
                            aria-describedby="emailHelp" placeholder="Zip Code">
                        <input type="text" id="full_address" name="full_address" class="form-control"
                            aria-describedby="emailHelp" placeholder="Address">
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
