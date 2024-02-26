var baseUrl = APP_URL + '/';
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
var initialMinimumValue= "$0";
var initialMaximumValue= "$1000";
$('.filterBy,.orderBy,.paginate').on('change',function (e) {
    filterProducts();
});
$('.apply,.priceRange').on('click',function (e) {
    if($(this).hasClass('apply')){
        $('.priceRange').prop('checked', false);
    }

    filterProducts();
});
function filterProducts(){
    var formdata = new FormData($('#productFilterForm')[0]);
    if(formdata.has('priceRange')){
        formdata.delete('sliderPrice');
    }
    formdata.append('orderBy', $('.orderBy').val());
    formdata.append('paginate', $('.paginate').val());
    $.ajax({
        type: "post",
        url: baseUrl + 'shop-by-type',
        data: formdata,
        processData: false,
        contentType: false,
        dataType: "json",
        success: function (response) {
            if (response.status) {
                $('.product_grid_view').html(response.data.productHtml);
                $('.product_list_view').html(response.data.producthorizontalHtml);
            }
        },
    });
}
