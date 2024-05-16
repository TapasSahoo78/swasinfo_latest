<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/bootstrap.min.css') }}">
    <!-- font awesome css -->
    <!-- <link rel="stylesheet" href="fonts/font-awesome-v6.css" /> -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/stellarnav.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/responsive.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css">
    <title>SwaasthFit</title>
    <link rel="shortcut icon" href="{{ asset('assets/vendor/images/favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('vendor/jquery-confirm.css') }}">
</head>

<body>
    <!-- Mainnav Section -->
    <div class="container">
        <div class="main-nav">
            <div class="row">
                <div class="col-md-2 col-7">
                    <div class="logo"> <a class="navbar-brand" href="index.html"><img class=""
                                src="{{ asset('assets/vendor/images/logo.png') }}" alt=""
                                title="SwaasthFiit" /></a> </div>
                </div>
                <div class="col-md-10 col-5">
                    <div id="main-nav" class="stellarnav">
                        <ul>
                            <li><a href="{{ route('frontend.home') }}" class="loginbtn">Homepage</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Mainnav Section End -->
    <!-- Connect with Section -->

    <div class="container">
        <div class="connectwith-section">
            <div class="quickcard consultationcard">
                <div id="container" class="container mt-5">
                    <div class="progress px-1" style="height: 3px;">
                        <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="step-container d-flex justify-content-between">
                        <div class="step-circle active-step" id="containers" onclick="displayStep(1)">01</div>
                        <div class="step-circle" onclick="displayStep(2)">02</div>
                        <div class="step-circle" onclick="displayStep(3)">03</div>
                        <div class="step-circle" onclick="displayStep(4)">04</div>
                        <div class="step-circle" onclick="displayStep(5)">05</div>
                    </div>
                    <div class="step-circletext">
                        <h6>Seller Agreement</h6>
                        <h6>Seller information</h6>
                        <h6>Products information</h6>
                        <h6>GST Details</h6>
                        <h6>Billing/Deposit</h6>
                    </div>
                    {{-- <form id="multi-step-form" action="#" method="POST">
                        @csrf --}}
                    <form role="form" class="multi-step-form" id="adminFrm"
                        data-action="{{ route('vendor.registration') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <!-- --------------1-start-------------------- -->
                        <div class="step step-1">
                            <!-- Step 1 form fields here -->
                            <!-- -----------step-1---------------------------- -->
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-12">
                                    <div class="step-fm-container">
                                        <h2>Set up your SwaasthFit selling account</h2>
                                        <p>Have the following available</p>
                                        <div class="round-box-section">
                                            <div class="round-box-section-inner">
                                                <div class="round-box"><img
                                                        src="{{ asset('assets/vendor/images/icon-1.png') }}"></div>
                                                <h5>Business name & address</h5>
                                            </div>
                                            <div class="round-box-section-inner">
                                                <div class="round-box"><img
                                                        src="{{ asset('assets/vendor/images/icon-2.png') }}"></div>
                                                <h5>Mobile or telephone number</h5>
                                            </div>
                                            <div class="round-box-section-inner">
                                                <div class="round-box"><img
                                                        src="{{ asset('assets/vendor/images/icon-3.png') }}"></div>
                                                <h5>Chargeable credit card &
                                                    valid bank account
                                                </h5>
                                            </div>
                                            <div class="round-box-section-inner">
                                                <div class="round-box"><img
                                                        src="{{ asset('assets/vendor/images/icon-4.png') }}"></div>
                                                <h5>Tax information</h5>
                                                <p>What does this mean?
                                                </p>
                                            </div>
                                        </div>
                                        <div class="step-frm-section">
                                            <div class="row">
                                                <h3>Legal name</h3>
                                                <div class="col-lg-12 col-md-12 col-12">
                                                    <label for="exampleInputText" class="form-label">What is a legal
                                                        name ? </label>
                                                    <input type="text" class="form-control" name="name"
                                                        id="exampleInputText">
                                                </div>
                                                <h3>Seller agreement</h3>
                                                <div class="col-lg-12 col-md-12 col-12 form-check">
                                                    <input type="checkbox" name="is_term"
                                                        class="form-check-input mt-15" id="exampleCheck1">
                                                    <label class="form-check-label" for="exampleCheck1">
                                                        <p>I have read and accepted the terms and conditions of the
                                                            <span>Amazon Services Business Solutions Agreement</span>
                                                        </p>
                                                    </label>
                                                    <p>If you are an international seller, read <span>this important
                                                            information</span></p>
                                                </div>
                                            </div>

                                            <div class="btn-section"><button type="button"
                                                    class="next-butn btn btn-next next-step">Next</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ---------------step1------------------------ -->
                        </div>
                        <!-- --------------1-end-------------------- -->
                        <!-- ---------------2-start------------------- -->
                        <div class="step step-2">
                            <!-- Step 2 form fields here -->
                            <!-- ----------------------------------- -->
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-12">
                                    <div class="step-fm-container">
                                        <h2>Tell us about your business</h2>
                                        <div class="step-frm-section">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-12">
                                                    <label for="exampleInputText" class="form-label">Business
                                                        address</label>
                                                    <input type="text" class="form-control"
                                                        name="address_line_one" id="exampleInputText"
                                                        placeholder="Address Line 1">
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-12 mt-2">
                                                    <label for="exampleInputText" class="form-label"></label>
                                                    <input type="text" class="form-control"
                                                        name="address_line_two" id="exampleInputText"
                                                        placeholder="Address Line 2">
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-12 mt-2">
                                                    <input type="text" class="form-control" name="city"
                                                        id="exampleInputText" placeholder="City/Town">
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-12 mt-2">
                                                    <input type="text" class="form-control" name="state"
                                                        id="exampleInputText" placeholder="State">
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-12 mt-2">
                                                    <input type="text" name="country" class="form-control" placeholder="country"
                                                        id="exampleInputText" placeholder="Country">
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-12 mt-2">
                                                    <input type="text" class="form-control" name="postal_code"
                                                        id="exampleInputText" placeholder="ZIP / Postal code ">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-12">
                                                    <h3>Choose your unique business display name</h3>
                                                    <label for="exampleInputText" class="form-label">What is a
                                                        business display name?</label>
                                                    <input type="text" class="form-control" name="username"
                                                        id="exampleInputText" placeholder="Enter display name">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-12">
                                                    <h3>If you sell your products online, enter your website URL
                                                        (optional)</h3>
                                                    <label for="exampleInputText" class="form-label">Why do we ask for
                                                        this?</label>
                                                    <input type="text" class="form-control" name="why_do_sell"
                                                        id="exampleInputText" placeholder="">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-12">
                                                    <label for="exampleInputText" class="form-label">Select an option
                                                        to receive a PIN to verify your phone number</label>
                                                    <div class="col-1 form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            name="inlineRadioOptions" id="inlineRadio1"
                                                            value="option1">
                                                        <label class="form-check-label"
                                                            for="inlineRadio1">Call</label>
                                                    </div>
                                                    <div class="col-1 form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            name="inlineRadioOptions" id="inlineRadio2"
                                                            value="option2">
                                                        <label class="form-check-label" for="inlineRadio2">SMS</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-12">
                                                    <label for="exampleInputText" class="form-label">Mobile
                                                        number</label>
                                                    <input type="number" name="mobile_number" class="form-control"
                                                        id="exampleInputText" placeholder="Enter your mobile number">
                                                    <p class="eg">E.g. +1 206 266 1000</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-10 col-md-10 col-12">
                                                    <label for="exampleInputText" class="form-label">SMS Verification
                                                        Language</label>
                                                    <select class="form-control" aria-label="Default select example">
                                                        <option selected>English</option>
                                                        <option value="1">One</option>
                                                        <option value="2">Two</option>
                                                        <option value="3">Three</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-2 col-md-2 col-2">
                                                    <button type="button" class="text-me" data-bs-toggle="modal"
                                                        data-bs-target="#exampleModal">
                                                        Text me Now
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-12">
                                                    <label for="exampleInputText" class="form-label">Email
                                                        Address</label>
                                                    <input type="text" name="email" class="form-control"
                                                        id="exampleInputText" placeholder="Enter your email id">
                                                    <p class="eg">E.g. info@gmail.com</p>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div
                                                    class="col-lg-12 col-md-12 col-12 two-butn-row d-flex justify-content-center">
                                                    <button type="button"
                                                        class="btn btn-next prev-step grey-butn">Back</button>
                                                    <button type="button"
                                                        class="btn btn-next next-step next-butn">Next 3</button>
                                                </div>
                                            </div>
                                        </div>
                                        <!--popup--->
                                        <div class="modal fade" id="exampleModal" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog step-popup">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h4>Enter the PIN sent to you via SMS</h4>
                                                        <div class="row">
                                                            <div class="col-lg-10 col-md-10 col-10">
                                                                <label for="exampleInputText"
                                                                    class="form-label">One-time PIN</label>
                                                                <input type="text" class="form-control"
                                                                    id="exampleInputText" placeholder="8454">
                                                                <p class="eg">Change number or want us to call
                                                                    instead? <a href="#">Cancel</a></p>
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-10">
                                                                <button type="submit" class="text-me">Verify</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--popup--->
                                    </div>
                                    <!-- ----------------------------------- -->
                                    {{-- <div class="btn-section">
                                        <button type="button" class="btn btn-next prev-step">Previous</button>
                                        <button type="button" class="btn btn-next next-step">Submit & Next3</button>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                        <!-- ---------------2-end------------------- -->
                        <!-- ---------------3--start------------------ -->
                        <div class="step step-3">
                            <!-- Step 3 form fields here -->
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-12">
                                    <div class="step-fm-container">
                                        <h2>Tell us about your products</h2>
                                        <div class="step-frm-section">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-12">
                                                    <h3>Do you have Universal Product Codes (UPCs) for all your
                                                        products?</h3>
                                                    <label for="exampleInputText" class="form-label">What is
                                                        UPC?</label>
                                                    <div class="col-1 form-check form-check-inline">
                                                        <input class="form-check-input" value="0" type="radio"
                                                            name="is_upc" id="inlineRadio1" value="option1">
                                                        <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                    </div>
                                                    <div class="col-1 form-check form-check-inline">
                                                        <input class="form-check-input" value="1" type="radio"
                                                            name="is_upc" id="inlineRadio2" value="option2">
                                                        <label class="form-check-label" for="inlineRadio2">No</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-12">
                                                    <h3>Do you own a brand? Or do you serve as an agent or
                                                        representative or manufacturer of a brand for any of the
                                                        products you want to sell on Amazon?</h3>
                                                    <label for="exampleInputText" class="form-label">What does this
                                                        mean?</label>
                                                    <div class="col-2 form-check form-check-inline">
                                                        <input class="form-check-input" value="0" type="radio"
                                                            name="is_brand" id="inlineRadio1" value="option1">
                                                        <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                    </div>
                                                    <div class="col-2 form-check form-check-inline">
                                                        <input class="form-check-input" value="1" type="radio"
                                                            name="is_brand" id="inlineRadio2" value="option2">
                                                        <label class="form-check-label" for="inlineRadio2">No</label>
                                                    </div>
                                                    <div class="col-2 form-check form-check-inline">
                                                        <input class="form-check-input" value="2" type="radio"
                                                            name="is_brand" id="inlineRadio1" value="option1">
                                                        <label class="form-check-label" for="inlineRadio1">Some of
                                                            them</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-12">
                                                    <h3>Would you also like to target business buyers by enabling
                                                        business seller features? What does this mean?</h3>
                                                    <label for="exampleInputText" class="form-label">What does this
                                                        mean?</label>
                                                    <div class="col-1 form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            name="is_target_business" value="0"
                                                            id="inlineRadio1" value="option1">
                                                        <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                    </div>
                                                    <div class="col-1 form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            name="is_target_business" id="inlineRadio2"
                                                            value="1">
                                                        <label class="form-check-label" for="inlineRadio2">No</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-12">
                                                    <h3>How many different products do you plan to list?</h3>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="how_many_products" value="1"
                                                            id="how_many_products1">
                                                        <label class="form-check-label" for="how_many_products1">
                                                            1-10
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" value="2" type="radio"
                                                            name="how_many_products" id="how_many_products2">
                                                        <label class="form-check-label" for="how_many_products2">
                                                            11-100
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" value="3" type="radio"
                                                            name="how_many_products" id="how_many_products3">
                                                        <label class="form-check-label" for="how_many_products3">
                                                            101-500
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="how_many_products" value="4"
                                                            id="how_many_products4">
                                                        <label class="form-check-label" for="how_many_products4">
                                                            More than 500
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- <div class="row">
                                                <div
                                                    class="col-lg-12 col-md-12 col-12 two-butn-row d-flex justify-content-center">
                                                    <button type="submit" class="grey-butn">Back</button>
                                                    <button type="submit" class="next-butn">Next</button>
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- --------row-option----------------- -->
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-12">
                                    <div class="step-fm-container">
                                        {{-- <h2>Tell us about your product categories. You can also add or edit your choices
                                            later</h2>
                                        <h6>Skip for now</h6>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3 col-12">
                                                <div class="product-cata-box">
                                                    <div class="product-cata-imgBox"><img
                                                            src="{{ asset('assets/vendor/images/cata-1.png') }}"
                                                            alt=""></div>
                                                    <div class="product-cata-textBox">
                                                        <h4>Fashion and apparel </h4>
                                                        <div class="fm-chk-row">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="" id="flexCheckChecked" checked>
                                                                <label class="form-check-label"
                                                                    for="flexCheckChecked">
                                                                    Remember me
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="" id="flexCheckChecked" checked>
                                                                <label class="form-check-label"
                                                                    for="flexCheckChecked">
                                                                    Remember me
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="" id="flexCheckChecked" checked>
                                                                <label class="form-check-label"
                                                                    for="flexCheckChecked">
                                                                    Remember me
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="" id="flexCheckChecked" checked>
                                                                <label class="form-check-label"
                                                                    for="flexCheckChecked">
                                                                    Remember me
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-12">
                                                <div class="product-cata-box">
                                                    <div class="product-cata-imgBox"><img
                                                            src="{{ asset('assets/vendor/images/cata-2.png') }}"
                                                            alt=""></div>
                                                    <div class="product-cata-textBox">
                                                        <h4>Health and beauty</h4>
                                                        <div class="fm-chk-row">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="" id="flexCheckChecked" checked>
                                                                <label class="form-check-label"
                                                                    for="flexCheckChecked">
                                                                    Remember me
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="" id="flexCheckChecked" checked>
                                                                <label class="form-check-label"
                                                                    for="flexCheckChecked">
                                                                    Remember me
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="" id="flexCheckChecked" checked>
                                                                <label class="form-check-label"
                                                                    for="flexCheckChecked">
                                                                    Remember me
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="" id="flexCheckChecked" checked>
                                                                <label class="form-check-label"
                                                                    for="flexCheckChecked">
                                                                    Remember me
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-12">
                                                <div class="product-cata-box">
                                                    <div class="product-cata-imgBox"><img
                                                            src="{{ asset('assets/vendor/images/cata-3.png') }}"
                                                            alt=""></div>
                                                    <div class="product-cata-textBox">
                                                        <h4>Food and beverages</h4>
                                                        <div class="fm-chk-row">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="" id="flexCheckChecked" checked>
                                                                <label class="form-check-label"
                                                                    for="flexCheckChecked">
                                                                    Remember me
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="" id="flexCheckChecked" checked>
                                                                <label class="form-check-label"
                                                                    for="flexCheckChecked">
                                                                    Remember me
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="" id="flexCheckChecked" checked>
                                                                <label class="form-check-label"
                                                                    for="flexCheckChecked">
                                                                    Remember me
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="" id="flexCheckChecked" checked>
                                                                <label class="form-check-label"
                                                                    for="flexCheckChecked">
                                                                    Remember me
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-12">
                                                <div class="product-cata-box">
                                                    <div class="product-cata-imgBox"><img
                                                            src="{{ asset('assets/vendor/images/cata-4.png') }}"
                                                            alt=""></div>
                                                    <div class="product-cata-textBox">
                                                        <h4>Sports and entertainment</h4>
                                                        <div class="fm-chk-row">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="" id="flexCheckChecked" checked>
                                                                <label class="form-check-label"
                                                                    for="flexCheckChecked">
                                                                    Remember me
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="" id="flexCheckChecked" checked>
                                                                <label class="form-check-label"
                                                                    for="flexCheckChecked">
                                                                    Remember me
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="" id="flexCheckChecked" checked>
                                                                <label class="form-check-label"
                                                                    for="flexCheckChecked">
                                                                    Remember me
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="" id="flexCheckChecked" checked>
                                                                <label class="form-check-label"
                                                                    for="flexCheckChecked">
                                                                    Remember me
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-12">
                                                <div class="product-cata-box">
                                                    <div class="product-cata-imgBox"><img
                                                            src="{{ asset('assets/vendor/images/cata-5.png') }}"
                                                            alt=""></div>
                                                    <div class="product-cata-textBox">
                                                        <h4>Consumer electronics</h4>
                                                        <div class="fm-chk-row">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="" id="flexCheckChecked" checked>
                                                                <label class="form-check-label"
                                                                    for="flexCheckChecked">
                                                                    Remember me
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="" id="flexCheckChecked" checked>
                                                                <label class="form-check-label"
                                                                    for="flexCheckChecked">
                                                                    Remember me
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="" id="flexCheckChecked" checked>
                                                                <label class="form-check-label"
                                                                    for="flexCheckChecked">
                                                                    Remember me
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="" id="flexCheckChecked" checked>
                                                                <label class="form-check-label"
                                                                    for="flexCheckChecked">
                                                                    Remember me
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-12">
                                                <div class="product-cata-box">
                                                    <div class="product-cata-imgBox"><img
                                                            src="{{ asset('assets/vendor/images/cata-6.png') }}"
                                                            alt=""></div>
                                                    <div class="product-cata-textBox">
                                                        <h4>Home appliances</h4>
                                                        <div class="fm-chk-row">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="" id="flexCheckChecked" checked>
                                                                <label class="form-check-label"
                                                                    for="flexCheckChecked">
                                                                    Remember me
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="" id="flexCheckChecked" checked>
                                                                <label class="form-check-label"
                                                                    for="flexCheckChecked">
                                                                    Remember me
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="" id="flexCheckChecked" checked>
                                                                <label class="form-check-label"
                                                                    for="flexCheckChecked">
                                                                    Remember me
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="" id="flexCheckChecked" checked>
                                                                <label class="form-check-label"
                                                                    for="flexCheckChecked">
                                                                    Remember me
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-12">
                                                <div class="product-cata-box">
                                                    <div class="product-cata-imgBox"><img
                                                            src="{{ asset('assets/vendor/images/cata-7.png') }}"
                                                            alt=""></div>
                                                    <div class="product-cata-textBox">
                                                        <h4>Category is not listed</h4>
                                                        <label for="exampleInputText" class="form-label">What is your
                                                            category?</label>
                                                        <input type="text" class="form-control"
                                                            id="exampleInputText" placeholder="Optional">
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}

                                        <div class="row">
                                            <div
                                                class="col-lg-12 col-md-12 col-12 two-butn-row d-flex justify-content-center">
                                                <button type="button"
                                                    class="btn btn-next prev-step grey-butn">Back</button>
                                                <button type="button" class="btn btn-next next-step next-butn">Next
                                                    4</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="btn-section">
                                <button type="button" class="btn btn-next prev-step">Previous</button>
                                <button type="submit" class="btn btn-next next-step">Submit & Next 4</button>
                            </div> --}}
                        </div>
                        <!-- ---------------3--end------------------ -->
                        <!-----------------4-start---------------------->
                        <div class="step step-4">
                            <!-- Step 3 form fields here -->
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-12">
                                    <div class="step-fm-container">
                                        <h2>Provide your tax information</h2>
                                        <p>Add your tax information and validate your W-9 or W-8BEN. A tax interview is
                                            required to allow your products to be purchased by Amazon customers.</p>
                                        {{-- <div class="row">
                                            <div
                                                class="col-lg-12 col-md-12 col-12 two-butn-row d-flex justify-content-center">
                                                <button type="button" class="grey-butn">Back</button>
                                                <button type="button" class="next-butn">Start</button>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-12">
                                    <div class="step-fm-container">
                                        <h2>Provide your tax information</h2>
                                        <div class="step-frm-section">
                                            <div class="row tax-info">
                                                <div class="col-lg-12 col-md-12 col-12">
                                                    <label for="exampleInputText" class="form-label">Business
                                                        classification</label>
                                                    <select class="form-control" name="tax_type"
                                                        aria-label="Default select example">
                                                        <option selected="">Select Business classification</option>
                                                        <option value="1">Individual</option>
                                                        <option value="2">Personal</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row tax-info">
                                                <h2>Tax Identity Information</h2>
                                                <div class="col-lg-6 col-md-6 col-12">
                                                    <label for="exampleInputText" class="form-label">Enter GST
                                                        Number</label>
                                                    <input type="text" name="gst_number" class="form-control"
                                                        id="exampleInputText" placeholder="Name as on bank documents">
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-12">
                                                    <label for="exampleInputText" class="form-label">CIN
                                                        Number</label>
                                                    <input type="text" name="cin_number" class="form-control"
                                                        id="exampleInputText" placeholder="CIN">
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-12">
                                                    <label for="exampleInputText" class="form-label">Pan
                                                        Number</label>
                                                    <input type="text" name="pan_number" class="form-control"
                                                        id="exampleInputText" placeholder="Enter Pan Number">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <h2>Address</h2>
                                                <div class="col-lg-6 col-md-6 col-12">
                                                    <label for="exampleInputText" class="form-label">Country</label>
                                                    <select class="form-control" name="gst_country"
                                                        aria-label="Default select example">
                                                        <option selected="">Select Country</option>
                                                        <option value="1">India</option>
                                                        <option value="2">USA</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-12">
                                                    <label for="exampleInputText" class="form-label">Re-type Pan
                                                        Number</label>
                                                    <input type="text" name="re_pan_number" class="form-control"
                                                        id="exampleInputText" placeholder="18441215848484">
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-12">
                                                    <label for="exampleInputText" class="form-label">Street and
                                                        Number</label>
                                                    <input type="text" name="street_number" class="form-control"
                                                        id="exampleInputText" placeholder="18441215848484">
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-12">
                                                    <label for="exampleInputText" class="form-label">Apartment, unit,
                                                        building etc.</label>
                                                    <input type="text" name="apartment_number"
                                                        class="form-control" id="exampleInputText"
                                                        placeholder="18441215848484">
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-12">
                                                    <label for="exampleInputText" class="form-label">City or
                                                        town</label>
                                                    <input type="text" name="gst_city" class="form-control"
                                                        id="exampleInputText" placeholder="18441215848484">
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-12">
                                                    <label for="exampleInputText" class="form-label">State</label>
                                                    <input type="text" name="gst_state" class="form-control"
                                                        id="exampleInputText" placeholder="18441215848484">
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-12">
                                                    <label for="exampleInputText" class="form-label">Zip Code</label>
                                                    <input type="text" name="gst_postal_code" class="form-control"
                                                        id="exampleInputText" placeholder="18441215848484">
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-12 form-check">
                                                    <input type="checkbox" name="is_signature" value="1"
                                                        class="form-check-input mt-15" id="exampleCheck1">
                                                    <label class="form-check-label" for="exampleCheck1">
                                                        <p> I consent to provide electronic signature for the
                                                            information provided as per IRS Form
                                                            W-9
                                                        </p>
                                                    </label>
                                                    <p>If you provide an electronic signature, you will be able to
                                                        submit your tax information
                                                        immediately.
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="intro-gry-box">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-12">
                                                        <h2>Under penalties of perjury, I certify that: </h2>
                                                        <ul>
                                                            <li>1. The number shown on this form is my correct taxpayer
                                                                identification number (or I am
                                                                waiting for a number to be issued to me), and
                                                            </li>
                                                            <li> 2. I am not subject to backup withholding because: (a)
                                                                I am exempt from backup
                                                                withholding, or (b) I have not been notified by the
                                                                Internal Revenue Service (IRS) that I
                                                                am subject to backup withholding as a result of a
                                                                failure to report all interest or
                                                                dividends, or (c) the IRS has notified me that I am no
                                                                longer subject to backup
                                                                withholding, and
                                                            </li>
                                                            <li>3. I am a U.S. citizen or other U.S. person (defined in
                                                                the instructions), and</li>
                                                            <li>4. The FATCA code(s) entered on this form (if any)
                                                                indicating that I am exempt from
                                                                FATCA reporting is correct. (Amazon as a U.S.
                                                                withholding agent does not request this
                                                                information for the type of payments being received)
                                                            </li>
                                                        </ul>
                                                        <p><b>The Internal Revenue Service does not require your consent
                                                                to any provision of this document other than the
                                                                certifications required to avoid backup withholding.</b>
                                                        </p>
                                                        <p>Certification Instructions: You must cross out item 2 above
                                                            if you have been notified by the IRS that you are currently
                                                            subject to backup withholding. You will need to print out
                                                            your hard copy form at the end of the interview and cross
                                                            out item 2 before signing and mailing to the address
                                                            provided. </p>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-12">
                                                        <label for="exampleInputText" class="form-label">Upload
                                                            Signature</label>
                                                        <div class="photocard mb-3">
                                                            {{-- signature --}}
                                                            <div class="photocard-icon"><img
                                                                    src="{{ asset('assets/vendor/images/write.png') }}"
                                                                    alt=""></div>
                                                            <p><a href="#" class="addimage-btn">Upload
                                                                    Signature<input type="file" id="myFile"
                                                                        name=""></a></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-12">
                                                        <label for="exampleInputText" class="form-label">Date</label>
                                                        <div id="datepicker" class="input-group">
                                                            <input type="date" name="signature_date"
                                                                class="form-control" id="exampleInputEmail1"
                                                                placeholder="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div
                                                    class="col-lg-12 col-md-12 col-12 two-butn-row d-flex justify-content-center">
                                                    <button type="button"
                                                        class="btn btn-next prev-step grey-butn">Back</button>
                                                    <button type="button"
                                                        class="btn btn-next next-step next-butn">Next 5</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- ---------------step1------------------------ -->
                                {{-- <div class="btn-section"><button type="button" class="btn btn-next next-step">Submit
                                        & Next2</button>
                                </div> --}}
                            </div>
                            {{-- <div class="btn-section">
                                <button type="button" class="btn btn-next prev-step grey-butn">Previous</button>
                                <button type="button" class="btn btn-next next-step next-butn">Submit & Next5</button>
                            </div> --}}
                        </div>
                        <!-----------------4-end---------------------->
                        <!----------------5-start--------------------->
                        <div class="step step-5">
                            <!-- Step 3 form fields here -->
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-12">
                                    <div class="step-fm-container">
                                        <h2>Set up your billing method</h2>
                                        <div class="step-frm-section">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-12">
                                                    <h3>Your selling plan:</h3>
                                                    <p>Professional selling plan</p>
                                                    <h3>Your credit card information</h3>
                                                    <p>Your first monthly subscription fee ($39.99) will be charged upon
                                                        account creation. You'll be able to list products after we
                                                        perform payment validation, which typically takes an hour (but
                                                        could take up to 24
                                                        hours).
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="row tax-info">
                                                <div class="col-lg-6 col-md-6 col-12">
                                                    <label for="exampleInputText" class="form-label">Card Number
                                                    </label>
                                                    <input type="text" name="card_number" class="form-control"
                                                        id="exampleInputText" placeholder="Card Number">
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-12">
                                                    <label for="exampleInputText" class="form-label">Valid
                                                        through(Month)
                                                    </label>
                                                    <input type="text" name="valid_month" class="form-control"
                                                        id="exampleInputText" placeholder="01">
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-12">
                                                    <label for="exampleInputText" class="form-label">Valid
                                                        through(Year)
                                                    </label>
                                                    <input type="text" name="valid_yaer" class="form-control"
                                                        id="exampleInputText" placeholder="2025">
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-12">
                                                    <label for="exampleInputText" class="form-label">Cardholder's
                                                        Name</label>
                                                    <input type="text" name="card_holder" class="form-control"
                                                        id="exampleInputText" placeholder="Cardholder's Name">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <h2>Set up your deposit method</h2>
                                                <p>Enter your bank information to receive payments from Amazon <br>
                                                    <span>Why do we ask for your bank information?</span>
                                                </p>
                                                <div class="col-lg-6 col-md-6 col-12">
                                                    <label for="exampleInputText" class="form-label">Bank
                                                        Location</label>
                                                    <input type="text" name="bank_location" class="form-control"
                                                        id="exampleInputText" placeholder="Name as on bank documents">
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-12"></div>
                                                <div class="col-lg-6 col-md-6 col-12">
                                                    <label for="exampleInputText" class="form-label">Account Holder's
                                                        Name</label>
                                                    <input type="text" name="account_holder" class="form-control"
                                                        id="exampleInputText" placeholder="Name as on bank documents">
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-12">
                                                    <label for="exampleInputText" class="form-label">IFSC CODE</label>
                                                    <input type="text" name="ifsc_code" class="form-control"
                                                        id="exampleInputText" placeholder="9 digits">
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-12">
                                                    <label for="exampleInputText" class="form-label">Bank Account
                                                        Number</label>
                                                    <input type="text" name="bank_account_number"
                                                        class="form-control" id="exampleInputText"
                                                        placeholder="18441215848484">
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-12">
                                                    <label for="exampleInputText" class="form-label">Re-type Bank
                                                        Account Number</label>
                                                    <input type="text" name="re_account_number"
                                                        class="form-control" id="exampleInputText"
                                                        placeholder="18441215848484">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div
                                                    class="col-lg-12 col-md-12 col-12 two-butn-row d-flex justify-content-center">
                                                    <button type="button"
                                                        class="btn btn-next prev-step grey-butn">Back</button>
                                                    <button type="submit" class="next-butn">Finish</button>
                                                </div>
                                            </div>
                                        </div>
                                        <!--popup--->
                                        <div class="modal fade" id="exampleModal" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog step-popup">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h4>Enter the PIN sent to you via SMS</h4>
                                                        <div class="row">
                                                            <div class="col-lg-10 col-md-10 col-10">
                                                                <label for="exampleInputText"
                                                                    class="form-label">One-time PIN</label>
                                                                <input type="text" class="form-control"
                                                                    id="exampleInputText" placeholder="8454">
                                                                <p class="eg">Change number or want us to call
                                                                    instead? <a href="#">Cancel</a></p>
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-10">
                                                                <button type="submit" class="text-me">Verify</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--popup--->
                                    </div>
                                    <!-- ----------------------------------- -->
                                    {{-- <div class="btn-section">
                                        <button type="button" class="btn btn-next prev-step">Previous</button>
                                        <button type="button" class="btn btn-next next-step">Submit & Next3</button>
                                    </div> --}}
                                </div>
                            </div>
                            {{-- <div class="btn-section">
                                <button type="button" class="btn btn-next prev-step">Previous</button>
                                <button type="submit" class="btn btn-submit">Submit</button>
                            </div> --}}
                        </div>
                        <!----------------5-end--------------------->
                    </form>
                </div>
            </div>
        </div>

        <div class="slider-section">
            <h2>Onboarding Video</h2>



            <div class="owl-carousel owl-theme slider-section-one">

                <div class="item">

                    <img src="{{ asset('assets/vendor/images/vd-1.png') }}">
                </div>



                <div class="item">

                    <img src="{{ asset('assets/vendor/images/vd-2.png') }}">



                </div>

                <div class="item">

                    <img src="{{ asset('assets/vendor/images/vd-3.png') }}">

                </div>
                <div class="item">

                    <img src="{{ asset('assets/vendor/images/vd-1.png') }}">

                </div>
                <div class="item">

                    <img src="{{ asset('assets/vendor/images/vd-2.png') }}">

                </div>
                <div class="item">

                    <img src="{{ asset('assets/vendor/images/vd-3.png') }}">

                </div>
                <div class="item">

                    <img src="{{ asset('assets/vendor/images/vd-2.png') }}">

                </div>
            </div>






        </div>

        <div class="slider-section">
            <h2>Seller Review</h2>



            <div class="owl-carousel owl-theme slider-section-two">

                <div class="item">

                    <img src="{{ asset('assets/vendor/images/vd-4.png') }}">
                </div>



                <div class="item">

                    <img src="{{ asset('assets/vendor/images/vd-5.png') }}">



                </div>

                <div class="item">

                    <img src="{{ asset('assets/vendor/images/vd-6.png') }}">

                </div>
                <div class="item">

                    <img src="{{ asset('assets/vendor/images/vd-4.png') }}">

                </div>
                <div class="item">

                    <img src="{{ asset('assets/vendor/images/vd-5.png') }}">

                </div>
                <div class="item">

                    <img src="{{ asset('assets/vendor/images/vd-6.png') }}">

                </div>
                <div class="item">

                    <img src="{{ asset('assets/vendor/images/vd-4.png') }}">

                </div>
            </div>






        </div>

    </div>
    <!-- Connect with Section End -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="footer-logo">
                        <a href="">
                            <img src="{{ asset('assets/vendor/images/ft-logo.png') }}" class="img-fluid"
                                alt="">
                        </a>
                    </div>
                    <ul class="socials">
                        <li><a href=""><img src="{{ asset('assets/vendor/images/f-1.png') }}"
                                    class="img-fluid" alt=""></a></li>
                        <li><a href=""><img src="{{ asset('assets/vendor/images/f-2.png') }}"
                                    class="img-fluid" alt=""></a></li>
                        <li><a href=""><img src="{{ asset('assets/vendor/images/f-3.png') }}"
                                    class="img-fluid" alt=""></a></li>
                    </ul>
                </div>
                <div class="col-lg-8 col-md-8 col-12">
                    <div class="right-footer">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-12">
                                <h4>Company</h4>
                                <ul>
                                    <li><a href="">About Us</a></li>
                                    <li><a href="">Become a Coach</a></li>
                                    <li><a href="">Help & Support</a></li>
                                    <li><a href="">Contact Us</a></li>
                                </ul>
                            </div>
                            <div class="col-lg-4 col-md-4 col-12">
                                <h4>Services</h4>
                                <ul>
                                    <li><a href="">Online Coaching</a></li>
                                    <li><a href="">Workout & Diet</a></li>
                                    <li><a href="">Trainer Assistance</a></li>
                                    <li><a href="">Health & Wellness Awarness</a></li>
                                </ul>
                            </div>
                            <div class="col-lg-4 col-md-4 col-12">
                                <h4>Legal</h4>
                                <ul>
                                    <li><a href="">Terms & Conditions</a></li>
                                    <li><a href="">Privacy Policy</a></li>
                                    <li><a href="">Refund Policy</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <p>&#169;SwaasthFiit 2023</p>
        </div>
    </footer>
    <div class="go-top"><i class="fa fa-angle-double-up" aria-hidden="true"></i></div>
    <script src="{{ asset('assets/vendor/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/stellarnav.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/owl.carousel.min.js') }}"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
    <script src="{{ asset('assets/vendor/js/WOW.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/custom.js') }}"></script>
    <script src="{{ asset('vendor/form-common.js') }}"></script>
    <script src="{{ asset('vendor/jquery-confirm.js') }}"></script>
    <script>
        var currentStep = 1;
        var updateProgressBar;

        function displayStep(stepNumber) {
            if (stepNumber >= 1 && stepNumber <= 5) {
                $(".step-" + currentStep).hide();
                $(".step-" + stepNumber).show();
                currentStep = stepNumber;
                updateProgressBar();
            }
        }

        $(document).ready(function() {


            // Current step tracking
            var currentStep = 1;

            // Function to validate each step
            // function validateStep(step) {
            //     // Implement validation logic for each step here
            //     var isValid = true;
            //     if (step === 1) {
            //         // Example: Validate step 1 fields
            //         if ($('#exampleInputText').val() === '') {
            //             isValid = false;
            //         }
            //         // Add more validation logic for step 1 fields
            //     } else if (step === 2) {
            //         // Example: Validate step 2 fields
            //         if ($('#exampleInputText').val() === '') {
            //             isValid = false;
            //         }
            //         // Add more validation logic for step 2 fields
            //     } else if (step === 3) {
            //         // Example: Validate step 2 fields
            //         if ($('#exampleInputText').val() === '') {
            //             isValid = false;
            //         }
            //         // Add more validation logic for step 2 fields
            //     } else if (step === 4) {
            //         // Example: Validate step 2 fields
            //         if ($('#exampleInputText').val() === '') {
            //             isValid = false;
            //         }
            //         // Add more validation logic for step 2 fields
            //     }
            //     return isValid;
            // }

            function validateStep(step) {
                var isValid = true;
                $(".step-" + step + " input").each(function() {
                    if ($(this).val() === '') {
                        isValid = false;
                        $(this).addClass("invalid-field"); // Add a class to mark invalid fields
                    } else {
                        $(this).removeClass("invalid-field"); // Remove the class if field is valid
                        $(this).css("border-color",
                            "black");
                    }
                });
                return isValid;
            }


            $('.multi-step-form').find('.step').slice(1).hide();

            $(".next-step").click(function() {
                // if (validateStep(currentStep)) {
                // $(".step-" + currentStep + " .invalid-field").css("border-color",
                //     "black");
                // $(".step-" + currentStep + " .invalid-field").removeClass("invalid-field");
                if (currentStep < 5) {
                    $(".step-" + currentStep).addClass("animate__animated animate__fadeOutLeft");
                    currentStep++;
                    setTimeout(function() {
                        $(".step").removeClass("animate__animated animate__fadeOutLeft").hide();
                        $(".step-" + currentStep).show().addClass(
                            "animate__animated animate__fadeInRight");
                        updateProgressBar();
                    }, 500);
                }
                // } else {
                //     // alert('Please fill in all required fields.');
                //     $(".step-" + currentStep + " .invalid-field").css("border-color",
                //         "red"); // Outline invalid fields in red
                // }
            });

            $(".prev-step").click(function() {
                if (currentStep > 1) {
                    $(".step-" + currentStep).addClass("animate__animated animate__fadeOutRight");
                    currentStep--;
                    setTimeout(function() {
                        $(".step").removeClass("animate__animated animate__fadeOutRight").hide();
                        $(".step-" + currentStep).show().addClass(
                            "animate__animated animate__fadeInLeft");
                        updateProgressBar();
                    }, 500);
                }
            });

            updateProgressBar = function() {
                var progressPercentage = ((currentStep - 1) / 2) * 50;
                $(".progress-bar").css("width", progressPercentage + "%");
            }
        });

        $('.active-step').click(function() {
            $('#containers').append('<i class="fa fa-check" aria-hidden="true"></i>');
        });
    </script>
</body>

</html>
