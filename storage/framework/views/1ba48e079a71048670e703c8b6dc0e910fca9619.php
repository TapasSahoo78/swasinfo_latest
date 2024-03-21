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
    <link rel="stylesheet" href="<?php echo e(asset('frontend/css/style2.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('frontend/css/responsive.css')); ?>">
    <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css">

    <title>SwaasthFiit</title>
    <link rel="shortcut icon" href="<?php echo e(asset('frontend/images/favicon.ico')); ?>">

    <link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

</head>

<body>
    <!-- Mainnav Section -->
    <?php echo $__env->make('frontend.layouts.include.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- Mainnav Section End -->

    <?php echo $__env->yieldContent('content'); ?>
    <!-- MeetourTeam Section End -->

   <?php echo $__env->make('frontend.layouts.include.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="go-top"><i class="fa fa-angle-double-up" aria-hidden="true"></i></div>
    <script src="<?php echo e(asset('frontend/js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('frontend/js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('frontend/js/stellarnav.min.js')); ?>"></script>
    <script src="<?php echo e(asset('frontend/js/owl.carousel.min.js')); ?>"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
    <script src="<?php echo e(asset('frontend/js/WOW.js')); ?>"></script>
    <script src="<?php echo e(asset('frontend/js/custom.js')); ?>"></script>
    <script src="<?php echo e(asset('frontend/js/event.js')); ?>"></script>


    <script type="text/javascript">
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-36251023-1']);
        _gaq.push(['_setDomainName', 'jqueryscript.net']);
        _gaq.push(['_trackPageview']);

        (function() {
            var ga = document.createElement('script');
            ga.type = 'text/javascript';
            ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') +
                '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(ga, s);
        })();
    </script>
    <script>
        try {
            fetch(new Request("https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js", {
                method: 'HEAD',
                mode: 'no-cors'
            })).then(function(response) {
                return true;
            }).catch(function(e) {
                var carbonScript = document.createElement("script");
                carbonScript.src = "//cdn.carbonads.com/carbon.js?serve=CK7DKKQU&placement=wwwjqueryscriptnet";
                carbonScript.id = "_carbonads_js";
                document.getElementById("carbon-block").appendChild(carbonScript);
            });
        } catch (error) {
            console.log(error);
        }
    </script>
    <script>
        $(document).ready(function() {
            $('.banner-carousel').owlCarousel({
                //animateOut: 'slideOutDown',
                //animateIn: 'flipInX',
                animateOut: 'fadeOut',
                animateIn: 'fadeIn',
                loop: true,
                margin: 0,
                navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
                // navText: ["<img src='images/arrow-alt-left.png')}}'>","<img src='images/arrow-alt-right.png')}}'>"],
                autoplay: true,
                responsiveClass: true,
                // smartSpeed:450,
                responsive: {
                    0: {
                        items: 1,
                        nav: true
                    },
                    600: {
                        items: 1,
                        nav: false
                    },
                    1000: {
                        items: 1,
                        nav: true,
                        loop: false,
                        margin: 0
                    }
                }
            })
        })
    </script>
    <script>
        $('.firstwealth-carousel').owlCarousel({
            loop: true,
            autoplay: true,
            stagePadding: 190,
            margin: 20,
            nav: false,
            dots: true,
            items: 2,
            responsiveClass: true,
            navText: ["<img src='assets/images/left-arw.png')}}'>", "<img src='assets/images/right-arw.png')}}'>"],
            responsive: {
                0: {
                    stagePadding: 0,
                    items: 1,
                    nav: false,
                    dots: true
                },
                600: {
                    stagePadding: 0,
                    items: 3.5,
                    nav: false,
                    dots: true
                },
                1000: {
                    stagePadding: 0,
                    items: 4.5,
                    loop: true,
                }
            }
        })
    </script>


    <!-- <script>
        $(window).scroll(function() {
            if ($(this).scrollTop() > 50) /*height in pixels when the navbar becomes non scroll*/ {
                $('.main-nav').addClass('scroll');
            } else {
                $('.main-nav').removeClass('scroll');
            }
        });
    </script> -->


</body>

</html>
<?php /**PATH /home/u932153640/domains/swasthfit.in/public_html/resources/views/frontend/layouts/main.blade.php ENDPATH**/ ?>