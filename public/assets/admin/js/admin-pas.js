let passwordField = '<div class="form-group">\
                         <input type="password" name="new_pass" id="new_pass" class="form-control " data-check="New password" placeholder="New password" >\
                      </div>\
                      <div class="form-group">\
                         <input type="password" name="cnf_password" id="cnf_password" class="form-control " data-check="Confirm Password" placeholder="Confirm password" >\
                      </div>';
$(document).on('click','#resend-otp',function() {
       let jc;
       $.ajax({
             type: "POST",
             url: baseUrl+"forgot-password",// where you wanna post
             data: {_token:Token,flag:'1'},
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
                }
             }
       });
    });
    function clickEvent(first,last){
       if(first.value.length){
          document.getElementById(last).focus();
       }
    }
    function backspaceEvent(first,last) {

      var key = event.keyCode || event.charCode;
      if( key == 8 || key == 46 ){
        if(last.value.length ==0){
          document.getElementById(first).focus();
        }
      }
    }
    let timerOn = true;
    function timer(remaining) {
      var m = Math.floor(remaining / 60);
      var s = remaining % 60;
      
      m = m < 10 ? '0' + m : m;
      s = s < 10 ? '0' + s : s;
      document.getElementById('timer').innerHTML = m + ':' + s;
      remaining -= 1;
      
      if(remaining >= 0 && timerOn) {
        setTimeout(function() {
            timer(remaining);
        }, 1000);
        return;
      }else{
        timerOn = false;
      }
      if(!timerOn) {
          $.ajax({
             type: "POST",
             url: baseUrl+"expire-otp",// where you wanna post
             data: {_token:Token},
             success: function(data) {

             }
          })

      }
    }
    timer(60);
$(document).on('submit','#adminFrm1',function(e) {
       e.preventDefault();
       $.ajax({
             type: "POST",
             url: baseUrl+"validate-otp",// where you wanna post
             data: new FormData(this),
             processData: false,
             contentType: false,
             dataType : "JSON",
             success: function(data) {
                if(data.status){
                  $.alert({
                       icon: 'fa fa-check',
                       title: 'Success!',
                       content: data.message,
                        type: 'green',
                        typeAnimated: true,
                   });
                  $('#otp-section').html('')
                  $('#password-section').html(passwordField);
                  $('#otp-section-buttons').html('');
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
          })
});