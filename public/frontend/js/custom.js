(function ($) {
    "use strict";
    

    // Mean Menu
    $('#main-nav').stellarNav({
        theme     :'plain',
        breakpoint: 768,
        phoneBtn:false,
        locationBtn:false,
        sticky     :false,
        openingSpeed: 250,
        closingDelay: 250,
        position:'right',
        showArrows:true,
        closeBtn     :false,
        scrollbarFix:false,
        mobileMode:false
      
      });

    
  

    $(".banner-slider-area").owlCarousel({
        autoplayHoverPause: true,
        autoplaySpeed: 1500,
        autoplay: true,
        loop: true,
        dots: true,
        margin: 30,
        responsive: {
            0: {
                items: 1,
            },
            768: {
                items: 1,
            },
			992: {
                items: 1,
            },
        },
    });
    

    // Go to Top
    $(function () {
        // Scroll Event
        $(window).on("scroll", function () {
            var scrolled = $(window).scrollTop();
            if (scrolled > 600) $(".go-top").addClass("active");
            if (scrolled < 600) $(".go-top").removeClass("active");
        });
        // Click Event
        $(".go-top").on("click", function () {
            $("html, body").animate({ scrollTop: "0" }, 500);
        });
    });


    // WOW Animation JS
    if ($(".wow").length) {
        var wow = new WOW({
            mobile: false,
        });
        wow.init();
    }

})(jQuery);


