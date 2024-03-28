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

    

    $('form.penaltyFormsubmit').on('submit', function (e) {
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
        let commonOption = { 'type': 'post', 'url': formActionUrl, 'data': fd, 'dataType': "json" };
        if ($($this).hasClass('fileupload')) {
            commonOption['cache'] = false;
            commonOption['processData'] = false;
            commonOption['contentType'] = false;
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
                    Swal.fire({
                        icon: 'success',
                        title: response.message,
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
                console.log(response);
                let responseJSON = response.responseJSON;
                $(".err_message").removeClass("d-block").hide();
                $("form .form-control").removeClass("is-invalid");
                $.each(responseJSON.errors, function (index, valueMessage) {
                    let indexArray = index.split('.');
                    // let tempStr = valueMessage[0];
                    // let validateMessage = tempStr.replace(index, indexArray[0]);
                    // console.log(validateMessage);
                    // $.each(index)
                    $("#" + indexArray[0] + "_" + indexArray[1]).addClass('is-invalid');
                    $("#" + indexArray[0] + "_" + indexArray[1]).after("<p class='d-block text-danger err_message'>" + valueMessage + "</p>");
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
    $('form.penaltyCaseTwoFormsubmit').on('submit', function (e) {
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
        let commonOption = { 'type': 'post', 'url': formActionUrl, 'data': fd, 'dataType': "json" };
        if ($($this).hasClass('fileupload')) {
            commonOption['cache'] = false;
            commonOption['processData'] = false;
            commonOption['contentType'] = false;
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
                    Swal.fire({
                        icon: 'success',
                        title: response.message,
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
                console.log(response);
                let responseJSON = response.responseJSON;
                $(".err_message").removeClass("d-block").hide();
                $("form .form-control").removeClass("is-invalid");
                $.each(responseJSON.errors, function (index, valueMessage) {
                    console.log(valueMessage);
                    console.log(index);
                    let indexArray = index.split('.');
                    console.log(indexArray);
                    // let tempStr = valueMessage[0];
                    // let validateMessage = tempStr.replace(index, indexArray[0]);
                    // console.log(validateMessage);
                    // $.each(index)
                    $("#" + indexArray[0] + "_" + indexArray[1]).addClass('is-invalid');
                    $("#" + indexArray[0] + "_" + indexArray[1]).after("<p class='d-block text-danger err_message'>" + valueMessage + "</p>");
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

                    $.each(data.data, function (index, valueMessage) {
                        console.log(index);
                        $("#" + index).val(valueMessage);
                    });
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
                    $("#logo").css('display', 'block');
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
        alert('test');
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

});
