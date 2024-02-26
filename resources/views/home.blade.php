<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Swasthfit</title>
  <meta content="" name="description">
  <meta content="" name="keywords">



  <!-- Vendor CSS Files -->
  <link href="" rel="stylesheet">

  <link href="{{ asset('assets/csss/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">

  <!-- Template Main CSS File -->
  <link href="{{ asset('assets/csss/style.css') }}" rel="stylesheet" type="text/css" />

  <link href="{{ asset('assets/csss/responsive.css')}}" rel="stylesheet">
  <style>
    .refernce_box {
      padding: 10px;
      border: 1px solid #d0c1ff;
      margin: 18px auto;
      width: 50%;
      border-radius: 6px;
      background: #ebe7ff;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }

    .refernce_box h6 {
      margin: 0;
    }

    .refernce_box h6 span {
      background: #8870d5;
      padding: 6px;
      border-radius: 5px;
      color: #fff;
    }

    span.copy_icon {
      cursor: pointer;
      color: #333;
      font-size: 18px;
    }

    @media only screen and (min-width:768px) and (max-width:1199px) {
      .refernce_box {
        width: 60%;
      }

      .refernce_box h6 {
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
      }
    }

    @media only screen and (max-width:767px) {
      .refernce_box {
        width: 90%;
      }

      .refernce_box h6 {
        margin: 0;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
      }

      .refernce_box h6 span {
        line-height: 20px;
      }
    }
  </style>
</head>

<body>

  <!------------------------------------------>
  <div class="mainloginsection downloadpage">
    <div class="downloadp_box">
      <div class="row no-gutters">

        <div class="col-12">
          <div class="logo_company">

            <img src="{{asset('assets/img/admin-logo.png')}}" alt="" class="brand-image">
          </div>
        </div>
        <div class="col-12">
          <h5 class="click_text">Click Here to Download The Application</h5>


        </div>
        <!--<div class="loginsection-right-logo"><a href="http://166.62.54.122/hcs/Hcs.apk"><img src="assets/img/demo-logo.png" title="HLL-Lifecare"></a> </div>-->
        <div class="col-12 download_app">
          <p>Download For Android Device</p>
          <a href="https://play.google.com/store/apps/details?id=com.swasthfit&pcampaignid=web_share" download>
            <img src="{{ asset('assets/images/googleplay.png')}}" class="img-fluid" alt="">
          </a>
          <br>
          <div class="refernce_box">
            <h6>Reference code - <span id="referenceCode"><strong><?php echo $refercode; ?></strong></span></h6>
            <span class="copy_icon" onclick="copyReferenceCode()"><i class="far fa-copy"></i></span>
          </div>
        </div>
        <!--<div class="col-12 download_app">-->
        <!--  <p>Download For iOS Device</p>-->
        <!--  <a href="#" class="">-->
        <!--    <img src="assets/images/appstore.png" class="img-fluid" alt="">-->
        <!--  </a>-->
        <!--</div>-->

      </div>
    </div>

  </div>

  <!--mainloginsection-->


  <!-- Vendor JS Files -->

  <script src="{{ asset('assets/js/bootstrap.bundle.min.js')}}"></script>

  <script>
    function copyReferenceCode() {
      // Get the reference code text
      var referenceCode = document.getElementById("referenceCode").innerText;

      // Create a textarea element to hold the text temporarily
      var textarea = document.createElement("textarea");
      textarea.value = referenceCode;

      // Make the textarea hidden
      textarea.style.position = "fixed";
      textarea.style.opacity = 0;

      // Append the textarea to the DOM
      document.body.appendChild(textarea);

      // Select the text within the textarea
      textarea.select();

      // Copy the selected text
      document.execCommand("copy");

      // Remove the textarea
      document.body.removeChild(textarea);

      // Optionally, provide feedback to the user (e.g., alert or tooltip)
      // For example:
      alert("Reference code copied: " + referenceCode);
    }
  </script>

</body>

</html>