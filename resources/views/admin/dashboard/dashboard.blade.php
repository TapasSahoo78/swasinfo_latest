@extends('admin.layouts.app')
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
    <div class="content-wrapper p-5 dash_mob">

        <div class="container-fluid">
        @canany(['view-dashboard'])
            <div class="row">

                <div class="col-lg-3 col-md-6 dashcard_mob">
                    <div class="custom-dasboard-card">
                    <span>
                            <img src="{{ asset('assets/img/icon4.svg') }}" alt="">
                        </span>
                        <h3>{{ $totaluser }}</h3>
                        <p>Total Users</p>
                        <img src="{{ asset('assets/img/icon5.svg') }}" alt="">
                    </div>
                </div>


                <div class="col-lg-3 col-md-6 dashcard_mob">
                    <div class="custom-dasboard-card">
                        <span>
                            <img src="{{ asset('assets/img/icon4.svg') }}" alt="">
                        </span>
                        <h3>{{ $totalcustomer }}</h3>
                        <p>Total Customers</p>
                        <img src="{{ asset('assets/img/icon5.svg') }}" alt="">
                    </div>
                </div>


                <div class="col-lg-3 col-md-6 dashcard_mob">
                    <div class="custom-dasboard-card">
                    <span>
                            <img src="{{ asset('assets/img/icon4.svg') }}" alt="">
                        </span>
                        <h3>{{ $totaldoctor }}</h3>
                        <p>Total Doctor</p>
                        <img src="{{ asset('assets/img/icon5.svg') }}" alt="">
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 dashcard_mob">
                    <div class="custom-dasboard-card">
                    <span>
                            <img src="{{ asset('assets/img/icon4.svg') }}" alt="">
                        </span>
                        <h3>{{ $totaltrainers }}</h3>
                        <p>Total Manage Trainers & Dietitian</p>
                        <img src="{{ asset('assets/img/icon5.svg') }}" alt="">
                    </div>
                </div>

            </div>
            @endcanany
            <!-- loan-card -->

            {{-- <div class="card loan-cards mt-5">

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

            </div> --}}
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
