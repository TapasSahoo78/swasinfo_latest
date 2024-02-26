<div class="modal fade modal-address modal-lg" id="add-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
    aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add New Address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form id="addressForm">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="address-type">
                                <select class="form-select" name="type" id="type" aria-label="Default select example" >
                                    <option value="" selected>Select Address type</option>
                                    <option value="home">Home</option>
                                    <option value="office">Office</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="address-type">
                                <select class="form-select" name="is_default" id="is_default" aria-label="Default select example" >
                                    <option value="" selected>Default Address choice</option>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="name" id="name" placeholder="Name">
                        </div>
                        <input type="hidden" name="uuid" id="uuid">
                        <div class="col-lg-6">
                            <input type="number" class="form-control" name="phone_number"  id="phone_number" placeholder="Phone Number">
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="full_address[address_line_one]" id="address_line_one" placeholder="Address line one">
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="full_address[address_line_two]" id="address_line_two" placeholder="Address line two">
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="full_address[city]" id="city" placeholder="City">
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="full_address[state]" placeholder="State" id="state">
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="full_address[country]" placeholder="Country" id="country">
                        </div>
                        <div class="col-lg-6">
                            <input type="number" class="form-control" max="999999" min="100000" name="zip_code" placeholder="Zip Code" id="zip_code">
                        </div>
                        <div class="col-lg-12">
                            <input type="submit" class="addAddress" value="Submit">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
