@extends('admin.layouts.app')
@push('style')
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css"> --}}

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
            color: #000;
            font-weight: 500;
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

        .steps-progress-bar .step .bullet:before,
        .steps-progress-bar .step .bullet:after {
            position: absolute;
            content: "";
            bottom: 11px;
            right: -102px;
            height: 3px;
            width: 91px;
            background: #262626;
        }

        .steps-progress-bar .step .bullet.active:after {
            background: #f9d95c;
            transform: scaleX(0);
            transform-origin: left;
            animation: animate 0.3s linear forwards;
        }

        .plus_btn {
            display: flex;
            justify-content: flex-end;
        }

        .plus_btn button {
            border: 1px solid #f9d95c;
            background: #f9d95c;
            color: #fff;
            border-radius: 50%;
            height: 36px;
            width: 36px;
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




        .page .single-input label {
            display: block;
            margin: 10px 0px;
        }


        .page .single-input input,
        .page .single-input select {
            margin-bottom: 0px;
        }

        .page .single-input textarea {
            width: 100%;
        }

        .add-more-field {
            border: 1px solid #0000004a;
            padding: 20px;
            border-radius: 10px;
            position: relative;
            margin-bottom: 30px;
        }

        .btns-actions-postion {
            position: absolute;
            bottom: -23px;
            right: 20px;
        }

        .btns-actions-postion button {
            border: 1px solid #f9d95c;
            background: #f9d95c;
            color: #fff;
            border-radius: 50%;
            height: 36px;
            width: 36px;
        }

        .accordion {
            margin-top: 40px;

            .card {
                border: none;
                margin-bottom: 20px;

                h2 {
                    background: url(https://cdn0.iconfinder.com/data/icons/entypo/91/arrow56-512.png) no-repeat calc(100% - 10px) center;
                    background-size: 20px;
                    cursor: pointer;
                    font-size: 18px;

                    &.collapsed {
                        background-image: url(https://cdn0.iconfinder.com/data/icons/arrows-android-l-lollipop-icon-pack/24/expand2-256.png);
                    }
                }

                &-body {
                    padding-left: 0;
                    padding-right: 0;
                }
            }
        }
    </style>
@endpush
@section('pagetitlesection')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link custom-cumb">{{ __('FAQS') }}</a>
    </li>
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-8">
                        <h1 class="m-0 text-dark"> FAQ</h1>
                    </div><!-- /.col -->
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="faq_sec">
            <div class="container">
                <div class="accordion" id="accordionExample">
                    <div class="card">
                        <div class="card-head" id="headingOne">
                            <div class="accor_toggle" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                                aria-controls="collapseOne">
                                <h2 class="mb-0">
                                    What is the meaning of Lorem ipsum?
                                </h2>
                                <span><i class="fa fa-angle-down" aria-hidden="true"></i></span>
                            </div>

                        </div>

                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                            data-parent="#accordionExample">
                            <div class="card-body">
                                Literally it does not mean anything. It is a sequence of words without a sense of Latin
                                derivation that make up a text also known as filler text, fictitious, blind or placeholder
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-head" id="headingTwo">
                            <div class="accor_toggle collapsed" data-toggle="collapse" data-target="#collapseTwo"
                                aria-expanded="false" aria-controls="collapseTwo">
                                <h2 class="mb-0 ">
                                    Why is Lorem Ipsum Dolor used?
                                </h2>
                                <span><i class="fa fa-angle-down" aria-hidden="true"></i></span>

                            </div>

                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                            <div class="card-body">
                                The Lorem Ipsum text is used to fill spaces designated to host texts that have not yet been
                                published. They use programmers, graphic designers, typographers to get a real impression of
                                the
                                digital / advertising / editorial product they are working on.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-head" id="headingThree">
                            <div class="accor_toggle collapsed" data-toggle="collapse" data-target="#collapseThree"
                                aria-expanded="false" aria-controls="collapseThree">
                                <h2 class="mb-0 ">
                                    What is the most used version?
                                </h2>
                                <span><i class="fa fa-angle-down" aria-hidden="true"></i></span>

                            </div>

                        </div>
                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                            data-parent="#accordionExample">
                            <div class="card-body">
                                Lorem ipsum dolor sit amet, consectetur adipisci elit, sed eiusmod tempor incidunt ut labore
                                et
                                dolore magna aliqua. Ut enim ad minim veniam, quis nostrum exercitationem ullam corporis
                                suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur. Quis aute iure reprehenderit
                                in
                                voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint obcaecat
                                cupiditat
                                non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-head" id="headingFour">
                            <div class="accor_toggle collapsed" data-toggle="collapse" data-target="#collapseFour"
                                aria-expanded="false" aria-controls="collapseFour">
                                <h2 class="mb-0 ">
                                    What are the origins of Lorem Ipsum Dolor Sit?
                                </h2>
                                <span><i class="fa fa-angle-down" aria-hidden="true"></i></span>
                            </div>


                        </div>
                        <div id="collapseFour" class="collapse" aria-labelledby="headingFour"
                            data-parent="#accordionExample">
                            <div class="card-body">
                                Its origins date back to 45 BC. In fact, his words were randomly extracted from the De
                                finibus
                                bonorum et malorum , a classic of Latin literature written by Cicero over 2000 years ago.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-head" id="headingFive">
                            <div class="accor_toggle collapsed" data-toggle="collapse" data-target="#collapseFive"
                                aria-expanded="false" aria-controls="collapseFive">
                                <h2 class="mb-0">
                                    What is the original text of Lorem Ipsum Dolor Sit Amet?
                                </h2>
                                <span><i class="fa fa-angle-down" aria-hidden="true"></i></span>
                            </div>


                        </div>
                        <div id="collapseFive" class="collapse" aria-labelledby="headingFive"
                            data-parent="#accordionExample">
                            <div class="card-body">
                                The original Latin text
                                From De finibus bonorum et malorum sections 1.10.32 and 1.10.33 - Marco Tullio Cicerone

                                « Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque
                                laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi
                                architecto
                                beatae vitae dicta sunt, explicabo. Nemo enim ipsam voluptatem, quia voluptas sit,
                                aspernatur
                                aut odit aut fugit, sed quia consequuntur magni dolores eos, qui ratione voluptatem sequi
                                nesciunt, neque porro quisquam est, qui dolorem ipsum, quia dolor sit, amet, consectetur,
                                adipisci velit, sed quia non numquam eius modi tempora incidunt, ut labore et dolore magnam
                                aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam
                                corporis
                                suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure
                                reprehenderit, qui in ea voluptate velit esse, quam nihil molestiae consequatur, vel illum,
                                qui
                                dolorem eum fugiat, quo voluptas nulla pariatur? [33] At vero eos et accusamus et iusto odio
                                dignissimos ducimus, qui blanditiis praesentium voluptatum deleniti atque corrupti, quos
                                dolores
                                et quas molestias excepturi sint, obcaecati cupiditate non provident, similique sunt in
                                culpa,
                                qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum
                                facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio,
                                cumque nihil impedit, quo minus id, quod maxime placeat, facere possimus, omnis voluptas
                                assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis
                                aut
                                rerum necessitatibus saepe eveniet, ut et voluptates repudiandae sint et molestiae non
                                recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis
                                voluptatibus
                                maiores alias consequatur aut perferendis doloribus asperiores repellat. »


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content -->
    </div>

    <!-- add baranch form -->




    <!-- add baranch form-end-->

    <!-- /.content-wrapper -->
@endsection
@push('scripts')
    {{-- <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>  --}}
    {{-- <script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap.min.js') }}"></script> --}}
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script> --}}
    {{-- <script>
            $(document).ready(function() {
                $('#dataTable').DataTable();
            });
        </script> --}}
    <!-- <script src="{{ asset('assets/admin/ckeditor/ckeditor.js') }}"></script> -->
    <script src="//cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script src="{{ asset('assets/admin/js/datatableajax.js') }}"></script>
    <script src="{{ asset('assets/admin/js/customer.js') }}"></script>
    <script src="{{ asset('assets/admin/js/customer-kyc-verification.js') }}"></script>
    <script src="{{ asset('assets/admin/js/customer-kyc-document-verification.js') }}"></script>
    <script>
        // ClassicEditor
        //     .create(document.querySelector('.answer'))
        //     .catch(error => {
        //         console.error(error);
        //     });

        $(document).ready(function() {
            CKEDITOR.replace('answer');
        })
    </script>
@endpush
