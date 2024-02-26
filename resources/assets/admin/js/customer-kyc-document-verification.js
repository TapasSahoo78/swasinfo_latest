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
$(document).on('click', '#add_document_button', function (e) {
    e.preventDefault();
    i = $(this).data('count');
    if (i < fieldCounter) { //max input box allowed
        var count = $(this).data('count');
        count = parseInt(count) + 1;
        console.log(count);
        $(this).data('count', count);
        i++; //text box increment
        $('#dynamic_document_field').append(`<div id="row">
                                              <div class="col-md-11">
                         <div class="single-input">
                            <div class="form-group">
                                <label>Document<span class="text-danger">*</span></label>
                                <input type="file" class="form-control-file" name="document_file[]"
                                    id="document_file">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">

                             <a href="javascript:void(0);" style="margin-top: 26px;" class="btn btn-danger btn_document_remove" name="remove"  title="Remove field"><i class="fa fa-times" aria-hidden="true"></i></a>

                    </div>
                                            </div>`);
    }

});
$(document).on('click', '.btn_document_remove', function () {
    var getCount = i = parseInt($('#add_document_button').data('count'));
    $('#row').remove();
    $('#add_document_button').data('count', getCount - 1);
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
