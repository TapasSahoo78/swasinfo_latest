var baseUrl = APP_URL + '/';
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function () {
    $("#addressForm").validate({
        rules: {
            name: {
                required: true,
            },
            type: {
                required: true,
            },
            is_default: {
                required: true,
            },
            phone_number: {
                required: true,
                number: true
            },
            "full_address[address_line_one]": {
                required: true
            },
            "full_address[state]": {
                required: true
            },
            "full_address[city]": {
                required: true
            },
            "full_address[country]": {
                required: true
            },
            zip_code: {
                required: true,
                number: true
            }
        },
        messages: {
            name: {
                required: "Please enter your name",
            },
            type: {
                required: "Please select a type",
            },
            is_default: {
                required: "Please select a Default address or not",
            },
            phone_number: {
                required: "Please enter your phone number",
            },
        },
        errorElement: "span",
        errorClass: 'is-invalid',
        errorPlacement: function (error, element) {
            error.insertAfter(element);
        },
        submitHandler: function (form) {
            $(".addAddress").prop("disabled", true);
            var formData = new FormData($('#addressForm')[0]);
            $.ajax({
                type: "post",
                data:formData,
                url: baseUrl + 'ajax/customer/addAddress',
                processData: false,
                contentType: false,
                dataType: "json",
                success: function(response){
                    if(response.status){
                        $('#address-card').html(response.data.addressHtml);
                        $('#add-modal').modal('hide');
                        showToast('success','Address','Added or Updated successfully');
                        $('#addressForm').trigger('reset');
                    }
                },
                error: function(){
                    $('#addressForm').trigger('reset');
                    showToast('error','Error','Something Went Wrong');
                },
                done: function(){

                }
            });
        }
    });


    $(document).on('click','.editAddress',function(){
        var uuid= $(this).data('uuid');
        $.ajax({
            type: "post",
            data:{"uuid":uuid},
            url: baseUrl + 'ajax/customer/findAddress',
            dataType: "json",
            success: function(response){
                if(response.status){
                    $.each(response.data, function (key, value) {
                        if(key=="full_address"){
                            $.each(value, function (adkey, advalue) {
                                $('#'+adkey).val(advalue);
                            });
                        }
                        $('#'+key).val(value);
                    });
                    $('#add-modal').modal('show');
                }
            },
            error: function(){
                showToast('error','Error','Something Went Wrong');
            },
            done: function(){

            }
        });
    });
    $(document).on('click','.setDefaultAddress',function(){
        var uuid= $(this).data('uuid');
        $.ajax({
            type: "post",
            data:{"uuid":uuid},
            url: baseUrl + 'ajax/customer/defaultAddress',
            dataType: "json",
            success: function(response){
                if(response.status){
                    $('#address-card').html(response.data.addressHtml);
                    showToast('success','Address','Address set as default');
                }
            },
            error: function(){
                showToast('error','Error','Something Went Wrong');
            },
            done: function(){

            }
        });
    });
    $(document).on('click','.removeAddress',function(){
        var uuid= $(this).data('uuid');
        $.ajax({
            type: "post",
            data:{"uuid":uuid},
            url: baseUrl + 'ajax/customer/deleteAddress',
            dataType: "json",
            success: function(response){
                if(response.status){
                    $('#address-card').html(response.data.addressHtml);
                    showToast('success','Address','Removed Successfully');
                }
            },
            error: function(){
                showToast('error','Error','Something Went Wrong');
            },
            done: function(){

            }
        });
    });
});
