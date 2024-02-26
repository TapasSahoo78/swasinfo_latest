$(function () {

    var $modal = $('#cropmodal');
    var image = document.getElementById('image');
    var cropper;
    var filename;
    var container;
    var type;
    var acceptedArray=['image/jpg','image/png','image/jpeg'];
    $(document).on('change', '.pro-file-upload', function (e) {
        e.preventDefault();
        var files = e.target.files;
        if($.inArray(files[0].type.toLowerCase(),acceptedArray)<0){
            $(this).addClass('is-invalid');
            $(this).attr('title', 'Please enter a valid image of type png or jpg');
            $(this).val('');
            $(this).parent().find('label.custom-file-label').html('<span class="text-danger">Invalid File Type</span>');
            return false;
        }else if(files[0].size >(1024*1024)){
            $(this).addClass('is-invalid');
            $(this).attr('title', 'Please enter a valid image of less than 1 MB');
            $(this).val('');
            $(this).parent().find('label.custom-file-label').html('<span class="text-danger">Invalid File Size</span>');
            return false;
        }
        $(this).parent().find('label.custom-file-label').html('<span class="text-danger"></span>');
        var done = function (url) {

            image.src = url;
            $modal.modal('show');
        };
        var reader;
        var file;
        var url;
        if (files && files.length > 0) {
            file = files[0];
            filename = file.name;
            if (URL) {
                done(URL.createObjectURL(file));
            } else if (FileReader) {
                reader = new FileReader();
                reader.onload = function (e) {
                    done(reader.result);
                };
                reader.readAsDataURL(file);
            }
        }
        container = $(this).data('container');
        type = $(this).data('type');
    });
    $modal.on('shown.bs.modal', function () {
        cropper = new Cropper(image, {
            aspectRatio: type == "cover photo" ? 16/9 : 1,
            viewMode: 3,
            preview: '.preview',
            responsive: true,
        });
    }).on('hidden.bs.modal', function () {
        cropper.destroy();
        cropper = null;
    });
    $("#crop").click(function () {
        var currentImage = $(container).attr('src');
        var canvas = cropper.getCroppedCanvas({
            minWidth: 160,
            minHeight: 160,
            maxWidth: 1920,
            maxHeight: 1920,
        });
        canvas.toBlob(function (blob) {
            var reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = function () {
                var base64data = reader.result;
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: baseUrl + 'customer/update-profile-image',
                    type: "post",
                    data: { 'rawImageContent': base64data, 'tag': 'profileImage' },
                    dataType : "json",
                    beforeSend: function(){
                        $('span.imageuploading').append('<i class="fa fa-fw fa-spinner fa-spin"></i>');
                    },
                    success: function(response){
                        if(response.status){
                            $modal.modal('hide');
                            $(container).attr('src', base64data);
                            $('.avatar').attr('src', response.data.profileImage);
                            $.toast({
                                heading: 'Success',
                                text: response.message,
                                position: TOAST_POSITION,
                                icon: 'success',
                                stack: false
                            });
                        }else{
                            $.toast({
                                heading: 'Error',
                                text: response.message,
                                position: TOAST_POSITION,
                                icon: 'error',
                                stack: false
                            });
                        }
                    },
                    error: function(response){
                        $.toast({
                            heading: 'Information',
                            text: 'We are facing some technical issue now. Please try again after some time.',
                            position: TOAST_POSITION,
                            icon: 'info',
                            stack: false
                        });
                    },
                    complete: function(){
                        $('span.imageuploading').html('');
                    }
                });
            }
        });
    });
});
