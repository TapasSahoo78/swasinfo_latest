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
                            <input type="text" class="form-control" name="address_line_one" id="exampleInputText"
                                placeholder="Address Line 1">
                        </div>
                        <div class="col-lg-6 col-md-6 col-12 mt-2">
                            <label for="exampleInputText" class="form-label"></label>
                            <input type="text" class="form-control" name="address_line_two" id="exampleInputText"
                                placeholder="Address Line 2">
                        </div>
                        <div class="col-lg-6 col-md-6 col-12 mt-2">
                            <input type="text" class="form-control" name="city" id="exampleInputText"
                                placeholder="City/Town">
                        </div>
                        <div class="col-lg-6 col-md-6 col-12 mt-2">
                            <input type="text" class="form-control" name="state" id="exampleInputText"
                                placeholder="State">
                        </div>
                        <div class="col-lg-6 col-md-6 col-12 mt-2">
                            <input type="text" name="country" class="form-control" placeholder="country"
                                id="exampleInputText" placeholder="Country">
                        </div>
                        <div class="col-lg-6 col-md-6 col-12 mt-2">
                            <input type="text" class="form-control" name="postal_code" id="exampleInputText"
                                placeholder="ZIP / Postal code ">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12">
                            <h3>Choose your unique business display name</h3>
                            <label for="exampleInputText" class="form-label">What is a
                                business display name?</label>
                            <input type="text" class="form-control" name="username" id="exampleInputText"
                                placeholder="Enter display name">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12">
                            <h3>If you sell your products online, enter your website URL
                                (optional)</h3>
                            <label for="exampleInputText" class="form-label">Why do we ask for
                                this?</label>
                            <input type="text" class="form-control" name="why_do_sell" id="exampleInputText"
                                placeholder="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12">
                            <label for="exampleInputText" class="form-label">Select an option
                                to receive a PIN to verify your phone number</label>
                            <div class="col-1 form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                    id="inlineRadio1" value="option1">
                                <label class="form-check-label" for="inlineRadio1">Call</label>
                            </div>
                            <div class="col-1 form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                    id="inlineRadio2" value="option2">
                                <label class="form-check-label" for="inlineRadio2">SMS</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12">
                            <label for="mobileNumber" class="form-label">Mobile number</label>
                            <input type="number" name="mobile_number" class="form-control" id="mobileNumber" placeholder="Enter your mobile number">
                            <p class="eg">E.g. +1 206 266 1000</p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-10 col-md-10 col-12"></div>
                        <div class="col-lg-2 col-md-2 col-2">
                            <button type="button" class="btn btn-primary text-me" id="textMeButton">
                                Text me Now
                            </button>
                        </div>
                    </div>
                    <div class="row mt-3" id="verifyOtp"></div>

                </div>


                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <label for="exampleInputText" class="form-label">Email
                            Address</label>
                        <input type="text" name="email" class="form-control" id="exampleInputText"
                            placeholder="Enter your email id">
                        <p class="eg">E.g. info@gmail.com</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12 two-butn-row d-flex justify-content-center">
                        <button type="button" class="btn btn-next prev-step grey-butn">Back</button>
                        <button type="button" class="btn btn-next next-step next-butn">Next
                            3</button>
                    </div>
                </div>
            </div>

        </div>
        <!-- ----------------------------------- -->
        {{-- <div class="btn-section">
                <button type="button" class="btn btn-next prev-step">Previous</button>
                <button type="button" class="btn btn-next next-step">Submit & Next3</button>
            </div> --}}
    </div>
</div>
