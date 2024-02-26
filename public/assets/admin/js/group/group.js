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
$('.custom-data-table').on('click', '.editGroupData', function (e) {
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
                $("#" + formModal).find('button[type="reset"]').attr('disabled', 'disabled');
                $("#" + formModal).addClass("show-side-form");
                $.each(response.data, function (index, valueMessage) {
                    console.log(index);
                    $("#" + index).val(valueMessage);
                });
                $("#user_id").val(response.data.user_id).trigger('change');
                $('#code').attr('readonly', true);
                //console.log($("#states_name").val());
               /*  $("#cities_name").html('');
                let state_name = $("#states_name").val();
                $.ajax({
                    url: baseUrl + 'ajax/get-cities-by-state',
                    type: "post",
                    data: {
                        states_name: state_name,
                    },
                    dataType: 'json',
                    success: function (result) {
                        $('#cities_name').html('<option value="">Select City</option>');
                        $.each(result.cities, function (key, value) {
                            $("#cities_name").append('<option value="' + value.name + '">' +
                                value.name + '</option>');
                        });
                        $("#cities_name").val(response.data.cities_name).trigger('change');

                    }
                });
                $.each(response.data.zip_codes, function (key, value) {
                    $("#zip_codes").append('<option value="' + value + '">' +
                        value + '</option>');
                });
                $("#zip_codes").val(response.data.zip_codes).trigger('change'); */
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
