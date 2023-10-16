$(document).ready(function () {
  getNotification();

  function scheduleGetNotification() {
    setTimeout(function() {
      getNotification();
      scheduleGetNotification(); // Call itself again to set up the next setTimeout
    }, 30 * 60 * 1000); // 30 minutes in milliseconds //1.36pm
  }

  // Start the recursive timeout
  scheduleGetNotification();

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

function getNotification(){
    $.ajax({
        type: 'GET',
        url: '/notifications',
        success: function (data) {
            // Handle the response data here
            
            var data = data.notifications;
            // console.log(data);
            var html = '';
            if(data != ''){
            $('.no-notification').hide();
            data.forEach(function(item, index) {
              // console.log('Item at index ' + index + ':');
              // console.log(item.big_picture);
              html += '<li class="content active mb-3"><a href="'+item.data.customkey+'" class="notif-img"><img src="'+item.big_picture+'" alt=""></a><div><h3>'+item.headings.en+'</h3><h4>'+item.contents.en+'</h4></div></li>';
              // You can access properties of the item like item.adm_big_picture, item.adm_group, etc.
            });
            // console.log(html+"HTML Response");
            $('.notification-list').html(html);
            }else{
              $('.no-notification').show();
            }
        },
        error: function (error) {
            console.log(error);
        }
    });
}

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
