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
                        @include('vendor.pages.onboarding.step-one')
                        <!-- --------------1-end-------------------- -->
                        <!-- ---------------2-start------------------- -->
                        @include('vendor.pages.onboarding.step-two')
                        <!-- ---------------2-end------------------- -->
                        <!-- ---------------3--start------------------ -->
                        @include('vendor.pages.onboarding.step-three')
                        <!-- ---------------3--end------------------ -->
                        <!-----------------4-start---------------------->
                        @include('vendor.pages.onboarding.step-four')
                        <!-----------------4-end---------------------->
                        <!----------------5-start--------------------->
                        @include('vendor.pages.onboarding.step-five')
                        <!----------------5-end--------------------->
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal -->
        {{-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog step-popup">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h4>Enter the PIN sent to you via SMS</h4>
                        <div class="row">
                            <div class="col-lg-10 col-md-10 col-10">
                                <label for="otpInput" class="form-label">One-time
                                    PIN</label>
                                <input type="text" class="form-control" id="otpInput" placeholder="8454">
                                <p class="eg">Change number or want us to call
                                    instead? <a href="#">Cancel</a></p>
                                <div id="errorMessage" class="text-danger" style="display: none;">Incorrect OTP,
                                    please
                                    try again.</div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-2">
                                <button type="button" class="btn btn-success text-me"
                                    id="verifyOtpButton">Verify</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

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

    @include('vendor.layouts.partials.footer')

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

        document.getElementById('textMeButton').addEventListener('click', function(event) {
            var mobileNumber = document.getElementById('mobileNumber').value;
            if (mobileNumber.trim() === "") {
                alert("Please enter your mobile number.");
                return;
            }

            // Generate OTP input field and Verify button
            var otpSection = document.getElementById('verifyOtp');
            otpSection.innerHTML = `
                <div class="col-lg-10 col-md-10 col-10">
                    <label for="otpInput" class="form-label">One-time PIN</label>
                    <input type="text" class="form-control" id="otpInput" placeholder="Enter OTP">
                    <p id="errorMessage" style="display:none;color:red;">Incorrect OTP. Please try again.</p>
                </div>
                <div class="col-lg-2 col-md-2 col-2">
                    <button type="button" class="btn btn-primary text-me" id="verifyOtpButton">Verify</button>
                </div>
            `;

            // Add event listener to the Verify button
            document.getElementById('verifyOtpButton').addEventListener('click', function(e) {
                const enteredOtp = document.getElementById('otpInput').value;
                const correctOtp = '8454'; // This should be dynamically generated in a real scenario

                if (enteredOtp === correctOtp) {
                    // Remove OTP input field and show "Verified" message
                    otpSection.innerHTML = '<p class="text-success">Verified</p>';
                } else {
                    // Show error message if OTP is incorrect
                    document.getElementById('errorMessage').style.display = 'block';
                }
            });
        });
    </script>
</body>

</html>
