$(document).ready(function () {
    var playid = $("#subsuser").val();
    if(playid == "watchVideo"){
        setTimeout(function() {
        $("#watchVideo").trigger("click");
        }, 1000);
    }   
    $(document).on('click', '.clapButton', function () {

        let cardType = $(this).data('cardtype');
        let cont_id = $(this).data('id');
        let requestData = {
            content_id: cont_id
        };
        console.log(requestData);
        sendAjaxRequest(APP_URL + '/clap?content_id='+cont_id, 'GET', null, onClapSuccess,
            onClapError, 'application/json');

        function onClapSuccess(response) {
            // showToaster(response?.message, 1);
            let claps = response.payload.claps;

            if (cardType != 'list') {
                $('.claps_num').text(claps);
            }
        }
        function onClapError(xhr) {
            console.log('Error:', xhr);
        }

    });
    //end clap

    function initTrailerCarousel(){
        $('.carousel-initilize').not('.slick-initialized').slick({
            dots: false,
            infinite: false,
            speed: 300,
            slidesToShow: 4.2,
            slidesToScroll: 1,
            accessibility: true,
            responsive: [{
                breakpoint: 1367,
                settings: {
                    slidesToShow: 4.5,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 1025,
                settings: {
                    slidesToShow: 3.9,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 769,
                settings: {
                    slidesToShow: 3.2,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
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
    }

    $('#trailors').click(function () {
        initTrailerCarousel();
    });
    initTrailerCarousel();

    if($('.TrailerLink').length){
        var link = document.querySelector('.TrailerLink'); 
        link.click();
    }
    
});