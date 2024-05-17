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
                            <input type="text" name="apartment_number" class="form-control"
                                id="exampleInputText" placeholder="18441215848484">
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
                                    <input type="date" name="signature_date" class="form-control"
                                        id="exampleInputEmail1" placeholder="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div
                            class="col-lg-12 col-md-12 col-12 two-butn-row d-flex justify-content-center">
                            <button type="button"
                                class="btn btn-next prev-step grey-butn">Back</button>
                            <button type="button" class="btn btn-next next-step next-butn">Next
                                5</button>
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
