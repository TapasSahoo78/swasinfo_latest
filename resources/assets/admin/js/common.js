// JavaScript Document
'use strict';
var baseUrl = APP_URL + '/';
var flashstatus = $('span.flashstatus').text();
var flashmessage = $('span.flashmessage').text();
var pagetype = jQuery('input[name="pagetype"]').val();
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function (e) {
    showCartTotal();
    $('.passwordHideShow').on('click', function () {
        $(this).find('.passwordHidden,.passwordShowed').toggleClass('d-none');
        var input = $(this).closest('.relative').find('.passwordField');
        input.attr("type") == "password" ? input.attr("type", "text") : input.attr("type", "password");
    });
    $(".leave").click(function () {
        window.location.replace('https://google.com', '_self');
    });
    if ($.isFunction($.fn.tooltip)) {
        $('[data-toggle="tooltip"]').tooltip()
    }
    /* ACCORDION */
    (function () {
        'use strict';
        //  Faqs Accordion
        var faqsAccordion = function () {
            var faqAcc = $('.faq-accordion h3');
            // Click
            faqAcc.on('click', function (event) {
                var $this = $(this);

                $('.faq-accordion').removeClass('active');
                $('.faq-accordion').find('.faq-body').slideUp(400);

                if (!$this.closest('.faq-accordion').find('.faq-body').is(':visible')) {
                    $this.closest('.faq-accordion').addClass('active');
                    $this.closest('.faq-accordion').find('.faq-body').slideDown(400);
                } else {
                    $this.closest('.faq-accordion').removeClass('active');
                    $this.closest('.faq-accordion').find('.faq-body').slideUp(400);
                }
                event.preventDefault();
                return false;
            });
        };
        // Document on load.
        $(function () {
            faqsAccordion();
        });
    }());

    if ($.isFunction($.fn.select2)) {
        $('.js-example-basic-single').select2();
    }

    if ($.isFunction($.fn.select2)) {
        $('.js-example-basic-single-multiple').select2({
            closeOnSelect: false,
            placeholder: "Please choose",
            allowHtml: true,
            allowClear: true,
            tags: true,
            containerCssClass: "multi-selector",
            dropdownCssClass: "multi-dropdown-checker"
        });
    }
    function iformat(icon, badge,) {
        var originalOption = icon.element;
        var originalOptionBadge = $(originalOption).data('badge');

        return $('<span><i class="fa ' + $(originalOption).data('icon') + '"></i> ' + icon.text + '<span class="badge">' + originalOptionBadge + '</span></span>');
    }
    /* $.ajaxSetup({
        'beforeSend': function () {
            $('.loader-blur, .loader').show();
        },
        'complete': function () {
            $('.loader-blur, .loader').hide();
        }
    }); */

    if (flashstatus == 'SUCCESS') {
        $.toast({
            heading: 'Success',
            text: flashmessage,
            loader: true,
            icon: 'success',
            position: TOAST_POSITION
        });
    }

    if (flashstatus == 'ERROR') {
        $.toast({
            heading: 'Error',
            text: flashmessage,
            loader: true,
            icon: 'error',
            position: TOAST_POSITION
        })
    }

    if (flashstatus == 'INFORMATION') {
        $.toast({
            heading: 'Information',
            text: flashmessage,
            loader: true,
            icon: 'info',
            position: TOAST_POSITION
        })
    }

    if (flashstatus == 'WARNING') {
        $.toast({
            heading: 'Warning',
            text: flashmessage,
            loader: true,
            icon: 'warning',
            position: TOAST_POSITION
        })
    }

    //toggle password

    $(document).on('click', '.toggle-password, #psd', function () {

        $(this).toggleClass("showPsd");

        var input = $("#password");
        input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
    });
    $(document).on('click', '#psdnew', function () {

        $(this).toggleClass("showPsd");

        var input = $("#newpassword");
        input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
    });
    $(document).on('click', '#psdconfirm', function () {

        $(this).toggleClass("showPsd");

        var input = $("#confirmpassword");
        input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
    });
    $(".menu-toggle").click(function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
        $(this).toggleClass('is-active');
        if ($(this).hasClass('is-active')) {
            $('.c-sidebar a').tooltip('enable');
        } else {
            $('.c-sidebar a').tooltip('disable');
        }
    });
    $(".dropdown-menu a").on('click', function () {
        $(this).parents('.btn-group').children(".btn:first-child").html($(this).text() + ' <span class="caret"></span>');
    });
    $(document).on('click', '.reload', function (e) {
        console.log('this is reload');
        location.reload();
    });

    $('form.formsubmit').on('submit', function (e) {

        e.preventDefault();
        var $this = $(this);
        /* console.table($this); */
        var formActionUrl = $this.prop('action');
        if ($($this).hasClass('fileupload')) {
            var fd = new FormData(document.getElementById($($this).attr('id')));
        } else {
            var fd = $($this).serialize();
        }

        // console.log(formActionUrl);
        let commonOption={'type':'post','url':formActionUrl,'data':fd,'dataType':"json"};
        if ($($this).hasClass('fileupload')) {
            commonOption['cache']=false;
            commonOption['processData']=false;
            commonOption['contentType']=false;
        }
        // console.log(commonOption);
        // return false;
        // console.log($($this).attr('id'));
        $.ajax({
            ...commonOption,
            beforeSend: function () {
            },
            success: function (response) {
                if (response.status) {

                    if($('#lead_uuid').val())
                    {
                        Swal.fire({
                            icon: 'success',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        $(location).attr('href', customerRedirectUrl);
                    }else
                    {
                        Swal.fire({
                            icon: 'success',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        location.reload();
                    }
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
                console.log(response);
                let responseJSON = response.responseJSON;
                $(".err_message").removeClass("d-block").hide();
                $("form .form-control").removeClass("is-invalid");
                $.each(responseJSON.errors, function (index, valueMessage) {
                    $("#" + index).addClass('is-invalid');
                    $("#" + index).after("<p class='d-block text-danger err_message'>" + valueMessage + "</p>");
                });



                // Swal.fire({
                //     icon: 'error',
                //     title: 'We are facing some technical issue now. Please try again after some time',
                //     showConfirmButton: false,
                //     timer: 1500
                // })
            }
            /* ,
            complete: function(response){
                location.reload();
            } */
        });

    });


    $(document).ready(function () {
        $('#country_name').on('change', function () {
            var country_name = this.value;
            $("#state_name").html('');
            $.ajax({
                type: "post",
                url: baseUrl + 'ajax/get-states-by-country',
                data: {
                    country_name: country_name,
                },
                dataType: 'json',
                success: function (result) {
                    $('#state_name').html('<option value="">Select State</option>');
                    $.each(result.states, function (key, value) {
                        $("#state_name").append('<option value="' + value.name + '">' +
                            value.name + '</option>');
                    });
                    $('#city_name').html('<option value="">Select State First</option>');
                }
            });
        });
        $('#country').on('change', function () {
            var country_name = this.value;
            $("#states_name").html('');
            $.ajax({
                type: "post",
                url: baseUrl + 'ajax/get-states-by-country',
                data: {
                    country_name: country_name,
                },
                dataType: 'json',
                success: function (result) {
                    $('#states_name').html('<option value="">Select State</option>');
                    $.each(result.states, function (key, value) {
                        $("#states_name").append('<option value="' + value.name + '">' +
                            value.name + '</option>');
                    });
                    $('#cities_name').html('<option value="">Select State First</option>');
                }
            });
        });
        $('#state_name').on('change', function () {
            var state_name = this.value;
            $("#city_name").html('');
            $.ajax({
                url: baseUrl + 'ajax/get-cities-by-state',
                type: "post",
                data: {
                    state_name: state_name,
                },
                dataType: 'json',
                success: function (result) {
                    $('#city_name').html('<option value="">Select City</option>');
                    $.each(result.cities, function (key, value) {
                        $("#city_name").append('<option value="' + value.name + '">' +
                            value.name + '</option>');
                    });
                }
            });
        });
        $('#states_name').on('change', function () {
            var state_name = $("#states_name").val();
            console.log($("#states_name").val());
            $("#cities_name").html('');
            $.ajax({
                url: baseUrl + 'ajax/get-cities-by-state',
                type: "post",
                data: {
                    states_name: state_name,
                },
                dataType: 'json',
                success: function (result) {
                    $('#cities_name').html('<option value="">Select City</option>');
                    $.each(result.cities, function (key, value) {
                        $("#cities_name").append('<option value="' + value.name + '">' +
                            value.name + '</option>');
                    });
                }
            });
        });
    });

    $('.custom-data-table').on('click', '.edit-mfi', function (e) {
        var $this = $(this);
        var uuid = $this.data('uuid');
        var find = $this.data('table');
        var message = $this.data('message') ?? 'test message';
        console.log(uuid);
        //var routeURL= baseUrl + 'ajax/edit-mfi'
        // Swal.fire({
        //     title: 'Are you sure you want to edit it?',
        //     icon: 'warning',
        //     showCancelButton: true,
        //     confirmButtonColor: '#3085d6',
        //     cancelButtonColor: '#d33',
        //     confirmButtonText: 'Yes, edit it!'
        // }).then((result) => {
        // if (result.isConfirmed) {
        $('#add').text('Update');
        // $('#update').show();
        $.ajax({
            type: "post",
            url: baseUrl + 'ajax/edit-mfi',
            data: { 'uuid': uuid, 'find': find },
            cache: false,
            dataType: "json",
            success: function (data) {
                console.log(data);
                if (data.status) {
                    var userdata = data.data;
                    let update = $("#slide-from-right").find('button[type="submit"]').html('Update');
                    $("#slide-from-right").find('button[type="reset"]').addClass('reload');
                    $("#slide-from-right").find('button[type="reset"]').html('Cancel');

                    $.each( data.data, function (index, valueMessage) {
                        console.log(index);
                        $("#" + index).val(valueMessage);
                    });
                    $('#login_id').attr('readonly', true);
                    $('#code').attr('readonly', true);
                    // $('#id').val(userdata.uuid);
                    // $('#name').val(userdata.name);
                    // $('#code').val(userdata.code);
                    // $('#registration_number').val(userdata.registration_number);
                    // $('#login_id').val(userdata.user.login_id).attr('readonly', 'true');
                    // $('#contact_person_name').val(userdata.user.first_name);
                    // $('#user_id').val(userdata.user.id);
                    // // $('#branch_id').val(userdata.user.branch.id);
                    // $('#contact_person_email').val(userdata.user.email);
                    // $('#contact_person_phone').val(userdata.user.mobile_number);
                    // $('#landmark').val(userdata.landmark);
                    // $('#country_name').val(userdata.country_name);
                    // $('#state_name').val(userdata.state_name);
                    // $('#city_name').val(userdata.city_name);
                    // $('#zip_code').val(userdata.zip_code);
                    // $('#full_address').val(userdata.full_address);
                    $("#logo").css('display','block');
                    $("#logo").html(`<img src = "${userdata.logo_picture}" alt="image">`);


                    /* $("#btnText").removeText('ADD');
                    $("#btnText").addText('UPDATE'); */
                    $("#slide-from-right").addClass("show-side-form");
                    $('.formsubmit').attr('action', baseUrl + 'admin/mfis/update');
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
        });
        // });
    });

    $('.close-btn').click(function (e) {
        $('.formsubmit').trigger('reset');
        $(".slide-from-right").removeClass("show-side-form");
    });



    $('.custom-data-table').on('click', '.changeStatus', function (e) {
        
        var $this = $(this);
        var uuid = $this.data('uuid');
        var value = $this.data('value');
        var find = $this.data('table');
        var message = $this.data('message') ?? 'test message';
        Swal.fire({
            title: 'Are you sure you want to ' + message + ' it?',
            text: 'The status will be changed to ' + message,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, ' + message + ' it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "put",
                    url: baseUrl + 'ajax/updateStatus',
                    data: { 'uuid': uuid, 'find': find, 'value': value },
                    cache: false,
                    dataType: "json",
                    beforeSend: function () {

                    },
                    success: function (response) {
                        if (response.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Status Updated!',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            location.reload();
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
            }
        });
    });
    $('.custom-data-table').on('click', '.deleteData', function (e) {
        var $this = $(this);
        var uuid = $this.data('uuid');
        var find = $this.data('table');
        var message = $this.data('message') ?? 'test message';
        Swal.fire({
            title: 'Are you sure you want to delete it?',
            text: 'You wont be able to revert this action!!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "delete",
                    url: baseUrl + 'ajax/deleteData',
                    data: { 'uuid': uuid, 'find': find },
                    cache: false,
                    dataType: "json",
                    beforeSend: function () {

                    },
                    success: function (response) {
                        if (response.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted Successfully',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            location.reload();
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
            }
        });
    });
    $('.custom-data-table').on('click', '.editData', function (e) {
        var $this = $(this);
        var uuid = $this.data('uuid');
        var find = $this.data('table');
        var formModal = $this.data('form-modal');
        var message = $this.data('message') ?? 'test message';

        $.ajax({
            type: "get",
            url: baseUrl + 'ajax/edit-data',
            data: { 'uuid': uuid, 'find': find },
            cache: false,
            dataType: "json",
            beforeSend: function () {

            },
            success: function (response) {
                if (response.status) {
                    let update = $("#" + formModal).find('button[type="submit"]').html('Update');
                    // $("#" + formModal).find('button[type="reset"]').attr('disabled', 'disabled');
                    $("#" + formModal).find('button[type="reset"]').html('Cancel');
                    $("#" + formModal).find('button[type="reset"]').addClass('reload');
                    $("#" + formModal).addClass("show-side-form");
                    $.each(response.data, function (index, valueMessage) {
                        console.log(index);
                        $("#" + index).val(valueMessage);
                    });
                    if(response.data.code){
                        $('#code').attr('readonly',true);
                    }
                    if(response.data.login_id){
                        $('#login_id').attr('readonly',true);
                    }

                    /* if (response.data.search){
                        $('#search').val();
                        alert()
                    } */
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
    $('.custom-data-table').on('click', '.viewStatus', function (e) {
        // setTimeout(function () {
        //     var demand_value = $('#demand_status').val();
        //     deMandStatus(demand_value);
        // }, 1000);


        var $this = $(this);
        var uuid = $this.data('uuid');
        console.log(uuid);
        var find = $this.data('table');
        var viewModal = $this.data('view-modal');
        var message = $this.data('message') ?? 'test message';



        $.ajax({
            type: "get",
            url: baseUrl + 'ajax/view-data',
            data: { 'uuid': uuid, 'find': find },
            cache: false,
            dataType: "json",
            beforeSend: function () {

            },
            success: function (response) {
                if (response.status) {

                    /* let update = $("#" + formModal).find('button[type="submit"]').html('Update');
                    $("#" + formModal).find('button[type="reset"]').attr('disabled', 'disabled'); */
                    $("#" + viewModal).addClass("show-side-form");
                    $.each(response.data, function (index, valueMessage) {
                        console.log(index);
                        $("#" + index).val(valueMessage);
                    });
                    $("#loan-process-show").html(response.data.loan_status_process);

                    deMandStatus();
                    let demand_status = $('#demand_status').val();
                    let disbursement_status = $('#disbursement_status').val();
                    if ((demand_status == '2') &&(disbursement_status=='1'))
                    {
                        $("#slide-from-right-view").find('button[type="submit"]').attr('disabled', 'disabled');
                    }else{
                        $("#slide-from-right-view").find('button[type="submit"]').attr('disabled', false);
                    }

                    if ((demand_status == '0') || (demand_status == '3')) {
                        $("#slide-from-right-view").find('button[type="submit"]').attr('disabled', 'disabled');
                    } else {
                        $("#slide-from-right-view").find('button[type="submit"]').attr('disabled', false);
                    }

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

    $('.createDemand').click(function (e) {
        //$("#slide-from-right-demand").addClass("show-side-form");
        let user_id = $(this).data('id');
        $('#user_id').val(user_id);
        $("#slide-from-right-demand").addClass("show-side-form");
        //alert(user_id);


    });

    $('.deleteDocument').on('click', function (e) {
        var $this = $(this);
        var uuid = $this.data('uuid');
        var find = $this.data('table');
        Swal.fire({
            title: 'Are you sure you want to delete it?',
            text: 'You wont be able to revert this action!!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "delete",
                    url: baseUrl + 'ajax/deleteData',
                    data: { 'uuid': uuid, 'find': find },
                    cache: false,
                    dataType: "json",
                    beforeSend: function () {

                    },
                    success: function (response) {
                        if (response.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted Successfully',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            location.reload();
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
            }
        });
    });

    $('.custom-data-table').on('click', '.changeUserStatus,.changeUserBlock', function (e) {
        
        var $this = $(this);
        var uuid = $this.data('uuid');
        if ($this.hasClass('changeUserStatus')) {
            var value = {
                'is_active': $this.data('value')
            };
        } else {
            var value = {
                'is_blocked': $this.data('block')
            };
        }
        var find = $this.data('table');
        var message = $this.data('message') ?? 'test message';
        Swal.fire({
            title: 'Are you sure you want to ' + message + ' it?',
            text: 'The status will be changed to ' + message,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, ' + message + ' it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "put",
                    url: baseUrl + 'ajax/updateStatus',
                    data: { 'uuid': uuid, 'find': find, 'value': value },
                    cache: false,
                    dataType: "json",
                    beforeSend: function () {

                    },
                    success: function (response) {
                        if (response.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Status Updated!',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            location.reload();
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
            }
        });
    });
    //toggle checkout card price
    $(".chkout-card-header").on("click", function (e) {
        $(this).toggleClass("expanded");
        $('.chkout-card-body').slideToggle();
    });

    $(document).on('change', '.country, .countrycity', function () {
        var cityHtml = '<option value="">Select city</option>';
        var timezoneHtml = '<option value="">Select timezone</option>';

        var cities = $('option:selected', this).attr('cities');
        cities = JSON.parse(cities);

        if ($('option:selected', this).attr('timezones')) {
            var timeZones = $('option:selected', this).attr('timezones');
            timeZones = JSON.parse(timeZones);
        }

        if (cities != '') {
            if ($(this).hasClass('countrycity')) {
                for (var key in cities) {
                    cityHtml += '<option value="' + cities[key] + '">' + cities[key] + '</option>';
                }
            } else {
                for (const [key, value] of Object.entries(cities)) {
                    cityHtml += '<option value="' + key + '">' + value + '</option>';
                }
            }
        }

        if (timeZones != '') {
            $(timeZones).each(function (key, value) {
                timezoneHtml += '<option value="' + value + '">' + value + '</option>';
            });
        }

        $('select[name="city"]').html(cityHtml);
        $('select[name="timezone"]').html(timezoneHtml);
    });

    //mobile search
    $('#advanced__search__button').click(function () {
        $('.escort-filter-wrapper').addClass('active');
        $('body').addClass('filter-open').append("<div class='body-overlay'></div>");
        $('body').find('.body-overlay').fadeIn(100);
    });
    $('.search-main-close').click(function () {
        $('.escort-filter-wrapper').removeClass('active');
        $('body').find('.body-overlay').fadeOut(100);
    });
    //mobile search toggle
    $('#advanced__search__mobile').click(function () {
        $('.advanced__search__area').addClass('active');
    });
    $('.search-close').click(function () {
        $('.advanced__search__area').removeClass('active');
    });
    //desktop search toggle
    $('#advanced__search').click(function () {
        $('.advanced__search__area').toggleClass('active');
        // $('body').addClass('modal-open');
    });
    $('#filter__search').click(function () {
        $('.advanced__search__area').addClass('active');
        $('body').addClass('modal-open');
    });
    $('.advanced__search__cross').click(function () {
        $('.advanced__search__area').removeClass('active');
        // $('body').removeClass('modal-open');
    });

    $('#open__image__modal').click(function () {
        $('#image__modal').addClass('active');
        $('body').addClass('modal-open');
    });

    $('#open__video__modal').click(function () {
        $('#video__modal').addClass('active');
        $('body').addClass('modal-open');
    });
    $('.toggle__search').click(function () {
        $('#search__modal').addClass('active');
        $('body').addClass('modal-open');
    });

    $('.post__modal__btn').click(function () {
        $('#post__modal').addClass('active');
        $('body').addClass('modal-open');
    });
    $('.toggle__nav').on('click', function () {
        $(this).toggleClass('active');
        $('.o-content').toggleClass('active');
        $('body').toggleClass('sideBar-active');
    });

    $('.tab-pane:first').show();
    $('.filter--tab:first').addClass('current');
    $('.filter--tab').click(function () {
        if (!$(this).hasClass('current')) {
            $('.filter--tab.current').removeClass('current');
            $(this).addClass('current');
        } else {
            $(this).removeClass('current');
        }
        $(this).next().toggleClass('active');
        $('.tab-pane').not($(this).next()).removeClass('active');
    });

    //$('.notify-dropdown').hide();
    $('.notify-dp').on('click', function (e) {
        e.stopPropagation(),
            e.preventDefault();
        $('.notify-dropdown').slideToggle('slow');
        $('body').toggleClass('fixed');
        $('.o-navbar').toggleClass('nav-down');
    });
    $('.notf-close-modal').on('click', function (e) {
        e.stopPropagation();
        $('.notify-dropdown').fadeOut('fast');
        $('body').removeClass('fixed');
        $('.o-navbar').removeClass('nav-down');
    });

    // Select all links with hashes
    $('.static-base a[href*="#"]')
        // Remove links that don't actually link to anything
        .not('[href="#"]')
        .not('[href="#0"]')
        .click(function (event) {
            // On-page links
            if (
                location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '')
                &&
                location.hostname == this.hostname
            ) {
                // Figure out element to scroll to
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                // Does a scroll target exist?
                if (target.length) {
                    // Only prevent default if animation is actually gonna happen
                    event.preventDefault();
                    $('html, body').animate({
                        scrollTop: target.offset().top - 80
                    }, 1000, function () {
                        // Callback after animation
                        // Must change focus!
                        var $target = $(target);
                        $target.focus();
                        if ($target.is(":focus")) { // Checking if the target was focused
                            return false;
                        } else {
                            $target.attr('tabindex', '-1'); // Adding tabindex for elements not focusable
                            $target.focus(); // Set focus again
                        };
                    });
                }
            }
        });

    if ($('input[type=hidden][name="postdetailsurl"]').length) {
        var clipboard = new Clipboard('.copytoclipboardpost', {
            text: function () {
                return document.querySelector('input[type=hidden][name="postdetailsurl"]').value;
            }
        });

        clipboard.on('success', function (e) {
            $.toast({
                heading: "Info",
                text: "Post url copied.",
                loader: true,
                icon: "info",
                position: TOAST_POSITION,
            });

            e.clearSelection();
        });
    }
    // $('.custom-data-table').on('click', '.loan_id', function (e) {

    $('.formsubmit').on('change','#demand_status',function(e) {
        var demand_value = $(this).val();
        deMandStatus();

        //alert(demand_value);
        //alert('click');
        //console.log("test");
        // var $this = $(this);
       /*  let  id = $(this).data('id');
        var principal_amount = $(this).find(':selected').attr('data-principal-amount')
        if (principal_amount){
            $("#loan_amount").val(principal_amount);
            $("#loan_amount").attr('readonly', true);
        }else{
            $("#loan_amount").val("");
            $("#loan_amount").attr('readonly', false);
        } */

    });

});
var transparent = $('.navbar--transparent').length;
$(window).on("scroll", function () {
    if (transparent) {
        if ($(window).scrollTop() > 0) {
            $(".o-navbar").removeClass("navbar--transparent");
        } else {
            $(".o-navbar").addClass("navbar--transparent");
        }
    }
});

$(".compare_section").click(function () {
    $('html,body').animate({
        scrollTop: $("#compare_block").offset().top
    },
        'slow');
});

function deMandStatus(){
    let demand_value = $('#demand_status').val();

    if (demand_value == '') {
        $('#disbursedListShow').hide();
    } else if (demand_value == '0') {
        $('#disbursedListShow').hide();
    } else if (demand_value == '1') {
        $('#disbursedListShow').hide();
    } else if (demand_value == '2') {
        $('#disbursedListShow').show();
    } else if (demand_value == '3') {
        $('#disbursedListShow').hide();
    } else if (demand_value == '4') {
        $('#disbursedListShow').hide();
    }
}

$('.formsubmit').on('change', '#demand_status', function (e) {
    var demand_value = $(this).val();
    deMandStatus();

    //alert(demand_value);
    //alert('click');
    //console.log("test");
    // var $this = $(this);
    /*  let  id = $(this).data('id');
     var principal_amount = $(this).find(':selected').attr('data-principal-amount')
     if (principal_amount){
         $("#loan_amount").val(principal_amount);
         $("#loan_amount").attr('readonly', true);
     }else{
         $("#loan_amount").val("");
         $("#loan_amount").attr('readonly', false);
     } */

});

$('.formsubmit').on('change', '#loan_id', function (e) {
    //console.log("test");
    // var $this = $(this);
    let id = $(this).data('id');
    var principal_amount = $(this).find(':selected').attr('data-principal-amount')
    if (principal_amount) {
        $("#loan_amount").val(principal_amount);
        $("#loan_amount").attr('readonly', true);
    } else {
        $("#loan_amount").val("");
        $("#loan_amount").attr('readonly', false);
    }

});
//profile tab height adjust with footer
function calcProfileHeight() {
    setTimeout(() => {
        var leftbarHeight = $('.o-post-inner-lft').outerHeight();
        $('.profile-info-tab').css('min-height', leftbarHeight);
    }, 200);
}

function showCartTotal() {
    var totalPrice = 0;
    var tax = 0;
    var shippingCost = 0;
    var allPrice = $('.detail-price');
    setTimeout(() => {
        $.each(allPrice, function (indexInArray, valueOfElement) {
            totalPrice = totalPrice + parseFloat($(this).html());
            shippingCost = tax + parseFloat($(this).data('shippingcost'));
            tax = tax + parseFloat($(this).data('tax'));
        });
        $('.total').html('$' + totalPrice);
        $('.tax').html('$' + tax);
        $('.shippingcost').html('$' + shippingCost);
        $('.cart-items').html(allPrice.length);
    }, 200);
}

//motification listing modal height adjust
function notifyList() {
    setTimeout(() => {
        var notfheaderHeight = $('.notify-dropdown-header').outerHeight();
        var stickyfooterHeight = $('.o-mobile-footer').outerHeight();
        var bodyHeight = $(window).height();
        var totalHeight = Number(notfheaderHeight) + Number(stickyfooterHeight);
        var listHeight = bodyHeight - totalHeight;
        $('.notf-mobile').height(listHeight);
    }, 500);
}
$(window).on('resize', function () {
    notifyList();
    calcProfileHeight();
});


function showToast(type, title, message) {
    $.toast({
        heading: title,
        text: message,
        loader: true,
        icon: type,
        position: 'bottom-right',
    });
}

function makeArray(params) {
    var dataArray = {}; // note this
    $.each(params, function (key, value) {
        dataArray[key] =  value ;
    });
    return dataArray;
}



let passwordInput = document.getElementById("password-login");
let eyeIcon = document.getElementById("show-pass");
if(eyeIcon)
{
    eyeIcon.addEventListener("click", function () {
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
        } else {
            passwordInput.type = "password";
        }
    });
}


