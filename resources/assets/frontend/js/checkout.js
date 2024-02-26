$(document).ready(function(){
    $('#gridCheck').click(function () {
        if ($(this).is(':checked')) {
            let name = $('#name').val();
            let address_line_one = $('#address_line_one').val();
            let address_line_two = $('#address_line_two').val();
            let phone_number = $('#phone_number').val();
            let city = $('#city').val();
            let state = $('#state').val();
            let zip_code = $('#zip_code').val();
            $('#address_name').val(name);
            $('#shipping_address_line_one').val(address_line_one);
            $('#shipping_address_line_two').val(address_line_two);
            $('#shipping_phone_number').val(phone_number);
            $('#shipping_city').val(city);
            $('#shipping_state').val(state);
            $('#shipping_zip_code').val(zip_code);

        }else{
            $('#address_name').val('');
            $('#shipping_address_line_one').val('');
            $('#shipping_address_line_two').val('');
            $('#shipping_phone_number').val('');
            $('#shipping_city').val('');
            $('#shipping_state').val('');
            $('#shipping_zip_code').val('');
        }
    });

});