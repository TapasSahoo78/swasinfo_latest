@extends('vendor.layouts.app')
@push('style')
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
@endpush
@section('pagetitlesection')
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper p-5 dash_mob">

        <div class="container-fluid">
            {{-- <form action="{{ route('vendor.registraion') }}" method="get"> --}}

            <div class="row">
                <div class="col-10">
                    <div class="row">
                        <div class="col-12">
                            <fieldset>
                                <div class="col-12">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Enter Mobile Number"
                                            aria-label="Enter Mobile Number" aria-describedby="button-addon1">
                                        <button class="btn btn-success" type="button" id="button-addon1">Send</button>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Enter Email Address"
                                            aria-label="Enter Email Address" aria-describedby="button-addon2">
                                        <button class="btn btn-success" type="button" id="button-addon2">Send</button>
                                    </div>
                                </div>
                            </fieldset>
                        </div>

                        <div class="col-12">
                            <fieldset>
                                <p><strong><u>What are you looking to sell on Flipkart?</u></strong></p>
                                <div class="row gx-3">
                                    <div class="col">
                                        <button type="button" class="btn btn-secondary w-100 mb-2">All Categories</button>
                                    </div>
                                    <div class="col">
                                        <button type="button" class="btn btn-secondary w-100">Only Books(Pan is
                                            mandatory)</button>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Enter GSTIN"
                                            aria-label="Enter GSTIN" aria-describedby="button-addon3">
                                    </div>
                                    <p><strong>GSTIN is required to sell products on Flipkart. You can also share it in the
                                            final
                                            step.</strong></p>
                                </div>
                                <div class="col-12">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Enter PAN number"
                                            aria-label="Enter PAN number" aria-describedby="button-addon4">
                                    </div>
                                    <p><strong>PAN is required to sell books on Flipkart. You can also share it in the final
                                            step.</strong></p>
                                </div>
                            </fieldset>
                        </div>

                        <div class="col-12">
                            <fieldset>
                                <p><strong><u>Add Your e-Signature</u></strong></p>
                                <div class="row gx-3">
                                    <div class="col">
                                        <button type="button" class="btn btn-secondary w-100 mb-2">Draw Your
                                            e-Signature</button>
                                    </div>
                                    <div class="col">
                                        <button type="button" class="btn btn-secondary w-100">Choose your
                                            signature</button>
                                    </div>
                                </div>
                            </fieldset>
                        </div>

                        <div class="col-12">
                            <fieldset>
                                <p><strong><u>Store & Pickup Details</u></strong></p>
                                <div class="row gx-3">
                                    <div class="col">
                                        <label for="fullName">Enter Your Full Name</label>
                                        <input type="text" name="fullName" class="form-control" id="fullName"
                                            placeholder="Full Name">
                                    </div>
                                </div>
                                <div class="row gx-3">
                                    <div class="col">
                                        <label for="displayName">Enter Display Name</label>
                                        <input type="text" name="displayName" class="form-control" id="displayName"
                                            placeholder="Display Name">
                                    </div>
                                </div>
                                <div class="row gx-3">
                                    <div class="col">
                                        <label for="address">Address</label>
                                        <textarea name="address" id="address" cols="10" rows="5" class="form-control" placeholder="Address"></textarea>
                                    </div>
                                </div>
                                <div class="row gx-3">
                                    <div class="col">
                                        <label for="pickupPincode">Pickup Pincode</label>
                                        <input type="text" name="pickupPincode" class="form-control" id="pickupPincode"
                                            placeholder="Pickup Pincode">
                                    </div>
                                </div>
                            </fieldset>
                        </div>


                        <div class="col-12">
                            <fieldset>
                                <p><strong><u>Listing & Stock Availablity</u></strong></p>
                                <div class="row gx-3">
                                    <div class="col-6">
                                        <span>List products which are already available on Swasfit</span>
                                    </div>
                                    <div class="col-6">
                                        <span>
                                            <input type="text" class="form-control" name="" id="">
                                            <button type="button" class="btn btn-secondary">Search</button>
                                        </span>
                                    </div>
                                </div>
                                <div class="row">
                                    OR
                                </div>
                                <div class="row gx-3">
                                    <div class="col-6">
                                        <span>Have a new product?</span>
                                    </div>
                                    <div class="col-6">
                                        <span><button class="btn btn-secondary"
                                                onclick="window.location='{{ route('vendor.other.product.add') }}'">List
                                                your own products</button></span>
                                    </div>
                                </div>
                            </fieldset>
                        </div>



                        <div class="col-12">
                            <fieldset>
                                <p><strong><u>Bank Account Information</u></strong></p>
                                <div class="row gx-3">
                                    <div class="col">
                                        <label for="fullName">Enter Bank Account Number</label>
                                        <input type="text" name="fullName" class="form-control" id="fullName"
                                            placeholder="Full Name">
                                    </div>
                                </div>
                                <div class="row gx-3">
                                    <div class="col-12">
                                        <label for="displayName">Enter IFSC Codes</label>
                                        <input type="text" name="displayName" class="form-control" id="displayName"
                                            placeholder="Display Name">
                                        <span><a href="">Find IFSC Code</a></span>
                                    </div>

                                </div>
                            </fieldset>
                        </div>


                        {{-- <div class="col-12 mt-4">
                            <p>
                                By continuing, I agree to Flipkart’s <a href="#">Terms of Use</a> & <a
                                    href="#">Privacy Policy</a>
                            </p>
                        </div> --}}
                        <div class="col-12 mt-1 mb-5">
                            <button type="submit" class="btn btn-primary">Register & Continue</button>
                        </div>
                    </div>
                </div>
                <div class="col-2 p-8">
                    <img src="{{ asset('assets/images/office.jpg') }}" alt="">
                    <br><br><br>
                    <img src="{{ asset('assets/images/office.jpg') }}" alt="">
                    <br><br><br>
                    <img src="{{ asset('assets/images/office.jpg') }}" alt="">
                </div>
            </div>


            {{-- </form> --}}
        </div>

    </div>
    <!-- loan-card -->
    <!-- /.row -->
    </div><!-- /.container-fluid -->

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
