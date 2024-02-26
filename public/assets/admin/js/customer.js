// JavaScript Document
'use strict';
var baseUrl = APP_URL + '/';
var flashstatus = $('span.flashstatus').text();
var flashmessage = $('span.flashmessage').text();
var pagetype = jQuery('input[name="pagetype"]').val();
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var listOccupation = "";
var listLoans = "";
var listPurpose = "";
getCustomerAllData();
if (loanUuid) {
    getLeadData(loanUuid, 'lead_customer', "slide-from-right");
}
$(document).ready(function (e) {
    $('.close-btn').click(function (e) {
        $('.formsubmit').trigger('reset');
        $(".slide-from-right").removeClass("show-side-form");
    });
    $('.family-add-more').on('click', function (e) {
        $('.append-family-more-field').append(familyMoreField());
    });
    $('.append-family-more-field').on('click', '.family-delete-one', function (e) {
        $(this).parent().parent().remove();
    });
    $('.append-property-more-field').on('click', '.property-delete-one', function (e) {
        $(this).parent().parent().remove();
    });
    $('.append-other-loans-more-field').on('click', '.other-loan-delete-one', function (e) {
        $(this).parent().parent().remove();
    });
    $('.customerformsubmit').on('click', '.update-btn', function (e) {
        $('#personal_details').trigger('submit');
    });


    $('.property-add-more').on('click', function (e) {
        $('.append-property-more-field').append(otherLoanMoreField());
    });

    $('.other-loan-add-more').on('click', function (e) {

        $('.append-other-loans-more-field').append(otherLoanMoreField());

    });
    $('.custom-data-table').on('click', '.editCustomerData', function (e) {
        var $this = $(this);
        var uuid = $this.data('uuid');
        var find = $this.data('table');
        var formModal = $this.data('form-modal');
        var message = $this.data('message') ?? 'test message';

        $.ajax({
            type: "get",
            url: baseUrl + 'ajax/edit-data',
            data: { 'uuid': uuid, 'find': find },
            cache: false,
            dataType: "json",
            beforeSend: function () {

            },
            success: function (response) {
                if (response.status) {
                    // $("#submit3").addClass('update-btn');
                    // $("#" + formModal).find('button[type="submit"]').addClass('update-btn');
                    let update = $("#" + formModal).find('button[type="submit"]').html('Update');
                    // $("#" + formModal).find('button[type="reset"]').attr('disabled', 'disabled');
                    $("#" + formModal).find('button[type="reset"]').html('Cancel');

                    $("#" + formModal).find('button[type="reset"]').addClass('reload');
                    $("#" + formModal).addClass("show-side-form");
                    $.each(response.data, function (index, valueMessage) {
                        $("#" + index).val(valueMessage);
                    });

                    $('.append-property-more-field').html(response.data.customer_property_details_html);
                    $('.append-other-loans-more-field').html(response.data.customer_other_loan_details_html);
                    $('.append-family-more-field').html(response.data.customer_family_details_html);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'We are facing some technical issue now.',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            },
            error: function (response) {
                Swal.fire({
                    icon: 'error',
                    title: 'We are facing some technical issue now. Please try again after some time',
                    showConfirmButton: false,
                    timer: 1500
                })
            }
            /* ,
            complete: function(response){
                location.reload();
            } */
        });

    });

    /**
     * Reset Customer Modal
     */
    $('#slide-from-right').on('click', '#close-customer-btn', function (e) {
    });
});
function getLeadData(loanUuid, find, formModal) {
    var $this = $(this);
    var uuid = loanUuid;
    var message = $this.data('message') ?? 'test message';

    $.ajax({
        type: "get",
        url: baseUrl + 'ajax/edit-data',
        data: { 'uuid': uuid, 'find': find },
        cache: false,
        dataType: "json",
        beforeSend: function () {

        },
        success: function (response) {
            console.log(response);
            if (response.status) {
                // $("#submit3").addClass('update-btn');
                $("#" + formModal).find('button[type="submit"]').removeClass('update-btn');
                // let update = $("#" + formModal).find('button[type="submit"]').html('Update');
                // $("#" + formModal).find('button[type="reset"]').attr('disabled', 'disabled');
                // $("#" + formModal).find('button[type="reset"]').html('Cancel');

                // $("#" + formModal).find('button[type="reset"]').addClass('reload');
                $("#" + formModal).addClass("show-side-form");
                $.each(response.data, function (index, valueMessage) {
                    $("#" + index).val(valueMessage);
                });

                // $('.append-property-more-field').html(response.data.customer_property_details_html);
                // $('.append-other-loans-more-field').html(response.data.customer_other_loan_details_html);
                // $('.append-family-more-field').html(response.data.customer_family_details_html);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Lead details not found! please try again',
                    showConfirmButton: false,
                    timer: 1500
                })
            }
        },
        error: function (response) {
            Swal.fire({
                icon: 'error',
                title: 'We are facing some technical issue now. Please try again after some time',
                showConfirmButton: false,
                timer: 1500
            })
        }
        /* ,
        complete: function(response){
            location.reload();
        } */
    });
}
function getCustomerAllData() {

    $.ajax({
        type: "get",
        url: baseUrl + 'ajax/customer-all-data',
        cache: false,
        dataType: "json",
        beforeSend: function () {

        },
        success: function (response) {
            if (response.status) {
                listOccupation = response.data.list_occupation;
                listLoans = response.data.list_loans;
                listPurpose = response.data.list_purpose;

            } else {

            }
        },
        error: function (response) {

        }
        /* ,
        complete: function(response){
            location.reload();
        } */
    });

}
function familyMoreField()
{
    let familyMoreField=`
    <div class="add-more-field">
    <div class="row align-items-end">
    <div class="col-md-6">
        <div class="single-input">
            <div class="form-group">
                <label>Member name<span class="text-danger">*</span></label>
                <input type="Text" class="form-control member_name" placeholder="Member Name"
                    name="member_name[]" >
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="single-input">
            <div class="form-group">
                <label>Age<span class="text-danger">*</span></label>
                <input type="Number" class="form-control age" placeholder="age" name="age[]"
                    >

            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="single-input">
            <div class="form-group">
                <label>Relation<span class="text-danger">*</span></label>
                <select name="relation[]" class="relation" >
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
                <select name="occupation_id[]" class="occupation_id" >
                    <option value="">Select Occupation</option>`;
    if (listOccupation && listOccupation.length) {
        $.each(listOccupation, function (indexO, occupation) {
            familyMoreField += `<option value="${occupation.id}"
                                            data-id="${occupation.uuid}">
                                                ${(occupation.name) ? occupation.name : ''}
                                            </option>`;
        });
    } else {
        familyMoreField += `<option value="" data-id="">No Occupations Available</option>`;
    }
    familyMoreField += `</select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="btns-actions-postion">
                            <button type="button" class="family-delete-one  m-1"><i class="fa fa-minus-circle"
                                    aria-hidden="true"></i></button>
                        </div>
                        </div>`;
    return familyMoreField;
}
function propertyMoreField()
{
    let propertyMoreField = `<div class="add-more-field">
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
                            <select name="property_condition[]" class="property_condition">
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
                            <input type="year" class="form-control" name="year[]" class="year">
                        </div>
                    </div>
                </div>

            </div>

            <div class="btns-actions-postion">
                <button class="property-delete-one  m-1"><i class="fa fa-minus-circle" aria-hidden="true"></i></button>
            </div>
        </div>`;
    return propertyMoreField;
}
function otherLoanMoreField()
{
    let otherLoanMoreField = ` <div class="add-more-field">
    <div class="row align-items-end">
        <div class="col-md-6">
            <div class="single-input">
                <div class="form-group">
                    <label>Company Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control company" placeholder="Company Name"
                        name="company[]" >

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="single-input">
                <div class="form-group">
                    <label>Total loan amount<span class="text-danger">*</span></label>
                    <input type="number" class="form-control total_loan_amount" name="total_loan_amount[]"
                    >
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
                    <input type="text" class="form-control total_paid_emi" name="total_paid_emi[]">
                </div>
            </div>
        </div>
    </div>
    <div class="btns-actions-postion">
        <button type="button" class="other-loan-delete-one  m-1"><i class="fa fa-minus-circle"
                aria-hidden="true"></i></button>
    </div>
</div>`;
return otherLoanMoreField;
}
function validateCustomerFrom(formName = 'personalDetail') {
    /* console.table($this); */
    var formActionUrl = personalDetailAction;
    if (formName == 'familyDetail') {
        formActionUrl = familyDetailAction;
    } else if (formName == 'propertyDetail') {
        formActionUrl = propertyDetailAction;

    } else if (formName == 'otherLoanDetail') {
        formActionUrl = otherLoanDetailAction;

    } else if (formName == 'bankDetail') {
        formActionUrl = bankDetailAction;
    }
    if ($('#personal_details').hasClass('fileupload')) {
        var fd = new FormData(document.getElementById('personal_details'));
    } else {
        var fd = $('#personal_details').serialize();
    }
    let isError = false;
    let commonOption = { 'type': 'post', 'url': formActionUrl, 'data': fd, 'dataType': "json", async: false };
    if ($('#personal_details').hasClass('fileupload')) {
        commonOption['cache'] = false;
        commonOption['processData'] = false;
        commonOption['contentType'] = false;
    }

    $.ajax({
        ...commonOption,
        beforeSend: function () {
        },
        success: function (response) {
            console.log(response);
            if (response.status) {
                //  Swal.fire({
                //      icon: 'success',
                //      title: response.message,
                //      showConfirmButton: false,
                //      timer: 1500
                //  })
                isError = true;
                //  location.reload();
            } else {
                isError = false;
                Swal.fire({
                    icon: 'error',
                    title: 'We are facing some technical issue now.',
                    showConfirmButton: false,
                    timer: 1500
                });
                isError = false;
            }
        },
        error: function (response) {
            //  console.log(response);
            let responseJSON = response.responseJSON;
            $(".err_message").removeClass("d-block").hide();
            $("form .form-control").removeClass("is-invalid");
            // let isError = false;

            if (formName == 'familyDetail' || formName == 'propertyDetail' || formName == 'otherLoanDetail') {
                let mainElementclass = $('.append-family-more-field').find('.add-more-field');
                if (formName == 'propertyDetail') {
                    mainElementclass = $('.append-property-more-field').find('.add-more-field');

                } else if (formName == 'otherLoanDetail') {
                    mainElementclass = $('.append-other-loans-more-field').find('.add-more-field');
                }

                $.each(responseJSON.errors, function (index, valueMessage) {
                    isError = true;
                    let indexArray = index.split('.');
                    let elementValue = $(mainElementclass[indexArray[1]]).find('.' + indexArray[0]);
                    let tempStr = valueMessage[0];
                    let validateMessage = titleCase(tempStr.replace(index, indexArray[0]));
                    $(elementValue).addClass('is-invalid');
                    $(elementValue).after("<p class='d-block text-danger err_message'>" + validateMessage + "</p>");

                });
                // console.log("mainElementclass",mainElementclass)
            } else {
                $.each(responseJSON.errors, function (index, valueMessage) {
                    isError = true;
                    $("#" + index).addClass('is-invalid');
                    $("#" + index).after("<p class='d-block text-danger err_message'>" + valueMessage + "</p>");
                });
            }
            isError = false;



            // Swal.fire({
            //     icon: 'error',
            //     title: 'We are facing some technical issue now. Please try again after some time',
            //     showConfirmButton: false,
            //     timer: 1500
            // })
        }
        /* ,
        complete: function(response){
            location.reload();
        } */
    });

    return isError;



}

$('.editCustomerData_old').click(function (e) {
    $("#slide-from-right").addClass("show-side-form");
    let customer_id = $(this).data('cid');
    let title = $(this).data('title');
    let branch = $(this).data('branch');
    let name = $(this).data('name');
    let email = $(this).data('email');
    let aadhaar = $(this).data('aadhaar');
    let alternative_mobile = $(this).data('alternative-mobile');
    let mobile = $(this).data('mobile');
    let loan_id = $(this).data('loan-id');
    let landmark = $(this).data('landmark');
    let location_image = $(this).data('location-image');
    let aadhaar_image = $(this).data('aadhaar-image');
    let profile_image = $(this).data('profile-image');
    let address = $(this).data('address');
    let aadhaar_address = $(this).data('aadhaar-address');
    let bank_details_account_holder = $(this).data('bank-details-account-holder');
    let bank_details_account_no = $(this).data('bank-details-account-no');
    let bank_details_ifsc_code = $(this).data('bank-details-ifsc-code');
    let family_details = $(this).data('family-details');
    let property_details = $(this).data('property-details');
    let other_loan_details = $(this).data('other-loan-details');
    // console.log(family_details[0].updated_at);
    //alert(bank_details_ifsc_code);
    $('#update_id').val(customer_id);
    $('#title').val(title);
    $('#branch_id').val(branch);
    $('#name').val(name);
    $('#email').val(email);
    $('#aadhaar_no').val(aadhaar);
    $('#mobile_number').val(mobile);
    $('#alternative_phone').val(alternative_mobile);
    $('#loan_id').val(loan_id);
    $('#landmark').val(landmark);
    $('#address').val(address);
    $('#aadhaar_address').val(aadhaar_address);
    $('#account_holder').val(bank_details_account_holder);
    $('#account_no').val(bank_details_account_no);
    $('#ifsc_code').val(bank_details_ifsc_code);
    /* add more section */
    $('#member_name').val(family_details[0].member_name);
    $('#age').val(family_details[0].age);
    $('#relation').val(family_details[0].relation);
    $('#occupation_id').val(family_details[0].occupation_id);
    $('#property_type').val(property_details[0].property_type);
    $('#property_condition').val(property_details[0].property_condition);
    $('#year').val(property_details[0].year);
    $('#company').val(other_loan_details[0].company);
    $('#total_loan_amount').val(other_loan_details[0].total_loan_amount);
    $('#emi_frequency').val(other_loan_details[0].emi_frequency);
    $('#total_paid_emi').val(other_loan_details[0].total_paid_emi);
    /* add more section */
});

const titleCase = (s) => s.replace(/^_*(.)|_+(.)/g, (s, c, d) => c ? c : ' ' + d)
