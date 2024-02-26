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
var fieldCounter = 5; /* (initial field counter defined as 1) */
var i;
$(document).on('click', '#add_button', function (e) {
    e.preventDefault();
    i = $(this).data('count');
    if (i < fieldCounter) { //max input box allowed
        var count = $(this).data('count');
        count = parseInt(count) + 1;
        console.log(count);
        $(this).data('count', count);
        i++; //text box increment
        $('#dynamic_field').append(`<div id="row">
                                              <div class="col-md-11">
                        <div class="single-input">
                            <div class="form-group">
                                <label>Video Link<span class="text-danger">*</span></label>
                                <input type="text" class="form-control validate_error" name="video_url[]" id="video_url">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="col-md-1">
                             <a href="javascript:void(0);" style="margin-top: 26px;" class="btn btn-danger btn_remove" name="remove"  title="Remove field"><i class="fa fa-times" aria-hidden="true"></i></a>
                        </div>
                    </div>
                                            </div>`);
    }

});
$(document).on('click', '.btn_remove', function () {
    var getCount = i = parseInt($('#add_button').data('count'));
    $('#row').remove();
    $('#add_button').data('count', getCount - 1);
    i--;
});
/* $(document).ready(function () {
    $('.validateForm').click(function (e) {
        e.preventDefault();
        var countValidateForms = $(kyc).find(".validate_error").length;
        if (countValidateForms > 0) {
            $(".validate_error").each(function () {
                var fieldValue = $(this).val();
                if (fieldValue == '') {
                    $(this).addClass('is-invalid');
                    $('.error').html('<p>This Field is required</p>').css('color', 'red');
                } else {
                    $('#kyc_details').submit();
                }
            });
        } else {
            $('#kyc_details').submit();
        }
    })
}) */
$('.custom-data-table').on('click', '.editKycData', function (e) {
    //alert('test');
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
            console.log(response);
            if (response.status) {
                let update = $("#" + formModal).find('button[type="submit"]').html('Update');

                $("#" + formModal).addClass("show-side-form");
                $.each(response.data, function (index, valueMessage) {
                    console.log(index);
                    $("#" + index).val(valueMessage);
                });
                // $('input[name=radioName]:checked', '#myForm').val()

                var val = $("input[name=is_loan_recommended]").val(response.data.is_loan_recommended);
                var val2 = $("input[name=is_verified_all]").val(response.data.is_verified_all);

                $("#kyc").css('display', 'block');
                $("#kyc").html(`<img src = "${response.data.kyc_image}" alt="image">`);

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