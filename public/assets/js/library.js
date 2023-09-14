$(document).ready(function(){
	$('.carousel-initilize').slick({
    dots: false,
    infinite: false,
    speed: 300,
    slidesToShow: 4.2,
    slidesToScroll: 1,
    accessibility: true,
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
  $('.vertical-carousel-initilize').slick({
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
          slidesToShow: 7.5,
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
});