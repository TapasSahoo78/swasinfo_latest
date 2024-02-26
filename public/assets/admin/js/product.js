var baseUrl = APP_URL + '/';
var page_type = $('.page_type').val();
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function() {
    if(page_type== 'edit'){
        // console.log($('.sub_category_id').val());
        var id= $('.sub_category_id').val();
        renderSubcategory($("#category_id"),id);
        renderAttribute($("#category_id"),$("#product_attributes").val());
    }
    $("body").on("click",".add-more",function(){
        var html= $(this).parent().prev().find(".after-add-more").first().clone();
        html.find('input').val('');
        html.find('button').removeClass('clearValue').addClass('deleteAttribute')
        $(this).parent().prev().append(html);
    });
    $("body").on("click",".deleteAttribute,.clearValue",function(){
        if($(this).hasClass('clearValue')){
            $(this).parent().parent().find("div>input").val('');
        }else{
            $(this).parent().parent().parent().remove();
        }
    });

    $('.basePrice').on('change',function(){
        $("body .price").each(function() {
            if($(this).val()=='' || $('.basePrice').val() > $(this).val() ){
                $(this).val($('.basePrice').val());
            }
        });
    });

    $("#category_id").change(function() {
        renderSubcategory($(this));
        renderAttribute($(this));
    });

    $('.addProduct,.editProduct').click(function(e){
        e.preventDefault();
        var success= 1;
        $("body .price").each(function() {
            if($(this).val()!= '' && $('.basePrice').val() > $(this).val() ){
                $(this).addClass('form-control is-invalid').focus();
                $(this).attr('title','price must be equal to or greater than base price')
                success= 0;
            }
        });
        if(success==1){
            $('#productForm').submit();
        }
    });

    $('.checkList,.orderBy').click(function () {
        var formdata = new FormData($('#productFilterForm')[0]);
        if ($(this).hasClass('orderBy')){
            if ($(this).data('attribute')!='all'){
                formdata.append('orderBy', $(this).data('attribute'));
            }
        }
        $.ajax({
            type: "post",
            url: baseUrl + 'admin/products',
            data: formdata,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (response) {
                if (response.status) {
                    $('#productContainer').html(response.data.productHtml);
                }
            },

        });

    })

});

function renderSubcategory(selector,id=''){
    $("#sub_category_id").html('');
    var categoryId= selector.val();
    var html = '';
    var subhtml = '';
    var selected ='';
    $.ajax({
        type: "get",
        url: baseUrl+'ajax/getSubCategories',
        data: {'id':categoryId},
        dataType: "json",
        success: function(response){
            if(response.status){
                var i= 0;
                subhtml = '<option value="">Select Sub Category</option>';
                var categories= response.data;
                $.each(categories, function (key, value) {
                    i= i+1;
                    selected = id !="" && id == key ? "selected" : "" ;
                    subhtml += '<option value="'+key+'" '+selected+' >' + i+ ' ) '+ value['name'] + '</option>';
                    if(value['children']){
                        var j = 0;
                        $.each(value['children'], function (ckey, cvalue) {
                            j = j+1;
                            selected = id !="" && id == ckey ? "selected" : "" ;
                            subhtml += '<option value="'+ckey+'" '+selected+'>\&nbsp;\&nbsp;'+ cvalue +'</option>';
                        });
                    }

                });
            }else{
                subhtml = '<option value="">No data found</option>';
            }
            console.log(subhtml);
            $("#sub_category_id").append(subhtml);
        }
    });
}

function renderAttribute(selector,predefinedValue=''){

    $("#attributeData").html('');
    var attribute = selector.find(':selected').data('attribute');
    for (var key in attribute) {
        html = `<div>
                    <label class="block text-sm font-medium mb-1" for="name">` + attribute[key] + `</label>
                    <div class="d-flex flex-row">`;

        html +=         `<div class="appendInputs">`;

        if(predefinedValue!=''){
            jsonParsedData= JSON.parse(predefinedValue);
            $.each(jsonParsedData, function (index, value) {
                if(index==attribute[key]){
                    $.each(value, function (_vindex, vvalue) {
                        html += `<div class="after-add-more"><div class="grid gap-2 md:grid-cols-3">
                                    <div>
                                        <input class="form-input w-full mb-1 " type="text" name="attribute[`+ key+`][value][]" placeholder="` + attribute[key] + `" value="`+vvalue['value']+`"/>
                                    </div>
                                    <div>
                                        <input class="form-input w-full mb-1 price" type="number" name="attribute[`+ key+`][price][]" placeholder="Price" value="`+vvalue['price']+`" />
                                    </div>
                                    <div class="m-1.5">
                                        <button type="button" class="btn border-slate-200 hover:border-slate-300 clearValue">
                                            <svg class="w-4 h-4 fill-current text-rose-500 shrink-0" viewBox="0 0 16 16">
                                                <path d="M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div></div>`;
                    });
                }
            });
            if($.inArray( attribute[key], jsonParsedData )== -1){
                html += `<div class="after-add-more"><div class="grid gap-2 md:grid-cols-3">
                        <div>
                            <input class="form-input w-full mb-1 " type="text" name="attribute[`+ key+`][value][]" placeholder="` + attribute[key] + `"/>
                        </div>
                        <div>
                            <input class="form-input w-full mb-1 price" type="number" name="attribute[`+ key+`][price][]" placeholder="Price" />
                        </div>
                        <div class="m-1.5">
                            <button type="button" class="btn border-slate-200 hover:border-slate-300 clearValue">
                                <svg class="w-4 h-4 fill-current text-rose-500 shrink-0" viewBox="0 0 16 16">
                                    <path d="M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z"></path>
                                </svg>
                            </button>
                        </div>
                    </div></div>`;
            }
        }else{
            html += `<div class="after-add-more"><div class="grid gap-2 md:grid-cols-3">
                        <div>
                            <input class="form-input w-full mb-1 " type="text" name="attribute[`+ key+`][value][]" placeholder="` + attribute[key] + `"/>
                        </div>
                        <div>
                            <input class="form-input w-full mb-1 price" type="number" name="attribute[`+ key+`][price][]" placeholder="Price" />
                        </div>
                        <div class="m-1.5">
                            <button type="button" class="btn border-slate-200 hover:border-slate-300 clearValue">
                                <svg class="w-4 h-4 fill-current text-rose-500 shrink-0" viewBox="0 0 16 16">
                                    <path d="M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z"></path>
                                </svg>
                            </button>
                        </div>
                    </div></div>`;
        }


        html +=         `</div>`;

        html +=         `<div class="text-center p-2"><a class="btn btn-success btn-sm add-more" data-count="1">+</a></div>
                    </div>
                </div>`;

        $("#attributeData").append(html).removeClass('d-none');
    }
}
