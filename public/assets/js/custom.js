$(document).ready(function () {

  $('.additional-carousel').not('.slick-initialized').slick({
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

  $('.login-carousel').not('.slick-initialized').slick({
    infinite: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    dots: true,
  });

  // on hamburger click
  document.querySelector(".hamburger").addEventListener("click", function () {
    $("#side-menu").toggleClass("active");
  });

  $(".menu-close").on("click", function () {
    $("#side-menu").toggleClass("active");
  });


  // on profile hover and click effect 
  if ($(window).width() < 1025) {
    $(".profile").on('click', function () {
      $(".profile-drop-down").toggleClass("prof-open");
    });
  }
  else {
    $(".profile").hover(function () {
      var e = document.querySelector(".profile-drop-down");
      if (e.style.display == 'block')
        e.style.display = 'none';
      else
        e.style.display = 'block';
    });
  }
  if ($(window).width() < 1025) {
    $(".notification").on('click', function () {
      $(".notification-drop-down").toggleClass("prof-open");
    });
  }
  else {
    $(".notification").hover(function () {
      var e = document.querySelector(".notification-drop-down");
      if (e.style.display == 'block')
        e.style.display = 'none';
      else
        e.style.display = 'block';
    });
  }

});
// top menu
document.addEventListener("DOMContentLoaded", function () {

  window.addEventListener('scroll', function () {

    if (window.scrollY > 40) {
      document.getElementById('navbar_top').classList.add('fixed-top');
      // add padding top to show content behind navbar
      navbar_height = document.querySelector('.navbar').offsetHeight;
      document.body.style.paddingTop = navbar_height + 'px';
    } else {
      document.getElementById('navbar_top').classList.remove('fixed-top');
      // remove padding top from body
      document.body.style.paddingTop = '0';
    }
  });

  $(".mob-nav a").on("click", function () {
    $(".mob-nav a").removeClass("active");
    $(this).addClass("active");
  });

}); 
