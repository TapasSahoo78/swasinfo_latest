chnageLinkInput($('.is_external').find('option:selected').val());
$('.menu_position').on('change', function () {
    $('.position').trigger('change').val('');
    if ($(this).val() == 'footer') {
        $('.position').prop('disabled', false);
    } else {
        $('.position').prop('disabled', true);
    }
});
$('.url').on('change', function () {
    $('.page_id').val($(this).find('option:selected').data('id'));
});
if ($('.is_external').val()=='0'){
    $('.page_id').val($('.url').find('option:selected').data('id'));
}

$('.menu_position').find('option:selected').val() == 'footer' ? $('.position').prop('disabled', false) : '';

$('.is_external').on('change', function () {
    chnageLinkInput($(this).val());
});



function chnageLinkInput(value){
    if (value == '1') {
        $('.url').hide().attr('disabled', true);
        $('.urlLabel').text('Please provide a url');
        $('.url-box').attr('type', 'url').attr('disabled', false);
    } else {
        $('.url').show().attr('disabled', false);
        $('.urlLabel').text('Select Page');
        $('.url-box').attr('disabled', true).attr('type', 'hidden');
    }
}
