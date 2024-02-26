@php
    $code = Auth::user()->mfi->code;
@endphp
@extends('mfi.layouts.app')
@push('style')
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">

    <style>
        @import url("https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap");

:root {
  --primary: #333;
  --secondary: #333;
  --errorColor: red;
  --stepNumber: 6;
  --container-customWidth: 600px;
  --bgColor: #333;
  --inputBorderColor: lightgray;
}


::selection {
  color: #fff;
  background: var(--primary);
}
.container-custom {
  background: #fff;
  text-align: center;
  border-radius: 5px;
  padding: 50px 20px 10px 35px;
}
.container-custom header {
  font-size: 35px;
  font-weight: 600;
  margin: 0 0 30px 0;
}
.container-custom .form-outer {
  width: 100%;
  overflow: hidden;
}
.container-custom .form-outer form {
  display: flex;
  width: calc(100% * var(--stepNumber));
}
.form-outer form .page {
  width: calc(100% / var(--stepNumber));
  transition: margin-left 0.3s ease-in-out;
}

form .page .field button {
  width: 100%;
  height: calc(100% + 5px);
  border: none;
  background: var(--secondary);
  margin-top: -20px;
  border-radius: 5px;
  color: #fff;
  cursor: pointer;
  font-size: 18px;
  font-weight: 500;
  letter-spacing: 1px;
  text-transform: uppercase;
  transition: 0.5s ease;
}
form .page .field button {
    width: 100%;
    height: calc(100% + 5px);
    border: none;
    background: #f9d95c;
    margin-top: -20px;
    border-radius: 5px;
    color: #fff;
    cursor: pointer;
    font-size: 18px;
    font-weight: 500;
    letter-spacing: 1px;
    text-transform: uppercase;
    transition: 0.5s ease;
    color:#000;
    font-weight:500;
}
form .page .btns button {
  margin-top: -20px !important;
}
form .page .btns button.prev {
  margin-right: 3px;
  font-size: 17px;
}
form .page .btns button.next {
  margin-left: 3px;
}
.container-custom .steps-progress-bar {
  display: flex;
  margin: 40px 0;
  user-select: none;
}
.container-custom .steps-progress-bar .step {
  text-align: center;
  width: 100%;
  position: relative;
}
.container-custom .steps-progress-bar .step p {
  font-weight: 500;
  font-size: 18px;
  color: #000;
  margin-bottom: 8px;
}
.steps-progress-bar .step .bullet {
  height: 30px;
  width: 30px;
  border: 2px solid #000;
  display: inline-block;
  border-radius: 50%;
  position: relative;
  transition: 0.2s;
  font-weight: 500;
  font-size: 17px;
  line-height: 25px;
}
.steps-progress-bar .step .bullet.active {
    border-color: #f9d95c;
    background: #f9d95c;
}
.steps-progress-bar .step .bullet span {
  position: absolute;
  left: 50%;
  transform: translateX(-50%);
}
.steps-progress-bar .step .bullet.active span {
  display: none;
}
.steps-progress-bar .step .bullet:before, .steps-progress-bar .step .bullet:after {
    position: absolute;
    content: "";
    bottom: 11px;
    right: -59px;
    height: 3px;
    width: 44px;
    background: #262626;
}
.steps-progress-bar .step .bullet.active:after {
    background: #f9d95c;
    transform: scaleX(0);
    transform-origin: left;
    animation: animate 0.3s linear forwards;
}
@keyframes animate {
  100% {
    transform: scaleX(1);
  }
}
.steps-progress-bar .step:last-child .bullet:before,
.steps-progress-bar .step:last-child .bullet:after {
  display: none;
}
.steps-progress-bar .step p.active {
  color: var(--primary);
  transition: 0.2s linear;
}
.steps-progress-bar .step .check {
  position: absolute;
  left: 50%;
  top: 70%;
  font-size: 15px;
  transform: translate(-50%, -50%);
  display: none;
}
.steps-progress-bar .step .check.active {
  display: block;
  color: #fff;
}

@media screen and (max-width: 660px) {
  :root {
    --container-customWidth: 400px;
  }
  .steps-progress-bar .step p {
    display: none;
  }
  .steps-progress-bar .step .bullet::after,
  .steps-progress-bar .step .bullet::before {
    display: none;
  }
  .steps-progress-bar .step .bullet {
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .steps-progress-bar .step .check {
    position: absolute;
    left: 50%;
    top: 50%;
    font-size: 15px;
    transform: translate(-50%, -50%);
    display: none;
  }
  .step {
    display: flex;
    align-items: center;
    justify-content: center;
  }
}
@media screen and (max-width: 490px) {
  :root {
    --container-customWidth: 100%;
  }

}



.page .single-input label {
    display: block;
    margin: 10px 0px;
}


.page .single-input input , .page .slide-page .single-input select{
  margin-bottom:0px;
}
    </style>
@endpush
@section('pagetitlesection')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link custom-cumb">{{ __('User') }}</a>
    </li>
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-custom-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-8">
                        <h1 class="m-0 text-dark">Add Customer</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-4">
                        {{--  <a class="model-slide-btn" href="{{ route('mfi.customer.add', ['slug' => $code]) }}">
                            <span><i class="fa fa-plus" aria-hidden="true"></i></span>
                            ADD CUSTOMER
                        </a>  --}}
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-custom-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-custom-fluid">
                <!-- /.row -->
                <!-- Recent Assets -->
                <div class="row">
                    <div class="col-12">
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0" style="height: 700px;">
                            

                          


                            </div>
                            <!-- /.card-body -->
                            <!-- /.card -->
                        </div>
                    </div>
                </div>
                <!-- /.container-custom-fluid -->
            </div>
            <!-- /.content -->
        </div>

       
    @endsection
    @push('scripts')
        <script>
            $(document).ready(function() {
                $("#addbranch-btn").click(function() {
                    $("#slide-from-right").addClass("show-side-form");
                });

                $("#close-btn").click(function() {
                    $("#slide-from-right").removeClass("show-side-form");
                });
            });
        </script>

        <script>
            initMultiStepForm();

function initMultiStepForm() {
  const progressNumber = document.querySelectorAll(".step").length;
  const slidePage = document.querySelector(".slide-page");
  const submitBtn = document.querySelector(".submit");
  const progressText = document.querySelectorAll(".step p");
  const progressCheck = document.querySelectorAll(".step .check");
  const bullet = document.querySelectorAll(".step .bullet");
  const pages = document.querySelectorAll(".page");
  const nextButtons = document.querySelectorAll(".next");
  const prevButtons = document.querySelectorAll(".prev");
  const stepsNumber = pages.length;

  if (progressNumber !== stepsNumber) {
    console.warn(
      "Error, number of steps in progress bar do not match number of pages"
    );
  }

  document.documentElement.style.setProperty("--stepNumber", stepsNumber);

  let current = 1;

  for (let i = 0; i < nextButtons.length; i++) {
    nextButtons[i].addEventListener("click", function (event) {
      event.preventDefault();

      inputsValid = validateInputs(this);
      // inputsValid = true;

      if (inputsValid) {
        slidePage.style.marginLeft = `-${(100 / stepsNumber) * current}%`;
        bullet[current - 1].classList.add("active");
        progressCheck[current - 1].classList.add("active");
        progressText[current - 1].classList.add("active");
        current += 1;
      }
    });
  }

  for (let i = 0; i < prevButtons.length; i++) {
    prevButtons[i].addEventListener("click", function (event) {
      event.preventDefault();
      slidePage.style.marginLeft = `-${(100 / stepsNumber) * (current - 2)}%`;
      bullet[current - 2].classList.remove("active");
      progressCheck[current - 2].classList.remove("active");
      progressText[current - 2].classList.remove("active");
      current -= 1;
    });
  }
  submitBtn.addEventListener("click", function () {
    bullet[current - 1].classList.add("active");
    progressCheck[current - 1].classList.add("active");
    progressText[current - 1].classList.add("active");
    current += 1;
    setTimeout(function () {
      alert("Your Form Successfully Signed up");
      location.reload();
    }, 800);
  });

  function validateInputs(ths) {
    let inputsValid = true;

    const inputs = ths.parentElement.parentElement.querySelectorAll("input");
    for (let i = 0; i < inputs.length; i++) {
      const valid = inputs[i].checkValidity();
      if (!valid) {
        inputsValid = false;
        inputs[i].classList.add("invalid-input");
      } else {
        inputs[i].classList.remove("invalid-input");
      }
    }
    return inputsValid;
  }
}

        </script>
        
        <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/admin/js/datatableajax.js') }}"></script>
    @endpush
