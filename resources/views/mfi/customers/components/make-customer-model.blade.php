<div id="slide-from-right-make-customer" class="slide-from-right no-scroll-form">
    <h2>Customer <span class="close-btn"><i class="fa fa-times" aria-hidden="true"></i></span></h2>
    <div class="container-custom">
        <div class="steps-progress-bar">
            <div class="step">
                <p>Personal Details</p>
                <div class="bullet">
                    <span>1</span>
                </div>
                <div class="check fas fa-check"></div>
            </div>
            <div class="step">
                <p>Family Detail</p>
                <div class="bullet">
                    <span>2</span>
                </div>
                <div class="check fas fa-check"></div>
            </div>
            <div class="step">
                <p>Property Details</p>
                <div class="bullet">
                    <span>3</span>
                </div>
                <div class="check fas fa-check"></div>
            </div>
            <div class="step">
                <p>Other Loans</p>
                <div class="bullet">
                    <span>4</span>
                </div>
                <div class="check fas fa-check"></div>
            </div>
            <div class="step">
                <p>Bank Details</p>
                <div class="bullet">
                    <span>5</span>
                </div>
                <div class="check fas fa-check"></div>
            </div>

        </div>
        <div class="form-outer">
            <form action="{{ route('mfi.customer.store', ['slug' => $code]) }}" id="personal_details" data-step="1"
                class="customerformsubmit formsubmit fileupload step1">
                <input type="hidden" name="customer_id" id="customer_id">
                <div class="page slide-page">
                    <div class="row align-items-end">
                        <div class="col-md-6">
                            <div class="single-input">
                                <div class="form-group">
                                    <label>Select Title<span class="text-danger">*</span></label>
                                    <select name="title" id="title" required>
                                        <option value="">Select Title</option>
                                        <option value="mr">
                                            Mr
                                        </option>
                                        <option value="mrs">
                                            Mrs
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="single-input">
                                <div class="form-group">
                                    <label for="branch-name">Branch<span class="text-danger">*</span></label>
                                    <select name="branch_id" id="branch_id">
                                        <option value="">Select Branch</option>
                                        @forelse ($listBranch as $branch)
                                            <option value="{{ $branch->uuid }}" data-id="{{ $branch->uuid }}">
                                                {{ !empty($branch->name) ? $branch->name : '' }}
                                            </option>
                                        @empty
                                            <option value="" data-id="">{{ 'No Branches Available' }}
                                            </option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="single-input">
                                <div class="form-group">
                                    <label>Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Enter Name"
                                        name="name" id="name" required>
                                    <input type="hidden" class="form-control" placeholder="Enter Name"
                                        name="customer_personal_id" id="customer_personal_id">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="single-input">
                                <div class="form-group">
                                    <label>Email <span>(optional)</span></label>
                                    <input type="email" class="form-control" placeholder="Enter Email"
                                        name="email" id="email">

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="single-input">
                                <div class="form-group">
                                    <label>Aadhaar Card<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Aadhaar card"
                                        name="aadhaar_no" id="aadhaar_no" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="single-input">
                                <div class="form-group">
                                    <label>Mobile<span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" placeholder="Enter Mobile Number"
                                        name="mobile_number" id="mobile_number" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="single-input">
                                <div class="form-group">
                                    <label>Alternative Number <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" placeholder="Enter Alternative Number"
                                        name="alternative_phone" id="alternative_phone" required>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="single-input">
                                <div class="form-group">
                                    <label>Select Loan Product<span class="text-danger">*</span></label>
                                    <select name="loan_id" id="loan_id" required>
                                        <option value="">Select Loan Product</option>
                                        @forelse ($listLoans as $loans)
                                            <option value="{{ $loans->id }}" data-id="{{ $loans->uuid }}">
                                                {{ !empty($loans->name) ? $loans->name : '' }}
                                            </option>
                                        @empty
                                            <option value="" data-id="">{{ 'No Loans Available' }}
                                            </option>
                                        @endforelse
                                    </select>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="single-input">
                                <div class="form-group">
                                    <label>Landmark<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="LandMark"
                                        name="landmark" id="landmark" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="single-input">
                                <div class="form-group">
                                    <label>Location(image)<span class="text-danger">*</span></label>
                                    <input type="file" class="form-control-file" name="location_image"
                                        id="location_image" required>

                                </div>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="single-input">
                                <div class="form-group">
                                    <label>Upload aadhaar<span class="text-danger">*</span></label>
                                    <input type="file" class="form-control-file" name="aadhaar_image"
                                        id="aadhaar_image" required>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="single-input">
                                <div class="form-group">
                                    <label>Upload Pic<span class="text-danger">*</span></label>
                                    <input type="file" class="form-control-file" name="customer_image"
                                        id="customer_image" required>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="single-input">
                                <div class="form-group">
                                    <label>Address<span class="text-danger">*</span></label>
                                    <textarea rows="6" cols="6" name="address" id="address" required></textarea>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="single-input">
                                <div class="form-group">
                                    <label>Aadhaar Address<span class="text-danger">*</span></label>
                                    <textarea rows="6" cols="6" name="aadhaar_address" id="aadhaar_address" required></textarea>
                                </div>
                            </div>
                        </div>


                    </div>

                    <div class="row field btns mt-5 justify-content-content">

                        <!-- <div class="col-md-3">
                                                                            <button class="prev-1 prev p-3 d-flex align-items-center justify-content-center">Previous</button>
                                                                        </div> -->
                        <div class="col-md-3">
                            <button class="next-1 next p-3 d-flex align-items-center justify-content-center"
                                type="button">Next</button>
                        </div>
                    </div>

                </div>
                <div class="page">
                    <div class="col-12 plus_btn">
                        <button type="button" class="family-add-more  m-1"><i class="fa fa-plus-circle"
                                aria-hidden="true"></i></button>
                    </div>
                    <div class="append-family-more-field">
                        <div class="add-more-field">
                            <div class="row align-items-end">
                                <div class="col-md-6">
                                    <div class="single-input">
                                        <div class="form-group">
                                            <label>Member name<span class="text-danger">*</span></label>
                                            <input type="Text" class="form-control member_name"
                                                placeholder="Member Name" name="member_name[]">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="single-input">
                                        <div class="form-group">
                                            <label>Age<span class="text-danger">*</span></label>
                                            <input type="Number" class="form-control age" placeholder="age"
                                                name="age[]">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="single-input">
                                        <div class="form-group">
                                            <label>Relation<span class="text-danger">*</span></label>
                                            <select name="relation[]" class="relation">
                                                <option value="">Relation</option>
                                                <option value="father">
                                                    Father
                                                </option>
                                                <option value="mother">
                                                    Mother
                                                </option>
                                                <option value="brother">
                                                    Brother
                                                </option>
                                                <option value="sister">
                                                    Sister
                                                </option>
                                                <option value="father_in_law">
                                                    Father In Law
                                                </option>
                                                <option value="mother_in_law">
                                                    Mother In Law
                                                </option>
                                                <option value="sister_in_law">
                                                    Sister In Law
                                                </option>
                                                <option value="brother_in_law">
                                                    Brother In Law
                                                </option>
                                            </select>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="single-input">
                                        <div class="form-group">
                                            <label>Occupation<span class="text-danger">*</span></label>
                                            <select name="occupation_id[]" class="occupation_id">
                                                <option value="">Select Occupation</option>
                                                @forelse ($listOccupation as $occupation)
                                                    <option value="{{ $occupation->id }}"
                                                        data-id="{{ $occupation->uuid }}">
                                                        {{ !empty($occupation->name) ? $occupation->name : '' }}
                                                    </option>
                                                @empty
                                                    <option value="" data-id="">
                                                        {{ 'No Occupations Available' }}
                                                    </option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- <div class="btns-actions-postion">
                                                                                <button type="button" class="family-delete-one  m-1"><i class="fa fa-minus-circle"
                                                                                        aria-hidden="true"></i></button>
                                                                            </div> -->
                        </div>
                    </div>


                    <div class="row field btns mt-5 justify-content-content">

                        <div class="col-md-3">
                            <button type="button"
                                class="prev-2 prev p-3 d-flex align-items-center justify-content-center">Previous</button>
                        </div>
                        <div class="col-md-3">
                            <button type="button"
                                class="next-2 next p-3 d-flex align-items-center justify-content-center">Next</button>
                        </div>
                    </div>
                </div>

                <div class="page">
                    <div class="col-12 plus_btn">
                        <button type="button" class="property-add-more  m-1"><i class="fa fa-plus-circle"
                                aria-hidden="true"></i></button>
                    </div>
                    <div class="append-property-more-field">
                        <div class="add-more-field">
                            <div class="row align-items-end">
                                <div class="col-md-6">
                                    <div class="single-input">
                                        <div class="form-group">
                                            <label>Property Type<span class="text-danger">*</span></label>
                                            <select name="property_type[]" class="property_type">
                                                <option value="">Property Type</option>
                                                <option value="public">
                                                    Public
                                                </option>
                                                <option value="private">
                                                    Private
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="single-input">
                                        <div class="form-group">
                                            <label>Property condition<span class="text-danger">*</span></label>
                                            <select name="property_condition[]" id="property_condition">
                                                <option value="">Property condition</option>
                                                <option value="own">
                                                    Own
                                                </option>
                                                <option value="rented">
                                                    Rented
                                                </option>
                                            </select>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="single-input">
                                        <div class="form-group">
                                            <label>Year<span class="text-danger">*</span></label>
                                            <input type="year" class="form-control" name="year[]"
                                                id="year">
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="btns-actions-postion">
                                <!-- <button type="button" class="property-add-more  m-1"><i class="fa fa-plus-circle"
                                                                                        aria-hidden="true"></i></button> -->
                                <!-- <button class="property-delete-one  m-1"><i class="fa fa-minus-circle" aria-hidden="true"></i></button> -->
                            </div>
                        </div>
                    </div>


                    <div class="row field btns mt-5 justify-content-content">

                        <div class="col-md-3">
                            <button type="button"
                                class="prev-3 prev p-3 d-flex align-items-center justify-content-center">Previous</button>
                        </div>
                        <div class="col-md-3">
                            <button type="button"
                                class="next-3 next p-3 d-flex align-items-center justify-content-center">Next</button>
                        </div>
                    </div>
                </div>
                <div class="page">
                    <div class="col-12 plus_btn">
                        <button type="button" class="other-loan-add-more  m-1"><i class="fa fa-plus-circle"
                                aria-hidden="true"></i></button>
                    </div>
                    <div class="append-other-loans-more-field">
                        <div class="add-more-field">
                            <div class="row align-items-end">
                                <div class="col-md-6">
                                    <div class="single-input">
                                        <div class="form-group">
                                            <label>Company Name<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Company Name"
                                                name="company[]" id="company">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="single-input">
                                        <div class="form-group">
                                            <label>Total loan amount<span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" name="total_loan_amount[]"
                                                id="total_loan_amount">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="single-input">
                                        <div class="form-group">
                                            <label>Emi frequency<span class="text-danger">*</span></label>

                                            <select name="emi_frequency[]" class="emi_frequency">
                                                <option value="">Emi frequency</option>
                                                <option value="daily">
                                                    Daily
                                                </option>
                                                <option value="weekly">
                                                    Weekly
                                                </option>
                                                <option value="biweekly">
                                                    Biweekly
                                                </option>
                                                <option value="monthly">
                                                    Monthly
                                                </option>
                                            </select>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="single-input">
                                        <div class="form-group">
                                            <label>Total Paid Emi<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="total_paid_emi[]"
                                                class="total_paid_emi">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="btns-actions-postion">
                                <!-- <button type="button" class="add-more  m-1"><i class="fa fa-plus-circle"
                                                                                        aria-hidden="true"></i></button>
                                                                                <button type="button" class="delete-one  m-1"><i class="fa fa-minus-circle"
                                                                                        aria-hidden="true"></i></button> -->
                            </div>
                        </div>
                    </div>
                    <div class="row field btns mt-5 justify-content-content">

                        <div class="col-md-3">
                            <button type="button"
                                class="prev-4 prev p-3 d-flex align-items-center justify-content-center">Previous</button>
                        </div>
                        <div class="col-md-3">
                            <button type="button"
                                class="next-4 next p-3 d-flex align-items-center justify-content-center">Next</button>
                        </div>
                    </div>
                </div>
                <div class="page">
                    <div class="row align-items-end">
                        <div class="col-md-6">
                            <div class="single-input">
                                <div class="form-group">
                                    <label>Account holder name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Account holder Name"
                                        id="account_holder" name="account_holder">

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="single-input">
                                <div class="form-group">
                                    <label>Account no<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Account Number"
                                        name="account_no" id="account_no">

                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="single-input">
                                <div class="form-group">
                                    <label>Ifsc Code<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Ifsc Code"
                                        name="ifsc_code" id="ifsc_code">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row field btns mt-5 justify-content-content">

                        <div class="col-md-3">
                            <button type="button"
                                class="prev-5 prev p-3 d-flex align-items-center justify-content-center">Previous</button>
                        </div>
                        <div class="col-md-3">
                            <button type="submit"
                                class="p-3 submit3 update-btn  d-flex align-items-center justify-content-center">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
