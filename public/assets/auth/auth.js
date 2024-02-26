// JavaScript Document
'use strict';
var baseUrl = APP_URL +'/';

$(document).ready(function (e) {
    $.validator.addMethod("checkUsername", function (username) {
        var isSuccess = false;
        if(username.length > 0)
        {
            let url = APP_URL + '/check-username'
            $.ajax({
                type: "POST",
                url: url,
                async: false,
                dataType: "json",
                data: {
                    username: username
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    if (data.status == true) {
                        isSuccess = true;
                        $('#usernameValidate').show();
                    } else {
                        $('#usernameValidate').hide();
                    }
                }
            });
        }
        return isSuccess;
    });

    $.validator.addMethod("checkValidateUsername", function (username) {
        // return !username.match(/\s/g);

        var regex = /^[a-z0-9-]+$/;;
        return regex.test(username);
    }, 'Only lowercase letters, numbers and hyphen ( - ) is allowed');

    $.validator.addMethod("isEmail", function (email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    });

    $.validator.addMethod("checkEmail", function (email) {
        var isSuccess = false;
        if(email.length > 0)
        {
            let url = APP_URL + '/check-email'
            $.ajax({
                type: "POST",
                url: url,
                async: false,
                dataType: "json",
                data: {
                    email: email
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    if (data.status == true) {
                        isSuccess = true;
                        $('#emailValidate').show();
                    } else {
                        $('#emailValidate').hide();
                    }

                }
            });
        }
        return isSuccess;
    });

    $.validator.addMethod("passwordcheck", function (value) {
        var isSuccess = false;
        var pattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?!=.*[#?!@$%^&*-])[a-zA-Z0-9\W]{8,15}$/;
        if (pattern.test(value)) {
            isSuccess = true;
            $('#passwordInfo').removeClass('text-danger');
        } else {
            $('#passwordInfo').addClass('text-danger');
        }
        return isSuccess;
    }, 'Please enter a valid password');

    /* $("#registerfirststepform").validate({
        rules: {
            profile_type: {
                required: true
            },
            email: {
                required: true,
                email: true,
                isEmail: true,
                checkEmail: true
            },
            username: {
                required: true,
                minlength: 3,
                checkValidateUsername: true,
                checkUsername: true
            },
            password: {
                required: true,
                minlength: 8,
                maxlength: 15,
                passwordcheck: true
            },
            password_confirmation: {
                required: true,
                equalTo: "#password"
            },
            tandc: {
                required: true
            },
            privacypolicy: {
                required: true
            }
        },
        messages: {
            profile_type: {
                required: "Please select a profile type"
            },
            email: {
                required: "Please enter a valid email address",
                checkEmail: "Given Email Address is already exist",
                isEmail: "Please enter a valid email address",
            },
            username: {
                required: "Please enter username",
                checkUsername: "This username is already taken"
            },
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 8 characters long",
                maxlength: "Your password must not be longer than 15 characters"
            },
            password_confirmation: {
                required: "Please enter the password again",
                equalTo: "The password confirmation does not match"
            },
            tandc: {
                required: "Terms and Condition must be accepted."
            },
            privacypolicy: {
                required: "You must read the Privacy Policy."
            }
        },
        errorElement: "span",
        errorClass: 'invalid-feedback d-block',
        errorPlacement: function (error, element) {
            if (element[0].type == 'select-one') {
                error.insertAfter(element.parent());
            } else if (element[0].type == 'checkbox') {
                error.insertAfter(element.parent().parent());
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            $(".registerfirststepsubmit").prop("disabled", true);
            form.submit();
        }
    });
 */

    $("#loginform").validate({
        rules: {
            email: {
                required: true,
                email: true,
                isEmail: true
            },
            password: {
                required: true
            }
        },
        messages: {
            email: {
                required: "Please enter your registered email",
                isEmail: "Please enter a valid email address"
            },
            password: {
                required: "Please enter your password"
            }
        },
        errorElement: "span",
        errorClass: 'invalid-feedback d-block',
        errorPlacement: function (error, element) {
            error.insertAfter(element);
        },
        submitHandler: function (form) {
            $(".loginsubmit").prop("disabled", true);
            form.submit();
        }
    });

    $("#passwordresetform").validate({
        rules: {
            email: {
                required: true,
                email: true,
                isEmail: true
            }
        },
        messages: {
            email: {
                required: "Please enter your registered email",
                isEmail: "Please enter a valid email address"
            }
        },
        errorElement: "span",
        errorClass: 'invalid-feedback d-block',
        errorPlacement: function (error, element) {
            error.insertAfter(element);
        },
        submitHandler: function (form) {
            $(".passwordresetsubmit").prop("disabled", true);
            form.submit();
        }
    });

    $("#updatepasswordform").validate({
        rules: {
            password: {
                required: true,
                minlength: 8,
                maxlength: 15,
                passwordcheck: true
            },
            password_confirmation: {
                required: true,
                equalTo: "#password"
            }
        },
        messages: {
            password: {
                required: "Please provide a password",
                passwordcheck: "The password length should be 8 - 15 characters long and contains at least one small letter, one capital letter and one number.",
                minlength: "Your password must be at least 8 characters long",
                maxlength: "Your password must not be longer than 15 characters"
            },
            password_confirmation: {
                required: "Please provide the confirm password",
                passwordcheck: "The password length should be 8 - 15 characters long and contains at least one small letter, one capital letter and one number.",
                equalTo: "The password confirmation does not match"
            }
        },
        errorElement: "span",
        errorClass: 'invalid-feedback d-block',
        errorPlacement: function (error, element) {
            error.insertAfter(element);
        },
        submitHandler: function (form) {
            $(".updatepasswordsubmit").prop("disabled", true);
            form.submit();
        }
    });



    $(document).on('click', 'button.emailverficationsubmit', function(e){
        e.preventDefault();
        var formSubmit = 1;

        $('form[name="emailverficationform"]').find('input').each(function(){
            if($(this).val() == ''){
                formSubmit = 0;
                $(this).addClass('is-invalid');
            }else{
                $(this).removeClass('is-invalid');
            }
        });

        if(formSubmit){
            $('form[name="emailverficationform"]').submit();
        }
    });

    $(document).on('click', 'button.passwordresetsubmit', function(e){
        e.preventDefault();
        var formSubmit = 1;

        $('form[name="passwordresetform"]').find('input').each(function(){
            if($(this).attr('type') == 'email'){
                var pattern = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

                if(!pattern.test($(this).val())){
                    formSubmit = 0;
                    $(this).attr('title', 'Please enter a valid email id');
                    $(this).addClass('is-invalid');
                    $(document).find('span.resetmail').addClass('d-block').html('Please enter a valid email id');
                }else{
                    $(this).removeAttr('title');
                    $(this).removeClass('is-invalid');
                    $(document).find('span.resetmail').removeClass('d-block').html('');
                }
            }
        });

        if(formSubmit){
            $('form[name="passwordresetform"]').submit();
        }
    });

    $(document).on('click', 'button.updatepasswordsubmit', function(e){
        e.preventDefault();
        var formSubmit = 1;

        $('form[name="updatepasswordform"]').find('input').each(function(){
            if($(this).attr('type') == 'email'){
                var pattern = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

                if(!pattern.test($(this).val())){
                    formSubmit = 0;
                    $(this).attr('title', 'Please enter a valid email id');
                    $(this).addClass('is-invalid');
                }else{
                    $(this).removeAttr('title');
                    $(this).removeClass('is-invalid');
                }
            }else if($(this).attr('type') == 'password'){
                if($(this).val().length < 6){
                    formSubmit = 0;
                    $(this).attr('title', 'Password length must be at least 6 characters long');
                    $(this).addClass('is-invalid');
                }else{
                    $(this).removeAttr('title');
                    $(this).removeClass('is-invalid');
                }
            }
        });

        if(formSubmit){
            $('form[name="updatepasswordform"]').submit();
        }
    });

    //Resend verification email
    $(document).on("click", ".resendVerifyEmail", function(){
        var $this = $(this);
        var userUuid = $this.data('useruuid');
        console.log(baseUrl + 'resend-verification-email');
        if(userUuid){
            $this.parent('div').find('i.fa').remove();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrl + 'resend-verification-email',
                data: {'userUuid': userUuid},
                type: "POST",
                dataType : "json",
                cache: false,
                beforeSend: function(){
                    $this.parent('div').append('<i class="fa fa-fw fa-spinner fa-spin"></i>');
                },
                success: function(response){
                    if(response){
                        $.toast({
                            heading: 'Success',
                            text: ' Please check your registered email id for the verification link, Check spam folder also',
                            position: TOAST_POSITION,
                            icon: 'success',
                            stack: false
                        });
                    }else{
                        $.toast({
                            heading: 'Error',
                            text: 'Some thing went wrong.',
                            position: TOAST_POSITION,
                            icon: 'error',
                            stack: false
                        });
                    }
                },
                error: function(response){
                    $this.parent('div').find('i.fa').remove();
                    $.toast({
                        heading: 'Error',
                        text: 'Some thing went wrong. Try again!',
                        position: TOAST_POSITION,
                        icon: 'error',
                        stack: false
                    });
                },
                complete: function(response){
                    $this.parent('div').find('i.fa').remove();
                }
            });
        }
    });


});
