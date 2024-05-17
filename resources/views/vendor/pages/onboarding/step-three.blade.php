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
                                    name="is_target_business" value="0" id="inlineRadio1"
                                    value="option1">
                                <label class="form-check-label" for="inlineRadio1">Yes</label>
                            </div>
                            <div class="col-1 form-check form-check-inline">
                                <input class="form-check-input" type="radio"
                                    name="is_target_business" id="inlineRadio2" value="1">
                                <label class="form-check-label" for="inlineRadio2">No</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12">
                            <h3>How many different products do you plan to list?</h3>
                            <div class="form-check">
                                <input class="form-check-input" type="radio"
                                    name="how_many_products" value="1" id="how_many_products1">
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
                                    name="how_many_products" value="4" id="how_many_products4">
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
                    <div class="col-lg-12 col-md-12 col-12 two-butn-row d-flex justify-content-center">
                        <button type="button" class="btn btn-next prev-step grey-butn">Back</button>
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
