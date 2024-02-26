$(document).on('click', '.create', function () {
    var accountTypeval = $('#account_type option:selected').val();
    if (accountTypeval == '') {
        $('.errAcntType,.create').show();
        $('.accountSubType,.openingBalance,.saveBtnList,.upiSection,.bankSection,.accountName').hide();
    } else {
        $('.errAcntType').hide();
        $('.create').hide();
        $('.accountSubType').show();
        $('.openingBalance').show();
        $('.saveBtnList').show();
    }
});
$(document).on('click', '#account_sub_type', function () {
    updateOnAccountSubType();
});
$(document).on('click', '#account_type', function () {
    updateSectionOnAcccountType();
});
$(document).on('click', '.btn_reset', function () {
    //alert('test')
    if ($("#slide-from-right").hasClass('edit-form')) {
        $('.errAcntType').hide();
        $('.accountSubType').hide();
        $('.openingBalance').hide();
        $('.bankSection').hide();
        $('.accountName').hide();
        $('.upiSection').hide();
        $('.create').hide();
        $('.saveBtnList').show();
    } else if ($("#slide-from-right").hasClass('add-form')) {
        $('.errAcntType').hide();
        $('.accountSubType').hide();
        $('.openingBalance').hide();
        $('.bankSection').hide();
        $('.accountName').hide();
        $('.upiSection').hide();
        $('.saveBtnList').hide();
        $('.create').show();
    }

});
function updateSectionOnAcccountType()
{
    var account_type = $('#account_type').val();
    if(account_type!="")
    {
       if($('.create').css("display") == "none")
       {
            updateOnAccountSubType(); 
       }else
       {

       }
    }else {
        $('.accountSubType,.openingBalance,.saveBtnList,.upiSection,.bankSection,.accountName').hide();
        $('#account_type').val("");
        $('.errAcntType,.create').show();
        $('.saveBtnList').show();
    }
}
function updateOnAccountSubType() {
    let accountSubType = $('#account_sub_type').val();
    var account_type = $('#account_type').val();
    if (account_type == 2) {
        var msg = 'Loan';
    } else {
        var msg = '';
    }
    if (account_type) {
        if (accountSubType == '') {
            var message = '';
            var accountNum = '';
            $('.accountName').hide();
            $('.accountNumber').hide();
            $('.accountIfscNo').hide();
            $('.accountHolderName').hide();
            $('.upiNo').hide();
            $('.openingBalance').show();

        } else if (accountSubType == '1') {
            var message = msg + ' Bank Account Name';
            var accountNum = msg + ' Bank Account Number';
            $('.accountName').show();
            $('.accountNumber').show();
            $('.accountIfscNo').show();
            $('.accountHolderName').show();
            $('.upiNo').hide();
            $('.openingBalance').show();

        } else if (accountSubType == '2') {
            var message = msg + ' Cash Account Name';
            var accountNum = msg + ' Cash Account Number';
            $('.accountName').show();
            $('.accountNumber').hide();
            $('.accountIfscNo').hide();
            $('.accountHolderName').hide();
            $('.upiNo').hide();
            $('.openingBalance').show();
        } else if (accountSubType == '3') {
            var message = msg + ' UPI Account Name';
            var accountNum = msg + ' UPI Account Number';
            $('.accountName').show();
            $('.accountNumber').hide();
            $('.accountIfscNo').hide();
            $('.accountHolderName').hide();
            $('.upiNo').show();
            $('.openingBalance').show();
        } else {
            var message = '';
            var accountNum = '';
            $('.accountName').hide();
            $('.accountNumber').hide();
            $('.accountIfscNo').hide();
            $('.accountHolderName').hide();
            $('.upiNo').hide();
            $('.openingBalance').show();
        }
    }
    $(".loan_account").text(message);
    $(".loan_account_num").text(accountNum);
    $('#account_name').attr("placeholder", message);
    $('#account_number').attr("placeholder", accountNum);
}

$('.custom-data-table').on('click', '.accountEditForm', function (e) {

    var $this = $(this);
    var uuid = $this.data('uuid');
    var find = $this.data('table');
    var formModal = $this.data('form-modal');
    var message = $this.data('message') ?? 'test message';

    $.ajax({
        type: "get",
        url: baseUrl + 'ajax/edit-data',
        data: {
            'uuid': uuid,
            'find': find
        },
        cache: false,
        dataType: "json",
        beforeSend: function () {

        },
        success: function (response) {
            if (response.status) {
                let update = $("#" + formModal).find('button[type="submit"]').html('Update');
                /* $('.saveBtnList').show()
                $('.create').hide() */
                $.each(response.data, function (index, valueMessage) {
                    console.log(index);
                    $('.saveBtnList').show()
                    $('.create').hide()
                    $("#" + index).val(valueMessage);
                    if (index == 'account_type') {
                        switch (valueMessage) {
                            case '':
                                console.log('click');
                                $('.create').hide()
                                $('.accountSubType').hide()
                                $('.accountName').hide();
                                $('.accountNumber').hide();
                                $('.accountIfscNo').hide();
                                $('.accountHolderName').hide();
                                $('.upiNo').hide();
                                $('.openingBalance').hide();
                                break;
                            case '1':
                                /* $('#accounts_number,#ifsc,#holder_name').show();
                                $('#upi_no').hide(); */
                                $('.accountSubType').show()
                                $('.accountName').hide();
                                $('.accountNumber').hide();
                                $('.accountIfscNo').hide();
                                $('.accountHolderName').hide();
                                $('.upiNo').hide();
                                $('.openingBalance').show();
                                /*  $('.saveBtnList').hide()
                                 $('.create').show() */
                                break;
                            case '2':
                                $('.accountSubType').show()
                                $('.accountName').hide();
                                $('.accountNumber').hide();
                                $('.accountIfscNo').hide();
                                $('.accountHolderName').hide();
                                $('.upiNo').hide();
                                $('.openingBalance').show();
                                break;

                            default:
                                console.log('click')
                                $('.accountSubType').hide()
                                $('.accountName').hide();
                                $('.accountNumber').hide();
                                $('.accountIfscNo').hide();
                                $('.accountHolderName').hide();
                                $('.upiNo').hide();
                                $('.openingBalance').hide();
                                /* $('.saveBtnList').show()
                                $('.create').hide() */
                                break;
                        }
                    }
                    if (index == 'account_sub_type') {
                        switch (valueMessage) {
                            case '1':
                                /* $('#accounts_number,#ifsc,#holder_name').show();
                                $('#upi_no').hide(); */
                                $('.create').hide()
                                $('.accountName').show();
                                $('.accountNumber').show();
                                $('.accountIfscNo').show();
                                $('.accountHolderName').show();
                                $('.upiNo').hide();
                                $('.openingBalance').show();
                                break;
                            case '2':
                                /* $('#accounts_number,#ifsc,#holder_name,#upi_no').hide(); */
                                $('.create').hide()
                                $('.accountName').show();
                                $('.accountNumber').hide();
                                $('.accountIfscNo').hide();
                                $('.accountHolderName').hide();
                                $('.upiNo').hide();
                                $('.openingBalance').show();
                                break;
                            case '3':
                                /* $('#accounts_number,#ifsc,#holder_name,#upi_no').hide(); */
                                $('.create').hide()
                                $('.accountName').show();
                                $('.accountNumber').hide();
                                $('.accountIfscNo').hide();
                                $('.accountHolderName').hide();
                                $('.upiNo').show();
                                $('.openingBalance').show();
                                break;

                            default:
                                $('.create').hide()
                                $('.accountName').hide();
                                $('.accountNumber').hide();
                                $('.accountIfscNo').hide();
                                $('.accountHolderName').hide();
                                $('.upiNo').hide();
                                $('.openingBalance').show();
                                break;
                        }
                    }
                });
                var account_sub_type = $('#account_sub_type').val();
                var account_type = $('#account_type').val();
                if (account_type == 2) {
                    var msg = 'Loan';
                } else {
                    var msg = '';
                }
                if (account_sub_type == '1') {
                    var message = msg + ' Bank Account Name';
                    var accountNum = msg + ' Bank Account Number';
                } else if (account_sub_type == '2') {
                    var message = msg + ' Cash Account Name';
                    var accountNum = msg + ' Cash Account Number';
                } else if (account_sub_type == '3') {
                    var message = msg + 'UPI Account Name';
                    var accountNum = msg + ' UPI Account Number';
                } else {
                    var message = '';
                    var accountNum = '';
                }
                $(".loan_account").text(message);
                $(".loan_account_num").text(accountNum);
                $('#account_name').attr("placeholder", message);
                $('#account_number').attr("placeholder", accountNum);

                $("#" + formModal).addClass("show-side-form");
                $("#" + formModal).addClass("edit-form");
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