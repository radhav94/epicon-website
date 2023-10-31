$(document).ready(function () {
  $(".login-popup").click(function(){
    $("#side-menu").toggleClass("active");
     return false;
  });

  
  $(".loginwish").click(function(e){
    e.preventDefault();
  $(".loginBtn.login").trigger('click');
  return false;
  });

  $(".subscription").on("click", function () {
    var rediUrl = window.location.href;
    localStorage.setItem("redirectURL", rediUrl);
    var subUrllink = $(".subUrl").val();
    window.location.href = subUrllink;
    
   
  });

// Check if an element with the class "notification" exists in the document
var notificationElement = document.querySelector('.notification');

if (notificationElement) {
      getNotification();

    function scheduleGetNotification() {
      setTimeout(function() {
        getNotification();
        scheduleGetNotification(); // Call itself again to set up the next setTimeout
      }, 30 * 60 * 1000); // 30 minutes in milliseconds
    }

    // Start the recursive timeout
    scheduleGetNotification();
}

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
    return false;
  });

  $(".menu-close").on("click", function () {
    $("#side-menu").toggleClass("active");
    return false;
  });


  // on profile hover and click effect 
  if ($(window).width() < 1025) {
    $(".profile").on('click', function () {
      $(".profile-drop-down").toggleClass("prof-open");
    });
  }
  else {
    $(".profile").hover(function () {
      var profileDiv = document.querySelector(".profile-drop-down");
      if (profileDiv != '' && profileDiv != null && profileDiv != 'undefined') {
        if (profileDiv.style.display == 'block') {
          profileDiv.style.display == 'none';
        } else {
          profileDiv.style.display = 'block';
        }
      }
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
              html += '<li class="content active mb-3"><a href="'+item.data.customkey+'"><div class="notif-img"><img src="'+item.big_picture+'" alt=""></div><div><h3>'+item.headings.en+'</h3><h4>'+item.contents.en+'</h4></div></a></li>';
              // html += '<li class="content active mb-3"><a href="'+item.data.customkey+'" class="notif-img"><img src="'+item.big_picture+'" alt=""></a><div><h3>'+item.headings.en+'</h3><h4>'+item.contents.en+'</h4></div></li>';
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


function hideMiddleCharacters(input) {
  if (input.includes('@')) {
    // Handle email addresses
    const atIndex = input.indexOf('@');
    if (atIndex !== -1 && atIndex > 1) {
      const prefix = input.slice(0, 2); // Keep the first two characters
      const suffix = input.slice(atIndex); // Keep the part after the '@' symbol
      const middleAsterisks = '*'.repeat(atIndex - 2); // Replace middle characters with asterisks
      return `${prefix}${middleAsterisks}${suffix}`;
    }
  } else {
    // Handle mobile numbers
    const cleanInput = input.replace(/[^0-9]/g, ''); // Remove non-numeric characters
    if (cleanInput.length > 6) {
      const prefix = cleanInput.slice(0, 3); // Keep the first two digits
      const suffix = cleanInput.slice(-3); // Keep the last two digits
      const middleAsterisks = '*'.repeat(cleanInput.length - 4); // Replace middle digits with asterisks
      return `${prefix}${middleAsterisks}${suffix}`;
    }
  }
  return input; // Input is too short to hide characters
}