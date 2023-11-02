function initSliders() {

    var TrandingSlider = new Swiper('.tranding-slider', {
        effect: 'coverflow',
        grabCursor: true,
        centeredSlides: true,
        loop: true,
        slidesPerView: 'auto',
        coverflowEffect: {
            rotate: 0,
            stretch: 0,
            depth: 500,
            modifier: 50,
            slideShadows: false,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        }
    });

    $('.banner-carousel').not('.slick-initialized').slick({
        centerMode: true,
        centerPadding: '250px',
        slidesToShow: 1,
        arrows: true,
        dots: true,
        autoplay: false,
        appendDots: $(".slide-m-dots"),
        prevArrow: $(".slide-m-prev"),
        nextArrow: $(".slide-m-next"),
        responsive: [
            {
                breakpoint: 1366,
                settings: {
                    centerMode: true,
                    centerPadding: '180px',
                    slidesToShow: 1
                }
            },
            {
                breakpoint: 1024,
                settings: {
                    centerMode: true,
                    centerPadding: '160px',
                    slidesToShow: 1
                }
            },
            {
                breakpoint: 960,
                settings: {
                    centerMode: true,
                    centerPadding: '180px',
                    slidesToShow: 1
                }
            },
            // {
            //     breakpoint: 600,
            //     settings: {
            //         centerMode: true,
            //         centerPadding: '10px',
            //         slidesToShow: 1,
            //         dots: false,
            //     }
            // },
            {
                breakpoint: 480,
                settings: {
                    centerMode: true,
                    centerPadding: '60px',
                    slidesToShow: 1,
                    dots: false,
                }
            }
        ]
    });

    $('.premium-carousel').not('.slick-initialized').slick({
        slidesToShow: 1,
        arrows: true,
        dots: true,
        autoplay: false,
        appendDots: $(".slide-m-dots"),
        prevArrow: $(".slide-m-prev"),
        nextArrow: $(".slide-m-next"),
    });

    $('.banner-carousel-1').not('.slick-initialized').slick({
        slidesToShow: 1,
        arrows: true,
        dots: true,
        autoplay: true,
        autoplaySpeed: 1000,
        // appendDots: $(".slide-sl-dots"),
        // prevArrow: $(".slide-sl-prev"),
        // nextArrow: $(".slide-sl-next"),
    });

    $('.carousel-initilize').not('.slick-initialized').slick({
        dots: false,
        infinite: false,
        speed: 300,
        slidesToShow: 4.8,
        slidesToScroll: 1,
        accessibility: true,
        responsive: [
            {
                breakpoint: 1367,
                settings: {
                    slidesToShow: 5.2,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 1025,
                settings: {
                    slidesToShow: 4.3,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 769,
                settings: {
                    slidesToShow: 3.8,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1.8,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1.8,
                    slidesToScroll: 1
                }
            }
        ]
    });
    $('.games').not('.slick-initialized').slick({
        dots: false,
        infinite: false,
        speed: 300,
        slidesToShow: 7.8,
        slidesToScroll: 1,
        accessibility: true,
        responsive: [
            {
                breakpoint: 1367,
                settings: {
                    slidesToShow: 7.8,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 1025,
                settings: {
                    slidesToShow: 4.8,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 769,
                settings: {
                    slidesToShow: 4.5,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2.5,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2.5,
                    slidesToScroll: 1
                }
            }
        ]
    });
    $('.vertical-carousel-initilize').not('.slick-initialized').slick({
        dots: false,
        infinite: false,
        speed: 300,
        slidesToShow: 7.9,
        slidesToScroll: 1,
        accessibility: true,
        responsive: [
            {
                breakpoint: 1367,
                settings: {
                    slidesToShow: 8.4,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 1025,
                settings: {
                    slidesToShow: 6.2,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 769,
                settings: {
                    slidesToShow: 4.5,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2.7,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2.5,
                    slidesToScroll: 1
                }
            }
        ]
    });

    $('.vertical-carousel-retro').not('.slick-initialized').slick({
        dots: false,
        infinite: false,
        speed: 300,
        slidesToShow: 6.1,
        slidesToScroll: 1,
        accessibility: true,
        responsive: [
            {
                breakpoint: 1367,
                settings: {
                    slidesToShow: 6.1,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 1025,
                settings: {
                    slidesToShow: 4.1,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 769,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2.5,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2.5,
                    slidesToScroll: 1
                }
            }
        ]
    });

    $('.short-sweet-carousel').not('.slick-initialized').slick({
        dots: false,
        infinite: false,
        speed: 300,
        slidesToShow: 7.2,
        slidesToScroll: 1,
        accessibility: true,
        responsive: [
            {
                breakpoint: 1367,
                settings: {
                    slidesToShow: 5.5,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 1025,
                settings: {
                    slidesToShow: 5.9,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 769,
                settings: {
                    slidesToShow: 4.2,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 3.2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2.5,
                    slidesToScroll: 1
                }
            }
        ]
    });

    $('.cust-collection').not('.slick-initialized').slick({
        dots: false,
        infinite: false,
        speed: 300,
        slidesToShow: 3,
        slidesToScroll: 1,
        accessibility: true,
        responsive: [
            {
                breakpoint: 1367,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 1025,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 769,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });

    $('.punjab-carousel').not('.slick-initialized').slick({
        dots: false,
        infinite: false,
        speed: 300,
        slidesToShow: 3.5,
        slidesToScroll: 1,
        accessibility: true,
        responsive: [
            {
                breakpoint: 1367,
                settings: {
                    slidesToShow: 3.5,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 1025,
                settings: {
                    slidesToShow: 2.5,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 769,
                settings: {
                    slidesToShow: 2.7,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1.7,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1.7,
                    slidesToScroll: 1
                }
            }
        ]
    });

    $('.gaming-galore').not('.slick-initialized').slick({
        dots: false,
        infinite: false,
        speed: 300,
        slidesToShow: 6.5,
        slidesToScroll: 1,
        accessibility: true,
        responsive: [
            {
                breakpoint: 1367,
                settings: {
                    slidesToShow: 7.4,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 1025,
                settings: {
                    slidesToShow: 5.9,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 769,
                settings: {
                    slidesToShow: 4.2,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 3.2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1.4,
                    slidesToScroll: 1
                }
            }
        ]
    });

    $('.epic-shots').not('.slick-initialized').slick({
        dots: false,
        infinite: false,
        speed: 300,
        slidesToShow: 10.2,
        slidesToScroll: 1,
        accessibility: true,
        responsive: [
            {
                breakpoint: 1367,
                settings: {
                    slidesToShow: 8.5,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 1025,
                settings: {
                    slidesToShow: 7.9,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 769,
                settings: {
                    slidesToShow: 5.2,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 4.2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2.8,
                    slidesToScroll: 1
                }
            }
        ]
    });

    $('.epic-channel').not('.slick-initialized').slick({
        dots: false,
        infinite: false,
        speed: 300,
        slidesToShow: 7.5,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 1367,
                settings: {
                    slidesToShow: 7.5,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 1025,
                settings: {
                    slidesToShow: 5.5,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 769,
                settings: {
                    slidesToShow: 4.5,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 4.5,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 3.5,
                    slidesToScroll: 1
                }
            }
        ]
    });
    $('.popular-language').not('.slick-initialized').slick({
        dots: false,
        infinite: false,
        speed: 300,
        slidesToShow: 8.2,
        slidesToScroll: 1,
        accessibility: true,
        responsive: [
            {
                breakpoint: 1367,
                settings: {
                    slidesToShow: 8.2,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 1025,
                settings: {
                    slidesToShow: 6.2,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 769,
                settings: {
                    slidesToShow: 5.2,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 4.2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2.5,
                    slidesToScroll: 1
                }
            }
        ]
    });

    $('.blockbuster-mm').not('.slick-initialized').slick({
        dots: false,
        infinite: false,
        speed: 300,
        slidesToShow: 7.1,
        slidesToScroll: 1,
        adaptiveHeight: true,
        responsive: [
            {
                breakpoint: 1367,
                settings: {
                    slidesToShow: 7.1,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 1025,
                settings: {
                    slidesToShow: 5.5,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 769,
                settings: {
                    slidesToShow: 4.5,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 3.5,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2.5,
                    slidesToScroll: 1
                }
            }
        ]
    });

    $('.discover-next-watch').not('.slick-initialized').slick({
        dots: false,
        infinite: false,
        speed: 300,
        slidesToShow: 4.5,
        slidesToScroll: 1,
        adaptiveHeight: true,
        responsive: [
            {
                breakpoint: 1367,
                settings: {
                    slidesToShow: 4.5,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 1025,
                settings: {
                    slidesToShow: 3.5,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 769,
                settings: {
                    slidesToShow: 2.5,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1.1,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1.1,
                    slidesToScroll: 1
                }
            }
        ]
    });


    // new release
    $('.banner-carousel-new-release').not('.slick-initialized').slick({
        centerMode: true,
        centerPadding: '350px',
        slidesToShow: 1,
        arrows: true,
        dots: true,
        autoplay: false,
        asNavFor: '.new-release-bottom',
        appendDots: $(".slide-m-dots-new-release"),
        prevArrow: $(".slide-m-prev-new-release"),
        nextArrow: $(".slide-m-next-new-release"),
        responsive: [
            {
                breakpoint: 1025,
                settings: {
                    centerMode: true,
                    centerPadding: '120px',
                    slidesToShow: 1
                }
            },
            {
                breakpoint: 960,
                settings: {
                    centerMode: true,
                    centerPadding: '120px',
                    slidesToShow: 1
                }
            },
            {
                breakpoint: 600,
                settings: {
                    centerMode: true,
                    centerPadding: '60px',
                    slidesToShow: 1,
                    dots: false,
                }
            },
            {
                breakpoint: 480,
                settings: {
                    centerMode: true,
                    centerPadding: '30px',
                    slidesToShow: 1,
                }
            }
        ]
    });
    $('.new-release-bottom').not('.slick-initialized').slick({
        centerMode: true,
        slidesToShow: 8,
        slidesToScroll: 1,
        focusOnSelect: true,
        arrows: true,
        dots: false,
        //asNavFor: '.banner-carousel-new-release',
        // responsive: [
        //     {
        //         breakpoint: 1367,
        //         settings: {
        //             slidesToShow: 6,
        //             slidesToScroll: 1,
        //         }
        //     },
        //     {
        //         breakpoint: 1025,
        //         settings: {
        //             slidesToShow: 6,
        //             slidesToScroll: 1,
        //         }
        //     },
        //     {
        //         breakpoint: 769,
        //         settings: {
        //             slidesToShow: 5,
        //             slidesToScroll: 1,
        //         }
        //     },
        //     {
        //         breakpoint: 600,
        //         settings: {
        //             slidesToShow: 3,
        //             slidesToScroll: 2
        //         }
        //     },
        //     {
        //         breakpoint: 480,
        //         settings: {
        //             slidesToShow: 2,
        //             slidesToScroll: 1
        //         }
        //     }
        // ]
        responsive: [
            {
                breakpoint: 2000,
                settings: "unslick"
            }
        ]
    });

    $('.imdb').not('.slick-initialized').slick({
        dots: false,
        infinite: false,
        speed: 300,
        slidesToShow: 3.2,
        slidesToScroll: 1,
        accessibility: true,
        responsive: [
            {
                breakpoint: 1367,
                settings: {
                    slidesToShow: 3.2,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 1025,
                settings: {
                    slidesToShow: 2.2,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 769,
                settings: {
                    slidesToShow: 1.9,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1.1,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1.1,
                    slidesToScroll: 1
                }
            }
        ]
    });

    $('.delights-display').not('.slick-initialized').slick({
        dots: false,
        infinite: false,
        speed: 300,
        slidesToShow: 5.5,
        slidesToScroll: 1,
        accessibility: true,
        responsive: [
            {
                breakpoint: 1367,
                settings: {
                    slidesToShow: 5.5,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 1025,
                settings: {
                    slidesToShow: 4.5,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 769,
                settings: {
                    slidesToShow: 3.5,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1.5,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1.5,
                    slidesToScroll: 1
                }
            }
        ]
    });

    $('.wildlife').not('.slick-initialized').slick({
        dots: false,
        infinite: false,
        speed: 300,
        slidesToShow: 3.2,
        slidesToScroll: 1,
        accessibility: true,
        responsive: [
            {
                breakpoint: 1367,
                settings: {
                    slidesToShow: 3.2,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 1025,
                settings: {
                    slidesToShow: 2.2,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 769,
                settings: {
                    slidesToShow: 1.6,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1.1,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1.1,
                    slidesToScroll: 1
                }
            }
        ]
    });

    // distro tv


$(".distrotv-slide-inner").slick({
    autoplay: !1,
    slidesToShow: 6,
    centerMode: !1,
    slidesToScroll: 6,
    dots: !1,
    infinite: !1,
    cssEase: "linear",
    rtl: !1,
    responsive: [
        {
        breakpoint: 3e3,
        settings: {
            slidesToShow: 6.3,
            slidesToScroll: 1
        }
    }, {
        breakpoint: 1600,
        settings: {
            slidesToShow: 4.3,
            slidesToScroll: 1
        }
    }, {
        breakpoint: 1200,
        settings: {
            slidesToShow: 3.3,
            slidesToScroll: 1
        }
    }, {
        breakpoint: 900,
        settings: {
            slidesToShow: 3.3,
            slidesToScroll: 1
        }
    }, {
        breakpoint: 600,
        settings: {
            slidesToShow: 4.3,
            slidesToScroll: 1
        }
    }, {
        breakpoint: 480,
        settings: {
            slidesToShow: 1.2,
            slidesToScroll: 1
        }
    }]
})

    //start supermix
    const getSupermixData = function () {
        sendAjaxRequest(APP_URL + '/supermix', 'POST', null,
            onSupermixSuccess, onError, 'application/json');

        function onSupermixSuccess(response) {

            $('#supermixData').html(response.payload?.html);

            $("#sortable").sortable({
                handle: '.handle',
                cancel: ''
            });
        }
    }

    $(document).on('click', '.shuffleContent', function (e) {
        stopPlayer();
        e.preventDefault();
        $("#supermixWatchBtn").prop("disabled", false);
        getSupermixData();
        $('.supermix-banner video').hide();
        $('.supermix-banner img').show();
    });

    $(document).on('click', '.superMixButton', function (e) {
        e.preventDefault();
        $("#supermixWatchBtn").prop("disabled", false);
        let img = $(this).parents('.super-mix').find('.supImg').attr('src');
        $('#supermixModal .supermix-banner img').attr('src', img);
        $('.supermix-banner video').hide();
        $('.supermix-banner img').show();
        $('#supermixModal').modal('show');
        getSupermixData();
    });

    $(document).on('click', '.popupVideo', function () {
        // let video = $(this).data('video');

        // $('#videoPlayer source').attr('src', video);
        // $('#videoModal').modal('show');

    });

    //end supermix

    $(document).ready(function () {
        $(".banner-carousel-new-release").on("afterChange", function (event, slick, currentSlide) {
            $(".episode-wrapper-nr").removeClass('active');
            $(".episode-wrapper-nr-" + currentSlide).addClass('active');

        })

        // Pageblocker Start

        function getCookie(cookieName) {
            const name = cookieName + '=';
            const decodedCookie = decodeURIComponent(document.cookie);
            const cookieArray = decodedCookie.split(';');

            for (let i = 0; i < cookieArray.length; i++) {
                let cookie = cookieArray[i].trim();
                if (cookie.indexOf(name) === 0) {
                    return cookie.substring(name.length, cookie.length);
                }
            }
            return '';
        }


        function setCookie(cookieName, cookieValue, expiryDays) {
            const date = new Date();
            //days
            date.setTime(date.getTime() + (expiryDays * 24 * 60 * 60 * 1000));

            //minute
            // date.setTime(date.getTime() + (expiryDays * 60 * 1000));

            const expires = 'expires=' + date.toUTCString();
            document.cookie = cookieName + '=' + cookieValue + ';' + expires + ';path=/';
        }

        function hideShowPageBlocker() {
            const cookieValue = getCookie('showblocker');
            if (!cookieValue) {
                $('.page-blocker').show();
            }
        }

        hideShowPageBlocker();

        $('.page-blocker').on('click', function (event) {
            if (!$(event.target).closest('.modal-body').length) {
                setCookie('showblocker', '1', 1);
                $('.page-blocker').hide();
            }
        });

        $('.page-blocker .modal-body').click(function () {
            setCookie('showblocker', '1', 1);
            $('.page-blocker').hide();
        });

        // Pageblocker End

    });

}

$(".readmore-less").on("click",function(){
    $(".seemore p").toggleClass("readmore-toggle");

    if ($(this).text() == "Read More") {
        $(this).text("Read Less")
      } else {
        $(this).text("Read More")
      }
});