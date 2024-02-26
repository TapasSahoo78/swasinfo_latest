@extends('mfi.layouts.app')
@push('style')
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
@endpush
@section('pagetitlesection')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="" class="nav-link custom-cumb">{{ __('Dashboard') }}</a>
    </li>
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper p-5">


        <div class="container-fluid">
            <div class="row">

                <div class="col-md-3">
                    <div class="custom-dasboard-card">
                        <span>
                            <img src="{{ asset('assets/img/icon6.svg')}}" alt="">
                        </span>
                        <h3>{{ $totalBranches }}</h3>
                        <p>No of Branches</p>
                        <img src="{{ asset('assets/img/icon7.svg') }}" alt="">
                    </div>
                </div>


                <div class="col-md-3">
                    <div class="custom-dasboard-card">
                        <span>
                            <img src="{{ asset('assets/img/icon4.svg') }}" alt="">
                        </span>
                        <h3>{{ $totalCustomers }}</h3>
                        <p>No of Customers</p>
                        <img src="{{ asset('assets/img/icon5.svg') }}" alt="">
                    </div>
                </div>


                <div class="col-md-3">
                    <div class="custom-dasboard-card">
                        <span>
                            <img src="{{ asset('assets/img/icon2.svg') }}" alt="">
                        </span>
                        <h3>{{ $totalUsers }}</h3>
                        <p>No of Users</p>
                        <img src="{{ asset('assets/img/icon3.svg') }}" alt="">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="custom-dasboard-card">
                        <span>
                            <img src="{{ asset('assets/img/icon1.svg') }}" alt="">
                        </span>
                        <h3>{{ $totalloans }}</h3>
                        <p>No of Loan Products</p>
                        <img src="{{ asset('assets/img/icon8.svg') }}" alt="">
                    </div>
                </div>

            </div>

            <!-- loan-card -->

            <div class="card loan-cards mt-5">

                <div class="row">

                    <div class="col-md-3">
                        <div class="custom-dasboard-card only-border">
                            <h6 class="status">
                                DISBURSED
                            </h6>
                            <div class="count-data mt-4">
                                <h3>740</h3>
                                <p>No of Branches</p>
                            </div>

                            <div class="count-data mt-4">
                                <h3>₹ 2,78,54,000</h3>
                                <p>Total Amount</p>
                            </div>

                        </div>
                    </div>


                    <div class="col-md-3">
                        <div class="custom-dasboard-card only-border">
                            <h6 class="status">
                                APPROVAL PENDING
                            </h6>
                            <div class="count-data mt-4">
                                <h3>740</h3>
                                <p>No of Branches</p>
                            </div>

                            <div class="count-data mt-4">
                                <h3>₹ 2,78,54,000</h3>
                                <p>Total Amount</p>
                            </div>

                        </div>
                    </div>


                    <div class="col-md-3">
                        <div class="custom-dasboard-card only-border">
                            <h6 class="status">
                                DISBURSEMENT PENDING
                            </h6>
                            <div class="count-data mt-4">
                                <h3>740</h3>
                                <p>No of Branches</p>
                            </div>

                            <div class="count-data mt-4">
                                <h3>₹ 2,78,54,000</h3>
                                <p>Total Amount</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="custom-dasboard-card only-border">
                            <h6 class="status">
                                REJECTED / HOLD
                            </h6>
                            <div class="count-data mt-4">
                                <h3>740</h3>
                                <p>No of Branches</p>
                            </div>

                            <div class="count-data mt-4">
                                <h3>₹ 2,78,54,000</h3>
                                <p>Total Amount</p>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->


    </div>

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
@endpush
