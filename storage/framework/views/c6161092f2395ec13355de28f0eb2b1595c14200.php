<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootstrap -->
    <link rel="stylesheet" href="<?php echo e(asset('frontend/css/bootstrap.min.css')); ?>">
    <!-- font awesome css -->
    <!-- <link rel="stylesheet" href="fonts/font-awesome-v6.css" /> -->
    <link rel="stylesheet" href="<?php echo e(asset('frontend/css/animate.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('frontend/css/stellarnav.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('frontend/css/owl.carousel.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('frontend/css/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('frontend/css/responsive.css')); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css">
    <title>SwaasthFiit</title>
    <link rel="shortcut icon" href="<?php echo e(asset('frontend/images/favicon.ico')); ?>">

    <link
        href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body>

    <header>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-9 col-md-12 col-12">
                    <div class="header-left">
                        <a href="<?php echo e(route('frontend.home')); ?>">
                            <div class="logo">
                                <img src="<?php echo e(asset('frontend/images/logo.png')); ?>" class="img-fluid" alt=""
                                    title="SwaasthFiit">
                            </div>
                        </a>
                        <div class="location">
                            <i class="fa-solid fa-location-dot"></i>
                            <h5> Deliver to John <span>Bangalore 560034</span></h5>
                        </div>
                        <div class="serch-bar">
                            <div class="select-here">
                                <select class="form-select">
                                    <option selected>All</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                            <input type="text">
                            <button><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>


                    </div>
                </div>
                <div class="col-lg-3 col-md-12 col-12">
                    <div class="header-right">
                        <div class="select1">
                            <div class="dropdown">
                                <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Hello,John
                                    <br>Accounts & List
                                </a>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <li><a class="dropdown-item" href="#">Action</a></li>
                                    <li><a class="dropdown-item" href="#">Another action</a></li>
                                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="select1">
                            <div class="dropdown">
                                <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Returns <br>
                                    7 Orders
                                </a>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <li><a class="dropdown-item" href="#">Action</a></li>
                                    <li><a class="dropdown-item" href="#">Another action</a></li>
                                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
    </header>

    <div class="header-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-9 col-6">
                    <div class="stellarnav" id="main-nav">
                        <ul>
                            <li class="menu-img"><img src="<?php echo e(asset('frontend/images/menu.png')); ?>" class="img-fluid"
                                    alt=""></li>
                            <li class="nav-hover active">
                                <a href="<?php echo e(route('frontend.home')); ?>">Home</a>
                            </li>
                            <li class="nav-hover active">
                                <a href="">Shop</a>
                            </li>
                            <li class="nav-hover active">
                                <a href="">Rewards</a>
                            </li>
                            <li class="nav-hover active">
                                <a href="">Blog</a>
                            </li>
                            <li class="nav-hover active">
                                <a href="">Wattel</a>
                            </li>
                            <li class="nav-hover active">
                                <a href="">Account</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="bottom-header-right">
                        <div class="country">
                            <div class="dropdown">
                                <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="<?php echo e(asset('frontend/images/india.svg')); ?>" class="img-fluid"
                                        alt="">
                                </a>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <li><a class="dropdown-item" href="#"><img
                                                src="<?php echo e(asset('frontend/images/india.svg')); ?>" class="img-fluid"
                                                alt="">
                                        </a></li>
                                    <li><a class="dropdown-item" href="#"><img
                                                src="<?php echo e(asset('frontend/images/india.svg')); ?>" class="img-fluid"
                                                alt=""></a></li>
                                    <li><a class="dropdown-item" href="#"><img
                                                src="<?php echo e(asset('frontend/images/india.svg')); ?>" class="img-fluid"
                                                alt=""></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="cart">
                            <a href="#"><img src="<?php echo e(asset('frontend/images/cart.svg')); ?>" class="img-fluid"
                                    alt=""> Cart
                                <span>2</span></a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- banner-section -->
    <div class="hero-banner">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-12 col-12">
                    <div class="abnner-left">
                        <h6>Empower Your Fitness <span>Journey Through <b>SwaasthFiit.</b></span></h6>
                        <h5>UP TO 70% OFF <span>Through <b> Rewards</b></span></h5>
                        <p>We're here to help you stay motivated and achieve your health and
                            fitness goals with utmost guidance from team of our experts!</p>

                        <div class="service-img">
                            <img src="<?php echo e(asset('frontend/images/ser-1.png')); ?>" class="img-fluid" alt="">
                            <img src="<?php echo e(asset('frontend/images/ser-2.png')); ?>" class="img-fluid" alt="">
                            <img src="<?php echo e(asset('frontend/images/ser-3.png')); ?>" class="img-fluid" alt="">

                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="bnr-right">
                        <img src="<?php echo e(asset('frontend/images/banner-right.png')); ?>" class="img-fluid" alt="">
                    </div>
                </div>
            </div>

        </div>
    </div>


    <div class="banner-boxes">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="banner-box">
                        <div class="top-box">
                            <img src="<?php echo e(asset('frontend/images/prfl.png')); ?>" class="img-fluid" alt="">
                            <h6>Hi, John <span> Customer since 2017</span></h6>
                        </div>

                        <h5 class="top-links">Top links for you</h5>

                        <div class="inner-box">
                            <a href="" class="all-itms">
                                <div class="box-items">
                                    <img src="<?php echo e(asset('frontend/images/b-1.png')); ?>" class="img-fluid"
                                        alt="">
                                    <p>Your Orders</p>
                                </div>
                            </a>
                            <a href="" class="all-itms">
                                <div class="box-items">
                                    <img src="<?php echo e(asset('frontend/images/b-2.png')); ?>" class="img-fluid"
                                        alt="">
                                    <p>Mobile & Accessories</p>
                                </div>
                            </a>
                            <a href="" class="all-itms">
                                <div class="box-items">
                                    <img src="<?php echo e(asset('frontend/images/b-3.png')); ?>" class="img-fluid"
                                        alt="">
                                    <p>Watches For Men</p>
                                </div>
                            </a>
                            <a href="" class="all-itms">
                                <div class="box-items">
                                    <img src="<?php echo e(asset('frontend/images/b-4.png')); ?>" class="img-fluid"
                                        alt="">
                                    <p>Watches For Men</p>
                                </div>
                            </a>

                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-12">
                    <div class="banner-box scnd">
                        <h6>Up to 70% off | Electronics Clearance Store</h6>
                        <img src="<?php echo e(asset('frontend/images/bn-2.png')); ?>" class="img-fluid" alt="">
                        <a href="">see more</a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12 col-12">
                    <div class="banner-box last">
                        <div class="top-box third">
                            <h6>Shop on the SwaasthFiit App</h6>
                            <p>Fast, convenient and secure | Over 17 crore products in your pocket.</p>
                            <a href="">Download the SwaasthFiit App</a>
                        </div>
                        <img src="<?php echo e(asset('frontend/images/bnr-3.png')); ?>" class="img-fluid" alt="">


                    </div>
                </div>
            </div>




            <!-- gym-section   -->

            <div class="gym-banner">
                <div class="row">
                    <div class="col-lg-7 col-md-7 col-12">
                        <div class="gym-left">
                            <img src="<?php echo e(asset('frontend/images/gym-1.png')); ?>" class="img-fluid" alt="">
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-5 col-12">
                        <div class="gym-right">
                            <p>Revamp your Body In Style</p>
                            <div class="gym-right-image">
                                <div class="images-items-all">
                                    <div class="images-items">
                                        <img src="<?php echo e(asset('frontend/images/gymm-2.png')); ?>" class="img-fluid"
                                            alt="">
                                    </div>
                                    <p>Saral Home Kids Yoga Mat </p>
                                </div>
                                <div class="images-items-all">
                                    <div class="images-items">
                                        <img src="<?php echo e(asset('frontend/images/gymm-2.png')); ?>" class="img-fluid"
                                            alt="">
                                    </div>
                                    <p>Fitness Girl (Japanese) </p>
                                </div>
                                <div class="images-items-all">
                                    <div class="images-items">
                                        <img src="<?php echo e(asset('frontend/images/gymm.png')); ?>" class="img-fluid"
                                            alt="">
                                    </div>
                                    <p>Boldfit Track Pants </p>
                                </div>
                                <div class="images-items-all">
                                    <div class="images-items">
                                        <img src="<?php echo e(asset('frontend/images/gymm-2.png')); ?>" class="img-fluid"
                                            alt="">
                                    </div>
                                    <p>Dumble Gym Elements</p>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>



            <!-- todays-deal -->
            <div class="todays-deal">
                <div class="common-headinng">
                    <h6>Today’s Deals</h6>
                    <a href="#">See more</a>
                </div>

                <div class="owl-carousel deal-carousel owl-theme">
                    <div class="item">
                        <div class="deal-box">
                            <div class="deal-image">
                                <img src="<?php echo e(asset('frontend/images/d-1.png')); ?>" class="img-fluid" alt="">
                            </div>
                            <div class="limited-deal">
                                <p>Up to 73% off</p>
                                <a href="#">Limited Time Deal</a>
                            </div>
                            <h5>Lifelong PVC Hex Dumbbells Pack..</h5>
                        </div>
                    </div>
                    <div class="item">
                        <div class="deal-box">
                            <div class="deal-image">
                                <img src="<?php echo e(asset('frontend/images/d-2.png')); ?>" class="img-fluid" alt="">
                            </div>
                            <div class="limited-deal">
                                <p>Up to 73% off</p>
                                <a href="#">Limited Time Deal</a>
                            </div>
                            <h5>SwaasthFiit Brand - Symactive..</h5>
                        </div>
                    </div>
                    <div class="item">
                        <div class="deal-box">
                            <div class="deal-image">
                                <img src="<?php echo e(asset('frontend/images/d-3.png')); ?>" class="img-fluid" alt="">
                            </div>
                            <div class="limited-deal">
                                <p>Up to 73% off</p>
                                <a href="#">Limited Time Deal</a>
                            </div>
                            <h5>Lifelong PVC Hex Dumbbells Pack..</h5>
                        </div>
                    </div>
                    <div class="item">
                        <div class="deal-box">
                            <div class="deal-image">
                                <img src="<?php echo e(asset('frontend/images/d-4.png')); ?>" class="img-fluid" alt="">
                            </div>
                            <div class="limited-deal">
                                <p>Up to 73% off</p>
                                <a href="#">Limited Time Deal</a>
                            </div>
                            <h5>ADWIN Polyester Sling Bag For..</h5>
                        </div>
                    </div>
                    <div class="item">
                        <div class="deal-box">
                            <div class="deal-image">
                                <img src="<?php echo e(asset('frontend/images/d-5.png')); ?>" class="img-fluid" alt="">
                            </div>
                            <div class="limited-deal">
                                <p>Up to 73% off</p>
                                <a href="#">Limited Time Deal</a>
                            </div>
                            <h5>ANNI DESIGNER Women's Cotton..</h5>
                        </div>
                    </div>
                    <div class="item">
                        <div class="deal-box">
                            <div class="deal-image">
                                <img src="<?php echo e(asset('frontend/images/d-1.png')); ?>" class="img-fluid" alt="">
                            </div>
                            <div class="limited-deal">
                                <p>Up to 73% off</p>
                                <a href="#">Limited Time Deal</a>
                            </div>
                            <h5>Lifelong PVC Hex Dumbbells Pack..</h5>
                        </div>
                    </div>
                    <div class="item">
                        <div class="deal-box">
                            <div class="deal-image">
                                <img src="<?php echo e(asset('frontend/images/d-2.png')); ?>" class="img-fluid" alt="">
                            </div>
                            <div class="limited-deal">
                                <p>Up to 73% off</p>
                                <a href="#">Limited Time Deal</a>
                            </div>
                            <h5>SwaasthFiit Brand - Symactive..</h5>
                        </div>
                    </div>
                </div>





            </div>


            <!--related to your items -->
            <div class="todays-deal related-items">
                <div class="common-headinng">
                    <h6>Related To Items You’ve Viewed</h6>
                    <a href="#">See more</a>
                </div>

                <div class="owl-carousel deal-carousel owl-theme">
                    <div class="item">
                        <div class="deal-image retated-itms">
                            <img src="<?php echo e(asset('frontend/images/r-1.png')); ?>" class="img-fluid" alt="">
                        </div>

                    </div>
                    <div class="item">

                        <div class="deal-image retated-itms">
                            <img src="<?php echo e(asset('frontend/images/r-2.png')); ?>" class="img-fluid" alt="">
                        </div>


                    </div>
                    <div class="item">
                        <div class="deal-image  retated-itms">
                            <img src="<?php echo e(asset('frontend/images/r-3.png')); ?>" class="img-fluid" alt="">
                        </div>

                    </div>
                    <div class="item">
                        <div class="deal-image  retated-itms">
                            <img src="<?php echo e(asset('frontend/images/r-4.png')); ?>" class="img-fluid" alt="">
                        </div>

                    </div>
                    <div class="item">
                        <div class="deal-image  retated-itms">
                            <img src="<?php echo e(asset('frontend/images/d-1.png')); ?>" class="img-fluid" alt="">
                        </div>

                    </div>
                    <div class="item">
                        <div class="deal-image  retated-itms">
                            <img src="<?php echo e(asset('frontend/images/r-1.png')); ?>" class="img-fluid" alt="">
                        </div>

                    </div>
                    <div class="item">
                        <div class="deal-image  retated-itms">
                            <img src="<?php echo e(asset('frontend/images/r-2.png')); ?>" class="img-fluid" alt="">
                        </div>

                    </div>
                </div>





            </div>

            <!--most-item to your items -->
            <div class="todays-deal related-items">
                <div class="common-headinng">
                    <h6>Most Items To Consider</h6>
                    <a href="#">See more</a>
                </div>

                <div class="owl-carousel deal-carousel owl-theme">
                    <div class="item">
                        <div class="deal-image retated-itms">
                            <img src="<?php echo e(asset('frontend/images/m-1.png')); ?>" class="img-fluid" alt="">
                        </div>

                    </div>
                    <div class="item">

                        <div class="deal-image retated-itms">
                            <img src="<?php echo e(asset('frontend/images/m-2.png')); ?>" class="img-fluid" alt="">
                        </div>


                    </div>
                    <div class="item">
                        <div class="deal-image  retated-itms">
                            <img src="<?php echo e(asset('frontend/images/m-3.png')); ?>" class="img-fluid" alt="">
                        </div>

                    </div>
                    <div class="item">
                        <div class="deal-image  retated-itms">
                            <img src="<?php echo e(asset('frontend/images/m-4.png')); ?>" class="img-fluid" alt="">
                        </div>

                    </div>
                    <div class="item">
                        <div class="deal-image  retated-itms">
                            <img src="<?php echo e(asset('frontend/images/m-1.png')); ?>" class="img-fluid" alt="">
                        </div>

                    </div>
                    <div class="item">
                        <div class="deal-image  retated-itms">
                            <img src="<?php echo e(asset('frontend/images/m-2.png')); ?>" class="img-fluid" alt="">
                        </div>

                    </div>
                    <div class="item">
                        <div class="deal-image  retated-itms">
                            <img src="<?php echo e(asset('frontend/images/m-3.png')); ?>" class="img-fluid" alt="">
                        </div>

                    </div>
                </div>

            </div>
            <!--most-related to your items -->
            <div class="todays-deal related-items most-rlted">

                <div class="row">
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="most-loved">
                            <h6>Customer’ Most-Loved
                                Fashion For You</h6>
                            <div class="loved-images">
                                <img src="<?php echo e(asset('frontend/images/l-1.png')); ?>" class="img-fluid" alt="">
                                <img src="<?php echo e(asset('frontend/images/l-2.png')); ?>" class="img-fluid" alt="">
                                <img src="<?php echo e(asset('frontend/images/l-3.png')); ?>" class="img-fluid" alt="">
                                <img src="<?php echo e(asset('frontend/images/l-4.png')); ?>" class="img-fluid" alt="">

                            </div>
                            <a class="explr" href="#">Explore More</a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-12">
                        <div class=" loved-img most-loved">
                            <h6>Keep Shopping For</h6>
                            <div class="gym-right-image">
                                <div class="images-items-all">
                                    <div class="images-items">
                                        <img src="<?php echo e(asset('frontend/images/k-1.png')); ?>" class="img-fluid"
                                            alt="">
                                    </div>
                                    <p>Wides Men’s Synt..</p>
                                    <a href="#">₹545 </a>
                                </div>
                                <div class="images-items-all">
                                    <div class="images-items">
                                        <img src="<?php echo e(asset('frontend/images/k-2.png')); ?>" class="img-fluid"
                                            alt="">
                                    </div>
                                    <p>Elmira Small..</p>
                                    <a href="#">₹545 </a>
                                </div>
                                <div class="images-items-all">
                                    <div class="images-items">
                                        <img src="<?php echo e(asset('frontend/images/k-3.png')); ?>" class="img-fluid"
                                            alt="">
                                    </div>
                                    <p>The House Of Tara..</p>
                                    <a href="#">₹2,090</a>
                                </div>
                                <div class="images-items-all">
                                    <div class="images-items">
                                        <img src="<?php echo e(asset('frontend/images/k-4.png')); ?>" class="img-fluid"
                                            alt="">
                                    </div>
                                    <p>Supplement...</p>
                                    <a href="#">₹921</a>
                                </div>
                            </div>
                            <a class="explr" href="#">See More</a>


                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="most-loved">
                            <h6>Pick Up Where You Left off</h6>
                            <div class="pick-up">
                                <img src="<?php echo e(asset('frontend/images/cus-1.png')); ?>" class="img-fluid"
                                    alt="">
                                <p>SwassFiit Brand- Symactive Neoprene Coated Solid Kettlebell For..</p>
                            </div>
                            <div class="rupees-all">
                                <a href="">₹809</a>
                                <span>M.R.P ₹360</span>
                            </div>

                            <div class="acrd-btm">
                                <img src="<?php echo e(asset('frontend/images/cus-2.png')); ?>" class="img-fluid"
                                    alt="">
                                <img src="<?php echo e(asset('frontend/images/cus-3.png')); ?>" class="img-fluid"
                                    alt="">
                                <img src="<?php echo e(asset('frontend/images/cus-4.png')); ?>" class="img-fluid"
                                    alt="">
                                <img src="<?php echo e(asset('frontend/images/cus-5.png')); ?>" class="img-fluid"
                                    alt="">

                            </div>
                            <a class="explr" href="#">See More</a>

                        </div>
                    </div>

                    <div class="col-lg-3 col-md-12 col-12">
                        <div class="gym-right loved-img most-loved">
                            <p>Best seller In Home
                                Decoration..</p>
                            <div class="gym-right-image">
                                <div class="images-items-all">
                                    <div class="images-items right-most">
                                        <img src="<?php echo e(asset('frontend/images/best-1.png')); ?>" class="img-fluid"
                                            alt="">
                                    </div>
                                    <p>Cushion Covers,
                                        Bedsheets & More</p>
                                </div>
                                <div class="images-items-all">
                                    <div class="images-items right-most">
                                        <img src="<?php echo e(asset('frontend/images/best-1.png')); ?>" class="img-fluid"
                                            alt="">
                                    </div>
                                    <p>Cushion Covers,
                                        Bedsheets & More</p>
                                </div>
                                <div class="images-items-all">
                                    <div class="images-items right-most">
                                        <img src="<?php echo e(asset('frontend/images/best-2.png')); ?>" class="img-fluid"
                                            alt="">
                                    </div>
                                    <p>Figurines, Vases
                                        And More</p>
                                </div>
                                <div class="images-items-all">
                                    <div class="images-items right-most">
                                        <img src="<?php echo e(asset('frontend/images/best-1.png')); ?>" class="img-fluid"
                                            alt="">
                                    </div>
                                    <p>Cushion Covers,
                                        Bedsheets & More</p>
                                </div>

                                <a class="explr" href="#">See More</a>
                            </div>


                        </div>
                    </div>
                </div>





            </div>




            <!-- you-might also-like -->
            <div class="todays-deal related-items">
                <div class="common-headinng">
                    <h6>Most Items To Consider</h6>
                </div>

                <div class="owl-carousel deal-carousel owl-theme">
                    <div class="item">
                        <div class="deal-image retated-itms">
                            <img src="<?php echo e(asset('frontend/images/e-1.png')); ?>" class="img-fluid" alt="">
                        </div>

                    </div>
                    <div class="item">

                        <div class="deal-image retated-itms">
                            <img src="<?php echo e(asset('frontend/images/e-2.png')); ?>" class="img-fluid" alt="">
                        </div>


                    </div>
                    <div class="item">
                        <div class="deal-image  retated-itms">
                            <img src="<?php echo e(asset('frontend/images/e-3.png')); ?>" class="img-fluid" alt="">
                        </div>

                    </div>
                    <div class="item">
                        <div class="deal-image  retated-itms">
                            <img src="<?php echo e(asset('frontend/images/e-4.png')); ?>" class="img-fluid" alt="">
                        </div>

                    </div>
                    <div class="item">
                        <div class="deal-image  retated-itms">
                            <img src="<?php echo e(asset('frontend/images/e-5.png')); ?>" class="img-fluid" alt="">
                        </div>

                    </div>
                    <div class="item">
                        <div class="deal-image  retated-itms">
                            <img src="<?php echo e(asset('frontend/images/e-1.png')); ?>" class="img-fluid" alt="">
                        </div>

                    </div>
                    <div class="item">
                        <div class="deal-image  retated-itms">
                            <img src="<?php echo e(asset('frontend/images/e-2.png')); ?>" class="img-fluid" alt="">
                        </div>

                    </div>
                </div>

            </div>

            <!-- additional items -->
            <div class="todays-deal related-items">
                <div class="common-headinng">
                    <h6>Most Items To Consider</h6>
                    <a href="#">See more</a>
                </div>

                <div class="owl-carousel deal-carousel owl-theme">
                    <div class="item">
                        <div class="deal-image retated-itms">
                            <img src="<?php echo e(asset('frontend/images/bag-1.png')); ?>" class="img-fluid" alt="">
                        </div>

                    </div>
                    <div class="item">

                        <div class="deal-image retated-itms">
                            <img src="<?php echo e(asset('frontend/images/bag-2.png')); ?>" class="img-fluid" alt="">

                        </div>


                    </div>
                    <div class="item">
                        <div class="deal-image  retated-itms">
                            <img src="<?php echo e(asset('frontend/images/bag-3.png')); ?>" class="img-fluid" alt="">

                        </div>

                    </div>
                    <div class="item">
                        <div class="deal-image  retated-itms">
                            <img src="<?php echo e(asset('frontend/images/bag-4.png')); ?>" class="img-fluid" alt="">

                        </div>

                    </div>
                    <div class="item">
                        <div class="deal-image  retated-itms">
                            <img src="<?php echo e(asset('frontend/images/bag-5.png')); ?>" class="img-fluid" alt="">

                        </div>

                    </div>
                    <div class="item">
                        <div class="deal-image  retated-itms">
                            <img src="<?php echo e(asset('frontend/images/bag-1.png')); ?>" class="img-fluid" alt="">

                        </div>

                    </div>
                    <div class="item">
                        <div class="deal-image  retated-itms">
                            <img src="<?php echo e(asset('frontend/images/bag-2.png')); ?>" class="img-fluid" alt="">

                        </div>

                    </div>
                </div>

            </div>




            <!--most-related to your items -->
            <div class="todays-deal related-items most-rlted">

                <div class="row">


                    <div class="col-lg-3 col-md-4 col-12">
                        <div class=" loved-img most-loved">
                            <h6>Most Item’s To Consider</h6>
                            <div class="gym-right-image">
                                <div class="images-items-all">
                                    <div class="images-items">
                                        <img src="<?php echo e(asset('frontend/images/dmbl-1.png')); ?>" class="img-fluid"
                                            alt="">
                                    </div>
                                    <p>Storio Kids Toys..</p>
                                    <a href="#">₹149 </a>
                                </div>
                                <div class="images-items-all">
                                    <div class="images-items">
                                        <img src="<?php echo e(asset('frontend/images/dmbl-2.png')); ?>" class="img-fluid"
                                            alt="">
                                    </div>
                                    <p>Lapster Multico..</p>
                                    <a href="#">₹199 </a>
                                </div>
                                <div class="images-items-all">
                                    <div class="images-items">
                                        <img src="<?php echo e(asset('frontend/images/dmbl-1.png')); ?>" class="img-fluid"
                                            alt="">
                                    </div>
                                    <p>Eumqestoer LCD..</p>
                                    <a href="#">₹99</a>
                                </div>
                                <div class="images-items-all">
                                    <div class="images-items">
                                        <img src="<?php echo e(asset('frontend/images/dmbl-3.png')); ?>" class="img-fluid"
                                            alt="">
                                    </div>
                                    <p>Toy Imagine 8.5 In </p>
                                    <a href="#">₹99</a>
                                </div>
                            </div>
                            <a class="explr" href="#">See More</a>


                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="most-loved">
                            <h6>Customer’ Most-Loved
                                Fashion For You</h6>
                            <div class="dmbl-images">
                                <img src="<?php echo e(asset('frontend/images/dmbl.png')); ?>" class="img-fluid" alt="">

                            </div>
                            <a class="explr" href="#">See More</a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="most-loved">
                            <h6>See The Exclusive Video
                                Footages Of Our Latest
                                Product</h6>

                            <div class="utube">

                                <div class="uimg">
                                    <img src="<?php echo e(asset('frontend/images/utube.png')); ?>" class="img-fluid"
                                        alt="">
                                </div>

                                <!-- Button trigger modal -->
                                <div class="btn video-btn" data-bs-toggle="modal"
                                    data-src="https://www.youtube.com/embed/Jfrjeg26Cwk" data-bs-target="#myModal">
                                    <img src="<?php echo e(asset('frontend/images/rmv.png')); ?>" class="img-fluid"
                                        alt="">
                                </div>

                            </div>

                        </div>

                    </div>


                    <div class="col-lg-3 col-md-4 col-12">
                        <div class=" loved-img most-loved">
                            <h6>Best seller In Men’s
                                Fitness Instruments</h6>
                            <div class="gym-right-image">
                                <div class="images-items-all">
                                    <div class="images-items">
                                        <img src="<?php echo e(asset('frontend/images/last-1.png')); ?>" class="img-fluid"
                                            alt="">
                                    </div>
                                    <p>Techno Pop 8 Gra..</p>
                                    <a href="#">₹6599 </a>
                                </div>
                                <div class="images-items-all">
                                    <div class="images-items">
                                        <img src="<?php echo e(asset('frontend/images/last-2.png')); ?>" class="img-fluid"
                                            alt="">
                                    </div>
                                    <p>Realme Narzo..</p>
                                    <a href="#">₹8,999 </a>
                                </div>
                                <div class="images-items-all">
                                    <div class="images-items">
                                        <img src="<?php echo e(asset('frontend/images/last-3.png')); ?>" class="img-fluid"
                                            alt="">
                                    </div>
                                    <p>OnePlus Nord CE..</p>
                                    <a href="#">₹1,799</a>
                                </div>
                                <div class="images-items-all">
                                    <div class="images-items">
                                        <img src="<?php echo e(asset('frontend/images/last-4.png')); ?>" class="img-fluid"
                                            alt="">
                                    </div>
                                    <p>Samsung Brand..</p>
                                    <a href="#">₹8,749</a>
                                </div>
                            </div>
                            <a class="explr" href="#">Explore More</a>


                        </div>
                    </div>
                </div>





            </div>









            <!-- additional items -->
            <div class="todays-deal related-items">
                <div class="common-headinng">
                    <h6>Your Browsing History</h6>
                    <a href="#">View Or Edit Your Browsing History </a>
                </div>

                <div class="owl-carousel trouser-carousel owl-theme">
                    <div class="item">
                        <div class="deal-image retated-itms">
                            <img src="<?php echo e(asset('frontend/images/t-1.png')); ?>" class="img-fluid" alt="">
                        </div>

                    </div>
                    <div class="item">

                        <div class="deal-image retated-itms">
                            <img src="<?php echo e(asset('frontend/images/t-2.png')); ?>" class="img-fluid" alt="">

                        </div>


                    </div>
                    <div class="item">
                        <div class="deal-image  retated-itms">
                            <img src="<?php echo e(asset('frontend/images/t-3.png')); ?>" class="img-fluid" alt="">

                        </div>

                    </div>
                    <div class="item">
                        <div class="deal-image  retated-itms">
                            <img src="<?php echo e(asset('frontend/images/t-4.png')); ?>" class="img-fluid" alt="">

                        </div>

                    </div>
                    <div class="item">
                        <div class="deal-image  retated-itms">
                            <img src="<?php echo e(asset('frontend/images/t-5.png')); ?>" class="img-fluid" alt="">

                        </div>

                    </div>
                    <div class="item">
                        <div class="deal-image  retated-itms">
                            <img src="<?php echo e(asset('frontend/images/t-6.png')); ?>" class="img-fluid" alt="">

                        </div>

                    </div>
                    <div class="item">
                        <div class="deal-image  retated-itms">
                            <img src="<?php echo e(asset('frontend/images/t-7.png')); ?>" class="img-fluid" alt="">

                        </div>

                    </div>
                    <div class="item">
                        <div class="deal-image  retated-itms">
                            <img src="<?php echo e(asset('frontend/images/t-8.png')); ?>" class="img-fluid" alt="">

                        </div>

                    </div>
                    <div class="item">
                        <div class="deal-image  retated-itms">
                            <img src="<?php echo e(asset('frontend/images/t-1.png')); ?>" class="img-fluid" alt="">

                        </div>

                    </div>
                </div>

            </div>
        </div>
        <!-- go-top -->
        <div class="go-topp">
            <p>Go To Top</p>
        </div>
    </div>


    <!-- service -->
    <div class="services">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="our-ser">
                        <img src="<?php echo e(asset('frontend/images/ser-1.png')); ?>" class="img-fluid" alt="">
                        <h6>Free and Fast Delivery</h6>
                        <p>Free delivery for all orders over ₹140</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="our-ser">
                        <img src="<?php echo e(asset('frontend/images/ser-2.png')); ?>" class="img-fluid" alt="">
                        <h6>24/7 Customer Service</h6>
                        <p>Friendly 24/7 customer support</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="our-ser">
                        <img src="<?php echo e(asset('frontend/images/ser-3.png')); ?>" class="img-fluid" alt="">
                        <h6>Money Back Guarantee</h6>
                        <p>We reurn money within 30 days</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="footer-logo">
                        <a href="">
                            <img src="<?php echo e(asset('frontend/images/ft-logo.png')); ?>" class="img-fluid" alt="">
                        </a>
                    </div>

                    <ul class="socials">
                        <li><a href=""><img src="<?php echo e(asset('frontend/images/f-1.png')); ?>" class="img-fluid"
                                    alt=""></a></li>
                        <li><a href=""><img src="<?php echo e(asset('frontend/images/f-2.png')); ?>" class="img-fluid"
                                    alt=""></a></li>
                        <li><a href=""><img src="<?php echo e(asset('frontend/images/f-3.png')); ?>" class="img-fluid"
                                    alt=""></a></li>

                    </ul>
                </div>
                <div class="col-lg-8 col-md-8 col-12">
                    <div class="right-footer">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-12">
                                <h4>Company</h4>
                                <ul>
                                    <li><a href="">About Us</a></li>
                                    <li><a href="">Become a Coach</a></li>
                                    <li><a href="">Help & Support</a></li>
                                    <li><a href="<?php echo e(route('frontend.contact')); ?>">Contact Us</a></li>

                                </ul>

                            </div>
                            <div class="col-lg-4 col-md-4 col-12">
                                <h4>Services</h4>
                                <ul>
                                    <li><a href="">Online Coaching</a></li>
                                    <li><a href="">Workout & Diet</a></li>
                                    <li><a href="">Trainer Assistance</a></li>
                                    <li><a href="">Health & Wellness Awarness</a></li>

                                </ul>

                            </div>
                            <div class="col-lg-4 col-md-4 col-12">
                                <h4>Legal</h4>
                                <ul>
                                    <li><a href="">Terms & Conditions</a></li>
                                    <li><a href="">Privacy Policy</a></li>
                                    <li><a href="">Refund Policy</a></li>

                                </ul>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <p>&#169;SwaasthFiit 2023</p>
        </div>
    </footer>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">


                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></span>
                    </button>
                    <!-- 16:9 aspect ratio -->
                    <div class="ratio ratio-16x9">
                        <iframe class="embed-responsive-item" src="" id="video"
                            allowscriptaccess="always" allow="autoplay"></iframe>
                    </div>


                </div>

            </div>
        </div>
    </div>



    <div class="go-top"><i class="fa fa-angle-double-up" aria-hidden="true"></i></div>
    <script src="<?php echo e(asset('frontend/js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('frontend/js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('frontend/js/stellarnav.min.js')); ?>"></script>
    <script src="<?php echo e(asset('frontend/js/owl.carousel.min.js')); ?>"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
    <script src="<?php echo e(asset('frontend/js/WOW.js')); ?>"></script>
    <script src="<?php echo e(asset('frontend/js/custom.js')); ?>"></script>


    <script>
        $('.deal-carousel').owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
            responsive: {
                0: {
                    items: 1
                },
                768: {
                    items: 3
                },
                1000: {
                    items: 5
                }
            }
        })
    </script>
    <script>
        $('.trouser-carousel').owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            navText: ["<img src='images/rgt.png')}}'>", "<img src='images/lft.png')}}'>"],
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 8
                }
            }
        })
    </script>

    <script>
        $(window).scroll(function() {
            if ($(this).scrollTop() > 50) /*height in pixels when the navbar becomes non scroll*/ {
                $('.main-nav').addClass('scroll');
            } else {
                $('.main-nav').removeClass('scroll');
            }
        });
    </script>

    <script>
        // Declare a variable to store the video source
        let videoSrc;

        // Add click event listener to all elements with class "video-btn"
        document.querySelectorAll('.video-btn').forEach(button => {
            button.addEventListener('click', () => {
                // Get the video source from the data-src attribute
                videoSrc = button.dataset.src;
                console.log(videoSrc);
            });
        });

        // Add event listener for when the modal is opened
        document.getElementById('myModal').addEventListener('shown.bs.modal', () => {
            // Update the video source with autoplay and other options
            document.getElementById('video').src = videoSrc + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0";
        });

        // Add event listener for when the modal is closed
        document.getElementById('myModal').addEventListener('hide.bs.modal', () => {
            // Stop the video by resetting the source
            document.getElementById('video').src = videoSrc;
        });
    </script>


</body>

</html>
<?php /**PATH J:\DECEMBER-2024\SWASINFO(latest)\shyamfuturetech-swasthafit(latest)\resources\views/ecom/layouts/main.blade.php ENDPATH**/ ?>