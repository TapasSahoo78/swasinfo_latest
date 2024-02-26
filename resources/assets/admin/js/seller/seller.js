
var fieldCounter = 5; /* (initial field counter defined as 1) */
var i;
$(document).on('click', '#add_button', function (e) {
    e.preventDefault();
    i = $(this).data('count');
    if (i < fieldCounter) { //max input box allowed
        var count = $(this).data('count');
        count = parseInt(count) + 1;
        console.log(count);
        $(this).data('count', count);
        i++; //text box increment
        $('#dynamic_field').append(`<div id="row">
                    <div class="grid gap-2 md:grid-cols-1 mt-2">
                        <div class="text-right">
                            <a href="javascript:void(0);" class="btn btn-danger btn_remove" name="remove"  title="Remove field"><i class="fa fa-times pr-3" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="grid gap-2 md:grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium mb-1" for="document">Document Title</label>
                            <input id="title" class="form-control form-input w-full validate_error" type="text" name="document[`+ count + `][title]" placeholder="Title" />
                            <div class="text-xs mt-1 text-rose-500">
                                <span class="error"></span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1" for="password">Document Image </label>
                            <input type="file" class="form-control validate_error" id="document_file" name="document[`+ count + `][file]" accept="image/jpeg,image/png,image/jpg,image/gif">
                            <div class="text-xs mt-1 text-rose-500">
                                <span class="error"></span>
                            </div>
                        </div>
                    </div>

                </div>`);
    }

});
$(document).on('click', '.btn_remove', function () {
    var getCount= i= parseInt($('#add_button').data('count'));
    $('#row').remove();
    $('#add_button').data('count',getCount-1);
    i--;
});
$(document).ready(function () {
    $('.validateForm').click(function (e) {
        e.preventDefault();
        var countValidateForms= $(document).find(".validate_error").length;
        if(countValidateForms> 0){
            $(".validate_error").each(function () {
                var fieldValue = $(this).val();
                if (fieldValue == '') {
                    $(this).addClass('is-invalid');
                    $('.error').html('<p>This Field is required</p>').css('color', 'red');
                } else {
                    $('#sellerForm').submit();
                }
            });
        }else{
            $('#sellerForm').submit();
        }
    })
})
