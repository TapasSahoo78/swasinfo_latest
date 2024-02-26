tinymce.init({
    selector: "textarea:not(.detail_ad, .report_bug, .google_analytics, .robot_txt, .meta_description, .package_description, .not_editor)",

    paste_data_images: false,

    height : "250",

    plugins: [

      "advlist lists  charmap  preview hr anchor pagebreak",

      "searchreplace wordcount visualblocks visualchars code fullscreen",

      "insertdatetime  nonbreaking save table contextmenu directionality",

      "emoticons template paste textcolor colorpicker textpattern"

    ],

    toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",

    toolbar2: "print preview media | forecolor backcolor emoticons",

    image_advtab: true,
    menubar : false ,
    file_picker_callback: function(callback, value, meta) {

      if (meta.filetype == 'image') {

        $('#upload').trigger('click');

        $('#upload').on('change', function() {

          var file = this.files[0];

          var reader = new FileReader();

          reader.onload = function(e) {

            callback(e.target.result, {

              alt: ''

            });

          };

          reader.readAsDataURL(file);

        });

      }

    },

  });
