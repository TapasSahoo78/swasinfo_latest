let jc;

function ajaxCall(thisVal, successCb = null) {
    let formdata = new FormData(thisVal);

    $.ajax({
        type: "POST",
        url: $(thisVal).attr("data-action"),
        data: formdata,
        processData: false,
        contentType: false,
        dataType: "JSON",
        success: function (data) {
            // console.log(data);
            if (data.status) {
                if (data.message != "") {
                    $.alert({
                        icon: "fa fa-check",
                        title: "Success!",
                        content: data.message,
                        type: "green",
                        typeAnimated: true,
                    });
                }
                if (data.redirect != "") {
                    setTimeout(function () {
                        window.location.href = data.redirect;
                    }, 1000);
                }
                successCb && successCb(data.content);
            } else {
                $.alert({
                    icon: "fa fa-warning",
                    title: "Warning!",
                    content: data.message,
                    type: "orange",
                    typeAnimated: true,
                });
            }
        },
    });
}

function onSubmitModalSuccess() {
    $(".modal").modal("hide");
}

$(document).on("submit", "#adminFrm", function (event) {
    event.preventDefault();
    ajaxCall(this);
});

$(document).on("submit", ".userFrm", function (event) {
    event.preventDefault();
    ajaxCall(this);
});

$(document).on("change", ".switch-input", function (event) {
    var url = $(this).data("url");
    var id = $(this).data("id");
    var status = $(this).is(":checked") ? 1 : 0;
    $.ajax({
        type: "POST",
        url: url,
        dataType: "json",
        cache: false,
        data: {
            _token: _token,
            id: id,
            status: status
        },
        success: function (data) {
            if (data.status) {
                $.alert({
                    icon: "fa fa-check",
                    title: "Success!",
                    content: data.message,
                    type: "green",
                    typeAnimated: true,
                });
            } else {
                $.alert({
                    icon: "fa fa-warning",
                    title: "Warning!",
                    content: data.message,
                    type: "orange",
                    typeAnimated: true,
                });
            }
        },
    });
});


$(document).on("submit", "#filter_form", function (e) {
    e.preventDefault();
    var form_data = $(this).serialize();
    var form_url = $(this).attr("action");
    var $this = $(this);
    $.ajax({
        type: "GET",
        url: form_url,
        dataType: "json",
        cache: false,
        data: form_data,

        success: function (data) {
            if (data.status == 200) {
                $("#load_content").html(data.content);
            } else {
                toastr.error(data.message);
            }
        },
        error: function () {
            toastr.error("Something went wrong");
        },
    });
});


$(document).on('click', '.change-status', function () {
    var id = $(this).data('id');
    var keyId = $(this).data('key');
    var table = $(this).data('table');
    var status = $(this).data('status');
    var url = $(this).data('action');
    var field = $(this).data('field');

    // alert(id + keyId + table + status + url);

    var dataJSON = {
        id: id,
        keyId: keyId,
        table: table,
        status: status,
        field: field,
        _token: _token
    };
    $.confirm({
        icon: 'fa fa-spinner fa-spin',
        title: 'Confirm!',
        content: 'Do you really want to do this ?',
        type: 'orange',
        typeAnimated: true,
        buttons: {
            confirm: function () {
                if (id && table) {
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: dataJSON,
                        dataType: "JSON",
                        success: function (data) {
                            console.log(data);
                            if (data.status) {
                                if (data.postStatus == '2') {
                                    $.alert({
                                        icon: 'fa fa-check',
                                        title: 'Success!',
                                        content: 'Data has been deleted !',
                                        type: 'green',
                                        typeAnimated: true,
                                    });
                                    setTimeout(function () { location.reload() }, 1550);

                                } else if (data.postStatus == '1') {
                                    $('#' + id).removeClass('badge-danger');
                                    $('#' + id).addClass('badge-primary');
                                    $('#' + id).html('Active');
                                    $('#' + id).data('status', '0');
                                    $.alert({
                                        icon: 'fa fa-check',
                                        title: 'Success!',
                                        content: data.message,
                                        type: 'green',
                                        typeAnimated: true,
                                    });
                                    setTimeout(function () { location.reload() }, 1550);
                                } else if (data.postStatus == '0') {

                                    $('#' + id).removeClass('badge-primary');
                                    $('#' + id).addClass('badge-danger');
                                    $('#' + id).html('Inactive');
                                    $('#' + id).data('status', '1');

                                    $.alert({
                                        icon: 'fa fa-check',
                                        title: 'Success!',
                                        content: data.message,
                                        type: 'green',
                                        typeAnimated: true,
                                    });
                                    setTimeout(function () { location.reload() }, 1550);

                                } else if (data.postStatus == '5') {

                                    $('#' + id).removeClass('badge-primary');
                                    $('#' + id).addClass('badge-danger');
                                    $('#' + id).html('Inactive');
                                    $('#' + id).data('status', '1');

                                    $.alert({
                                        icon: 'fa fa-close',
                                        title: 'Warning !',
                                        content: data.message,
                                        type: 'orange',
                                        typeAnimated: true,
                                    });
                                    setTimeout(function () { location.reload() }, 7000);

                                }

                            }
                        }
                    });
                }
            },
            cancel: function () {
                $.alert({
                    icon: 'fa fa-times',
                    title: 'Canceled!',
                    content: 'Process canceled',
                    type: 'purple',
                    typeAnimated: true,
                });
            }
        }
    });
});

$(document).on('keypress', '.float-number', function (event) {
    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
        event.preventDefault();
    }
});
