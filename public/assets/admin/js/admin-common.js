let jc;
$(document).on('submit','#adminFrm',function(event) {
	event.preventDefault();
	if(commonFormChecking(true)){
		let formdata = new FormData(this);
		$.ajax({
		    type: "POST",
		    url: baseUrl+$(this).data('action'),// where you wanna post
		    data: formdata,
		    processData: false,
		    contentType: false,
		    dataType : "JSON",
		    beforeSend: function() {
	        	 		jc = $.dialog({
						    icon: 'fa fa-spinner fa-spin',
						    title: 'Working!',
						    content: 'Sit back, we are processing your request!',
						  	type: 'dark',
						  	closeIcon: false

						});
	   		 },
		    success: function(data) {
		    		jc.close();
		    		// console.log(data);
		    	if(data.status){

		    			 $.alert({
						    icon: 'fa fa-check',
						    title: 'Success!',
						    content: data.message,
						  	type: 'green',
	    					typeAnimated: true,
						});
						if(data.redirect != ''){
						setTimeout(function(){ window.location.href=baseUrl+data.redirect }, 3000);

						}
		    	}else{

		    			$.alert({
						    icon: 'fa fa-warning',
						    title: 'Warning!',
						    content: data.message,
						  	type: 'orange',
	    					typeAnimated: true,
						});
		    	}


		    }
		});
	}
});
$(document).ready(function() {
  if($('body').hasClass("select2")){
    $(".select2").select2();
  }
});
function jqueryConfirmAlert(text, type, timer = 2000) {
	if(type === "warning"){
		$.alert({
		    icon: 'fa fa-warning',
		    title: 'Warning!',
		    content: text,
		  	type: 'orange',
			typeAnimated: true,
		});
	}else if(type === "success"){
		 $.alert({
            icon: 'fa fa-check',
            title: 'Success!',
            content: text,
            type: 'green',
            typeAnimated: true,
        });
	}
}

$(document).on('click','.change-status',function() {
  var id    = $(this).data('id');
  var keyId   = $(this).data('key');
  var table   = $(this).data('table');
  var status  = $(this).data('status');
  var dataJSON = {
                    id:id,
                    keyId:keyId,
                    table:table,
                    status:status,
                    _token : _token
                  };
  $.confirm({
  icon: 'fa fa-spinner fa-spin',
    title: 'Confirm!',
    content: 'Do you really want to do this ?',
    type: 'orange',
    typeAnimated: true,
    buttons: {
        confirm: function () {

          if(id && table){
            $.ajax({
                type: "POST",
                url: baseUrl+"generic-status-change-delete",
                data: dataJSON,
                dataType:"JSON",
                success:function(data) {
                if(data.status){
                    if (data.postStatus == '3') {

                    $.alert({
                        icon: 'fa fa-check',
                        title: 'Success!',
                        content: 'Data has been deleted !',
                        type: 'green',
                        typeAnimated: true,
                    });
                    setTimeout(function(){ location.reload() }, 1550);

                    }else if(data.postStatus == '1'){
                    $('#'+id).removeClass('badge-danger');
                    $('#'+id).addClass('badge-primary');
                    $('#'+id).html('Active');
                    $('#'+id).data('status','0');
                    $.alert({
                        icon: 'fa fa-check',
                        title: 'Success!',
                        content: data.message,
                        type: 'green',
                        typeAnimated: true,
                    });
                    }else if(data.postStatus == '0'){

                    $('#'+id).removeClass('badge-primary');
                    $('#'+id).addClass('badge-danger');
                    $('#'+id).html('Inactive');
                    $('#'+id).data('status','1');

                    $.alert({
                        icon: 'fa fa-check',
                        title: 'Success!',
                        content: data.message,
                        type: 'green',
                        typeAnimated: true,
                    });

                    }
                }




                }
            });

          }

        },
        cancel: function () {
            $.alert({
              icon: 'fa fa-times',
              title: 'Canceled!',
              content: 'Process canceled',
              type: 'purple',
              typeAnimated: true,
            });
        }
    }
});

})

/*change approval*/
$(document).on('click','.change-approval',function() {
  var id    = $(this).data('id');
  var keyId   = $(this).data('key');
  var table   = $(this).data('table');
  var approval= $(this).data('approval');
  var dataJSON = {
                    id:id,
                    keyId:keyId,
                    table:table,
                    approval:approval,
                    _token : _token
                  };
  $.confirm({
  icon: 'fa fa-spinner fa-spin',
    title: 'Confirm!',
    content: 'Do you really want to do this ?',
    type: 'orange',
    typeAnimated: true,
    buttons: {
        confirm: function () {

          if(id && table){
            $.ajax({
            type: "POST",
            url: baseUrl+"generic-approval-change",
            data: dataJSON,
            dataType:"JSON",
            success:function(data) {
              if(data.status){
                if(data.postApproval == '1'){
                $('#'+id).removeClass('badge-danger');
                $('#'+id).addClass('badge-primary');
                $('#'+id).html('Approved');
                $('#'+id).data('approval','0');
                $.alert({
                    icon: 'fa fa-check',
                    title: 'Success!',
                    content: data.message,
                    type: 'green',
                    typeAnimated: true,
                });
                }else{
                  $('#'+id).removeClass('badge-primary');
                  $('#'+id).addClass('badge-danger');
                  $('#'+id).html('Unapproved');
                  $('#'+id).data('approval','1');

                $.alert({
                    icon: 'fa fa-check',
                    title: 'Success!',
                    content: data.message,
                    type: 'green',
                    typeAnimated: true,
                });

                }
              }




            }
        });

          }

        },
        cancel: function () {
            $.alert({
              icon: 'fa fa-times',
              title: 'Canceled!',
              content: 'Process canceled',
              type: 'purple',
              typeAnimated: true,
            });
        }
    }
});

})

/*change approval*/

function commonFormChecking(flag, cls = "", msgbox = "") {
  if (cls == "") {
    cls = "requiredCheck";
  }
  $("." + cls).each(function () {
    if ($(this).hasClass("ckeditor")) {
      if (CKEDITOR.instances[$(this).attr("id")].getData() == "") {
        if (msgbox != "") {
          $("." + msgbox).text(
            $(this).attr("data-check") + " is mandatory !!!"
          );
        } else {
          jqueryConfirmAlert(
            $(this).attr("data-check") + " is mandatory !!!",
            "warning"
          );
        }
        flag = false;
        return false;
      }else{
        if (CKEDITOR.instances[$(this).attr("id")].getData().replace(/&nbsp;|\s/g, '') === '<p></p>'){
          if(msgbox != "") {
            $("." + msgbox).text(
              $(this).attr("data-check") + " contains only blankspace !!!"
            );
          } else {
            jqueryConfirmAlert(
              $(this).attr("data-check") + " contains only blankspace !!!",
              "warning"
            );
          }
          flag = false;
          return false;
        }
      }
    } else {
      if ($.trim($(this).val()) == "") {
        if (msgbox != "") {
          $("." + msgbox).text(
            $(this).attr("data-check") + " is mandatory !!!"
          );
        } else {
          jqueryConfirmAlert(
            $(this).attr("data-check") + " is mandatory !!!",
            "warning"
          );
        }
        flag = false;
        return false;
      } else {
        if ($(this).attr("data-check") == "Email") {
          var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
          if (reg.test($.trim($(this).val())) == false) {
            if (msgbox != "") {
              $("." + msgbox).text("Enter valid Email address!!!");
            } else {
              jqueryConfirmAlert("Enter valid Email address !!!", "warning");
            }
            flag = false;
            return false;
          }
        }
        if ($(this).attr("data-check") == "Phone") {
          if ($.trim($(this).val()).length != 10) {
            var txt = "Enter 10 digit phone number !!!";
            if (msgbox != "") {
              $("." + msgbox).text("Enter 10 digit phone number !!!");
            } else {
              jqueryConfirmAlert("Enter 10 digit phone number !!!", "warning");
            }
            flag = false;
            return false;
          }
        }
        if ($(this).attr("data-check") == "Zip") {
          if ($.trim($(this).val()).length != 6) {
            if (msgbox != "") {
              $("." + msgbox).text("Enter 6 digit Postcode !!!");
            } else {
              jqueryConfirmAlert("Enter 6 digit Postcode !!!", "warning");
            }
            flag = false;
            return false;
          }
        }
      }
    }
  });
  return flag;
}
function isNumber(evt) {
  evt = evt ? evt : window.event;
  var charCode = evt.which ? evt.which : evt.keyCode;
  if (charCode > 31 && (charCode < 48 || charCode > 57)) {
    if (charCode == 43 || charCode == 45 || charCode == 4) {
      return true;
    }
    return false;
  }
  return true;
}
function isNumberNotZero(evt, val) {
  evt = evt ? evt : window.event;
  var charCode = evt.which ? evt.which : evt.keyCode;
  if(val == ''){
    if (charCode == 48) {
      return false;
    }
  }
  if (charCode > 31 && (charCode < 48 || charCode > 57)) {
    if (charCode == 43 || charCode == 45 || charCode == 4) {
      return true;
    }
    return false;
  }
  return true;
}
function isChar(evt) {
  evt = evt ? evt : window.event;
  var charCode = evt.which ? evt.which : evt.keyCode;
  if ((charCode >= 65 && charCode <= 122) || charCode == 32 || charCode == 0) {
    return true;
  }
  return false;
}
$(document).on("keyup", ".restrictSpecial", function () {
  var yourInput = $(this).val();
  var re = /[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi;
  var isSplChar = re.test(yourInput);
  if (isSplChar) {
    var no_spl_char = yourInput.replace(
      /[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi,
      ""
    );
    $(this).val(no_spl_char);
  }
});
$(".allowNumberDot").keyup(function () {
  var $this = $(this);
  $this.val($this.val().replace(/[^\d.]/g, ""));
});
/* allow only letter & space */
$(".allowOnlyLetter").keypress(function (event) {
  var inputValue = event.charCode;
  if (
    !(inputValue >= 65 && inputValue <= 122) &&
    inputValue != 32 &&
    inputValue != 0
  ) {
    event.preventDefault();
  }
});
$(".checkDecimal").keypress(function (event) {
  var $this = $(this);
  if (
    (event.which != 46 || $this.val().indexOf(".") != -1) &&
    (event.which < 48 || event.which > 57) &&
    event.which != 0 &&
    event.which != 8
  ) {
    event.preventDefault();
  }
  var text = $(this).val();
  if (event.which == 46 && text.indexOf(".") == -1) {
    setTimeout(function () {
      if ($this.val().substring($this.val().indexOf(".")).length > 3) {
        $this.val($this.val().substring(0, $this.val().indexOf(".") + 3));
      }
    }, 1);
  }
  if (
    text.indexOf(".") != -1 &&
    text.substring(text.indexOf(".")).length > 2 &&
    event.which != 0 &&
    event.which != 8 &&
    $(this)[0].selectionStart >= text.length - 2
  ) {
    event.preventDefault();
  }
});
function ucFirst(str){
  return (str + '').replace(/^([a-z])|\s+([a-z])/g, function(letter) {
      return letter.toUpperCase();
  });
}
function ucWords(str){
  return (str + '').replace(/^[\u00C0-\u1FFF\u2C00-\uD7FF\w]|\s[\u00C0-\u1FFF\u2C00-\uD7FF\w]/g, function(letter) {
      return letter.toUpperCase();
  });
}

