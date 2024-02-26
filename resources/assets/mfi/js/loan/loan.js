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
$('#loan-form').on('submit', function (e) {
    e.preventDefault();
    var $this = $(this);
    /* console.table($this); */
    var formActionUrl = $this.prop('action');
    if ($($this).hasClass('fileupload')) {
        var fd = new FormData(document.getElementById($($this).attr('id')));
    } else {
        var fd = $($this).serialize();
    }

    // console.log(formActionUrl);
    let commonOption = { 'type': 'post', 'url': formActionUrl, 'data': fd, 'dataType': "json" };
    if ($($this).hasClass('fileupload')) {
        commonOption['cache'] = false;
        commonOption['processData'] = false;
        commonOption['contentType'] = false;
    }

    $.ajax({
        ...commonOption,
        beforeSend: function () {
        },
        success: function (response) {
            if (response.status) {
                Swal.fire({
                    icon: 'success',
                    title: response.message,
                    showConfirmButton: false,
                    timer: 1500
                })
                console.log(response);
                let loan = response.data.loan;
                console.log('loan', loan);
                $("#slide-from-right").removeClass("show-side-form");
                if ($( "#slide-from-right" ).hasClass('add-form')) {
                    $("#emi-setting-right").addClass('show-side-form');
                    $("#loan_code_view").html(loan.code);
                    $("#loan_name_view").html(loan.name);
                    $("#loan_id").val(loan.id);
                    $("#loan_principal_amount_view").html(loan.maturity_amount);
                    $("#emi_maturity_amount").val(loan.maturity_amount);
                    $("#loan_amount_view").html(loan.maturity_amount);
                    let noOfWeek = Number(loan.tenure);
                    let maturityAmount = Number(loan.maturity_amount);
                    let singleEmi = (maturityAmount / noOfWeek).toFixed(2);
                    console.log(singleEmi);
                    console.log(noOfWeek);
                    let toAppend = "";
                    for (let i = 0; i < noOfWeek; i++) {
                        let index = i + 1;
                        toAppend += `
                        <div class="row">
                            <div class="col-md-6">
                                <div class="single-input">
                                    <div class="form-group">
                                        <label for="number_of_week">No. Of Week :- ${index}</label>
                                        <input type="hidden" class="form-control no_of_week" id="number_of_week__${index}" name="number_of_week[]" value="${index}" aria-describedby="No. of Week" placeholder="1">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="single-input">
                                    <div class="form-group">
                                        <label for="emi_amount">Emi Amount<span class="text-danger">*</span></label>
                                        <input type="number" class="form-control emi_amount" id="emi_amount__${index}" value="${singleEmi}" name="emi_amount[]" aria-describedby="Emi Amount" placeholder="Enter Emi Amount">
                                    </div>
                                </div>
                            </div>
                        </div>`;
                    }
                    $("#append_emi_setting").html(toAppend);
                }else{
                    location.reload();
                }
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
            console.log(response);
            let responseJSON = response.responseJSON;
            $(".err_message").removeClass("d-block").hide();
            $("form .form-control").removeClass("is-invalid");
            $.each(responseJSON.errors, function (index, valueMessage) {
                $("#" + index).addClass('is-invalid');
                $("#" + index).after("<p class='d-block text-danger err_message'>" + valueMessage + "</p>");
            });
        }
        /* ,
        complete: function(response){
            location.reload();
        } */
    });

});
function calculateAmountTotal() {
    let emiAmounts = 0;
    // var ek=[];

    $('.emi_amount').each(function () {
        emiAmounts = Number(emiAmounts) + Number($(this).val());
        //  ek.push($(this).val());
    });
    return emiAmounts;

}
$('#emi-form-submit').on('submit', function (e) {
    e.preventDefault();
    var $this = $(this);
    /* console.table($this); */
    var formActionUrl = $this.prop('action');
    if ($($this).hasClass('fileupload')) {
        var fd = new FormData(document.getElementById($($this).attr('id')));
    } else {
        var fd = $($this).serialize();
    }
    let emiAmounts = calculateAmountTotal();
    let emi_maturity_amount = $("#emi_maturity_amount").val();
    if (emi_maturity_amount != emiAmounts) {
        Swal.fire({
            icon: 'error',
            title: 'Maturity Amount Should be same sum of emi amount',
            showConfirmButton: false,
            timer: 1500
        })
        return false;
    }
    // console.log(formActionUrl);
    let commonOption = { 'type': 'post', 'url': formActionUrl, 'data': fd, 'dataType': "json" };
    if ($($this).hasClass('fileupload')) {
        commonOption['cache'] = false;
        commonOption['processData'] = false;
        commonOption['contentType'] = false;
    }
    console.log(fd);

    $.ajax({
        ...commonOption,
        beforeSend: function () {
        },
        success: function (response) {
            if (response.status) {
                Swal.fire({
                    icon: 'success',
                    title: response.message,
                    showConfirmButton: false,
                    timer: 1500
                })
                console.log(response);

                location.reload();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: response.message ?? 'We are facing some technical issue now.',
                    showConfirmButton: false,
                    timer: 1500
                })
            }
        },
        error: function (response) {
            console.log(response);
            let responseJSON = response.responseJSON;
            $(".err_message").removeClass("d-block").hide();
            $("form .form-control").removeClass("is-invalid");
            $.each(responseJSON.errors, function (index, valueMessage) {
                $("#" + index).addClass('is-invalid');
                $("#" + index).after("<p class='d-block text-danger err_message'>" + valueMessage + "</p>");
            });
        }
        /* ,
        complete: function(response){
            location.reload();
        } */
    });

});
$('.custom-data-table').on('click', '.editLoanEmiData', function (e) {
    var $this = $(this);
    var uuid = $this.data('uuid');
    var find = $this.data('table');
    var formModal = $this.data('form-modal');
    var message = $this.data('message') ?? 'Loan EMI';
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
                let update = $("#" + formModal).find('button[type="submit"]').html('Update');
                $("#" + formModal).find('button[type="reset"]').html('Cancel');

                $("#" + formModal).find('button[type="reset"]').addClass('reload');
                $("#" + formModal).addClass("show-side-form");
                let toAppend = "";
                let loan = response.data.loan;
                let emiDatas = response.data.emis;
                // console.log(response.data.emis);
                if (emiDatas && emiDatas.length) {
                    console.log("in emis");
                    $.each(emiDatas, function (key, valueEmi) {
                        let index = key;
                        toAppend += `
                        <div class="row">
                            <div class="col-md-6">
                                <div class="single-input">
                                    <div class="form-group">
                                        <label for="number_of_week">No. Of Week :- ${valueEmi.number_of_week}</label>
                                        <input type="hidden" class="form-control no_of_week" id="number_of_week__${index}" name="number_of_week[]" value="${valueEmi.number_of_week}" aria-describedby="No. of Week" placeholder="1">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="single-input">
                                    <div class="form-group">
                                        <input type="hidden" class="form-control" id="loan_emi_id__${index}" value="${valueEmi.id}" name="loan_emi_id[]">
    
                                        <label for="emi_amount">Emi Amount<span class="text-danger">*</span></label>
                                        <input type="number" class="form-control emi_amount" id="emi_amount__${index}" value="${valueEmi.emi_amount}" name="emi_amount[]" aria-describedby="Emi Amount" placeholder="Enter Emi Amount">
                                    </div>
                                </div>
                            </div>
                        </div>`;
                    });
                } else {
                    let noOfWeek = Number(loan.tenure);
                    let maturityAmount = Number(loan.maturity_amount);
                    let singleEmi = (maturityAmount / noOfWeek).toFixed(2);
                    console.log(singleEmi);
                    console.log(noOfWeek);
                    for (let i = 0; i < noOfWeek; i++) {
                        let index = i + 1;
                        toAppend += `
                        <div class="row">
                            <div class="col-md-6">
                                <div class="single-input">
                                    <div class="form-group">
                                        <label for="number_of_week">No. Of Week :- ${index}</label>
                                        <input type="hidden" class="form-control no_of_week" id="number_of_week__${index}" name="number_of_week[]" value="${index}" aria-describedby="No. of Week" placeholder="1">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="single-input">
                                    <div class="form-group">
                                        <label for="emi_amount">Emi Amount<span class="text-danger">*</span></label>
                                        <input type="number" class="form-control emi_amount" id="emi_amount__${index}" value="${singleEmi}" name="emi_amount[]" aria-describedby="Emi Amount" placeholder="Enter Emi Amount">
                                    </div>
                                </div>
                            </div>
                        </div>`;
                    }
                }

                $("#append_emi_setting").html(toAppend);

                $("#loan_name_view").html(loan.name);
                $("#loan_code_view").html(loan.code);
                $("#loan_principal_amount_view").html(loan.maturity_amount);
                $("#emi_maturity_amount").val(loan.maturity_amount);
                $("#loan_id").val(loan.id);
                $("#loan_amount_view").html(loan.maturity_amount);

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

    });

});
$('.custom-data-table').on('click', '.editLoanData', function (e) {
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
                let update = $("#" + formModal).find('button[type="submit"]').html('Update');
                // $("#" + formModal).find('button[type="reset"]').attr('disabled', 'disabled');
                $("#" + formModal).find('button[type="reset"]').html('Cancel');
            
                $("#" + formModal).find('button[type="reset"]').addClass('reload');
                $("#" + formModal).addClass("show-side-form");
                $.each(response.data, function (index, valueMessage) {
                    console.log(index);
                    $("#" + index).val(valueMessage);
                });
                $("#slide-from-right").addClass("edit-form");
                $("#branches").val(response.data.branches).trigger('change');
                
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