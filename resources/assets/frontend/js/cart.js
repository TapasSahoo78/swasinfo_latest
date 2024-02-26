var baseUrl = APP_URL + '/';

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function () {
    $(document).on('click', '.addToCart', function () {
        var uuid = $(this).data('uuid')
        $.ajax({
            type: "post",
            url: baseUrl + 'ajax/add-to-cart',
            data: { 'uuid': uuid },
            dataType: "json",
            success: function (response) {
                if (response.status) {
                    $('.cartProducts').html(response.data.cartHtml);
                    showToast('success', 'Cart', 'Product Added to cart successfully');
                } else {
                    showToast('error', 'Cart', 'Sorry something went wrong');
                }
            },
        });
    });
    $(document).on('click', '.clearCart', function () {

        $.ajax({
            type: "post",
            url: baseUrl + 'ajax/clear-cart',
            data: {},
            dataType: "json",
            success: function (response) {
                if (response.status) {
                    $('.cart-card').html(response.data.cartHtml);
                    showToast('success','Cart','Cart cleared successfully');
                }else{
                    showToast('error','Cart','Sorry something went wrong');
                }
            },
        });
    });
    $(document).on('click', '.removeFromCart', function () {
        var id = $(this).data('id')
        $.ajax({
            type: "post",
            url: baseUrl + 'ajax/remove-from-cart',
            data: { 'id': id },
            dataType: "json",
            success: function (response) {
                if (response.status) {
                    $('.cart-card').html(response.data.cartHtml);
                    showToast('success', 'Cart', 'Product Removed from cart successfully');
                } else {
                    showToast('error', 'Cart', 'Sorry something went wrong');
                }
            }, done: function (response) {
                setTimeout(() => {
                    showCartTotal();
                }, 500);

            }
        });
    });
    $(document).on('click', '.quantity-plus,.quantity-minus', function () {
        var id = $(this).data('id')
        var quantity = $(this).hasClass('quantity-plus') ? parseInt($(this).data('quantity')) + 1 : parseInt($(this).data('quantity')) - 1
        $.ajax({
            type: "post",
            url: baseUrl + 'ajax/update-cart',
            data: { 'id': id, 'quantity': quantity },
            dataType: "json",
            success: function (response) {
                if (response.status) {
                    $('.cart-card').html(response.data.cartHtml);
                    showToast('success', 'Cart', 'Product updated in cart successfully');
                } else {
                    showToast('error', 'Cart', 'Sorry something went wrong');
                }
            },
        });
        showCartTotal();
    });
    $(".add").click(function () {
        if ($(this).prev().val() < 10) {
            $(this).prev().val(+$(this).prev().val() + 1);
        }
    });
    $(".sub").click(function () {
        if ($(this).next().val() > 1) {
            $(this).next().val(+$(this).next().val() - 1);
        }
    });

    $('.delivery-type').click(function (e) {
        if ($(this).val() == 'delivery') {
            $('.delivery').removeClass('d-none');
            $('.store-pickup').addClass('d-none');
        } else if ($(this).val() == 'store-pickup') {
            $('.store-pickup').removeClass('d-none');
            $('.delivery').addClass('d-none');
        }
    });

    /* search a zip code */

    $("#zip_code").keyup(function (e) {
        validateZipCode();
        console.log("test");
    });
    $("#zip_code").blur(function (e) {
        let html = '';
        let is_validate = validateZipCode();
        if (is_validate == true) {
            let zip = $(this).val();
            console.log(zip);
            $.ajax({
                type: "post",
                url: baseUrl + 'ajax/store-pickup',
                data: { zip:zip },
                dataType: "json",
                success: function (response) {
                    if(response.status){
                        $.each(response.data, function (key, value) { 
                            html += `<div><label for=""><input type="radio" name="storaddress" value="` + value.full_address + `" class="form-control" id=""></input>` + value.full_address +`</label></div>`;
                        });
                        $('#pickupAddress').html(html);
                    }else{
                        $('#pickupAddress').empty();
                    }
                    


                }
            });
            //console.log(value);
        }

    });

});

function validateZipCode() {


    let zip_code = $("#zip_code").val();
    var regex = new RegExp(/^[1-9]{1}[0-9]{2}\s{0,1}[0-9]{3}$/);

    if (regex.test(zip_code)) {
        $("#zip_code").removeClass('is-invalid');
        return true;
    } else {
        $("#zip_code").addClass('is-invalid');
        return false;
    }


}

