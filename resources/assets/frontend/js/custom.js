(function ($) {
    "use strict";
    var swiper = new Swiper('.swiper-container-top', {
        direction: 'vertical',
        slidesPerView: 1,
        mousewheel: true,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    });
    var swiper = new Swiper('.mySwiper', {
        slidesPerView: 3,
        spaceBetween: 30,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    });
    var swiper = new Swiper('.rated-products-mySwiper', {
        slidesPerView: 5,

        spaceBetween: 20,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    });
    var swiper = new Swiper('.cannamoly-row-mySwiper', {
        slidesPerView: 4,

        spaceBetween: 20,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    });
    var swiper = new Swiper('.cannamoly-row-mySwiper2', {
        slidesPerView: 4,
        spaceBetween: 20,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    });
    var swiper = new Swiper('.top-categories-mySwiper', {
        slidesPerView: 6,

        spaceBetween: 20,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
            breakpoints: {
                1024: {
                    slidesPerView: 2,
                    spaceBetween: 10,
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 10
                },
                640: {
                    slidesPerView: 1,
                    spaceBetween: 10
                },
                320: {
                    slidesPerView: 1,
                    spaceBetween: 10
                }
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
        // Click Eventbrands
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
    $(document).ready(function () {
        var quantitiy = 0;
        $('.quantity-right-plus').click(function (e) {

            // Stop acting like a button
            e.preventDefault();
            // Get the field name
            var quantity = parseInt($('#quantity').val());

            // If is not undefined

            $('#quantity').val(quantity + 1);

            // Increment

        });
        $('.quantity-left-minus').click(function (e) {
            // Stop acting like a button
            e.preventDefault();
            // Get the field name
            var quantity = parseInt($('#quantity').val());

            // If is not undefined

            // Increment
            if (quantity > 0) {
                $('#quantity').val(quantity - 1);
            }
        });

    });
    ; (function ($) {
        $.fn.picZoomer = function (options) {
            var opts = $.extend({}, $.fn.picZoomer.defaults, options),
                $this = this,
                $picBD = $('<div class="picZoomer-pic-wp"></div>').css({ 'width': opts.picWidth + 'px', 'height': opts.picHeight + 'px' }).appendTo($this),
                $pic = $this.children('img').addClass('picZoomer-pic').appendTo($picBD),
                $cursor = $('<div class="picZoomer-cursor"><i class="f-is picZoomCursor-ico"></i></div>').appendTo($picBD),
                cursorSizeHalf = { w: $cursor.width() / 2, h: $cursor.height() / 2 },
                $zoomWP = $('<div class="picZoomer-zoom-wp"><img src="" alt="" class="picZoomer-zoom-pic"></div>').appendTo($this),
                $zoomPic = $zoomWP.find('.picZoomer-zoom-pic'),
                picBDOffset = { x: $picBD.offset().left, y: $picBD.offset().top };

            opts.zoomWidth = opts.zoomWidth || opts.picWidth;
            opts.zoomHeight = opts.zoomHeight || opts.picHeight;
            var zoomWPSizeHalf = { w: opts.zoomWidth / 2, h: opts.zoomHeight / 2 };

            $zoomWP.css({ 'width': opts.zoomWidth + 'px', 'height': opts.zoomHeight + 'px' });
            $zoomWP.css(opts.zoomerPosition || { top: 0, left: opts.picWidth + 30 + 'px' });

            $zoomPic.css({ 'width': opts.picWidth * opts.scale + 'px', 'height': opts.picHeight * opts.scale + 'px' });

            $picBD.on('mouseenter', function (event) {
                $cursor.show();
                $zoomWP.show();
                $zoomPic.attr('src', $pic.attr('src'))
            }).on('mouseleave', function (event) {
                $cursor.hide();
                $zoomWP.hide();
            }).on('mousemove', function (event) {
                var x = event.pageX - picBDOffset.x,
                    y = event.pageY - picBDOffset.y;
                $cursor.css({ 'left': x - cursorSizeHalf.w + 'px', 'top': y - cursorSizeHalf.h + 'px' });
                $zoomPic.css({ 'left': -(x * opts.scale - zoomWPSizeHalf.w) + 'px', 'top': -(y * opts.scale - zoomWPSizeHalf.h) + 'px' });
            });
            return $this;
        };
        $.fn.picZoomer.defaults = {
            picHeight: 460,
            scale: 2.5,
            zoomerPosition: { top: '0', left: '380px' },
            zoomWidth: 400,
            zoomHeight: 460
        };
    })(jQuery);
    $(document).ready(function () {
        $('.picZoomer').picZoomer();
        $('.piclist li').on('click', function (event) {
            var $pic = $(this).find('img');
            $('.picZoomer-pic').attr('src', $pic.attr('src'));
        });

        var owl = $('#recent_post');
        owl.owlCarousel({
            margin: 20,
            dots: false,
            nav: true,
            navText: [
                "<i class='fa fa-chevron-left'></i>",
                "<i class='fa fa-chevron-right'></i>"
            ],
            autoplay: true,
            autoplayHoverPause: true,
            responsive: {
                0: {
                    items: 2
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 5
                },
                1200: {
                    items: 4
                }
            }
        });

        $('.decrease_').click(function () {
            decreaseValue(this);
        });
        $('.increase_').click(function () {
            increaseValue(this);
        });
        function increaseValue(_this) {
            var value = parseInt($(_this).siblings('input#number').val(), 10);
            value = isNaN(value) ? 0 : value;
            value++;
            $(_this).siblings('input#number').val(value);
        }
        function decreaseValue(_this) {
            var value = parseInt($(_this).siblings('input#number').val(), 10);
            value = isNaN(value) ? 0 : value;
            value < 1 ? value = 1 : '';
            value--;
            $(_this).siblings('input#number').val(value);
        }
    });
})(jQuery);
