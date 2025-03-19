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

  $(".login-with-rewards").click(function() {
    window.history.pushState({},'',"?ref=rewards");
    $(".loginBtn.login").trigger('click');
    return false;
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
  if($('.hamburger').length){
      document.querySelector(".hamburger").addEventListener("click", function () {
        $("#side-menu").toggleClass("active");
        return false;
      });
  }
  

  $(".menu-close").on("click", function () {
    $("#side-menu").toggleClass("active");
    return false;
  });


  // on profile hover and click effect 
  // if ($(window).width() < 1025) {
  //   $(".profile").on('click', function () {
  //     $(".profile-drop-down").toggleClass("prof-open");
  //   });
  // }
  // else {
  //   $(".profile").hover(function () {
  //     var profileDiv = document.querySelector(".profile-drop-down");
  //     if (profileDiv != '' && profileDiv != null && profileDiv != 'undefined') {
  //       if (profileDiv.style.display == 'block') {
  //         profileDiv.style.display == 'none';
  //       } else {
  //         profileDiv.style.display = 'block';
  //       }
  //     }
  //   });
  // }
  if ($(window).width() < 1025) {
    $(".notification").on('click', function () {
      $(".notification-drop-down").toggleClass("prof-open");
      if ( $(".notification-drop-down").hasClass("prof-open") &&  $(".profile-drop-down").hasClass("prof-open") ){
      $(".profile-drop-down").removeClass("prof-open");
      }
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

  if ($(window).width() < 1025) {
    $(".profile").on('click', function () {
      $(".profile-drop-down").toggleClass("prof-open");
      if ( $(".notification-drop-down").hasClass("prof-open") &&  $(".profile-drop-down").hasClass("prof-open") ){
        $(".notification-drop-down").removeClass("prof-open");
        }
    });
  }
  else {
    $(".profile").hover(function () {

        if( $('.profile-drop-down').length ){
            var e = document.querySelector(".profile-drop-down");
            if (e.style.display == 'block'){
              e.style.display = 'none';
            }
            else{
              e.style.display = 'block';
            }
        }

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
  console.log(input+"input field details");
  if(input != undefined){
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
}else{
  return '';
}
}

// $(document).ready(function(){
//   var sectionIds = $('a.nav-link');
//     $(document).scroll(function(){
//         sectionIds.each(function(){
//             var container = $(this).attr('href');
//             var containerOffset = $(container).offset().top;
//             var containerHeight = $(container).outerHeight();
//             var containerBottom = containerOffset + containerHeight;
//             var scrollPosition = $(document).scrollTop();
    
//             if(scrollPosition < containerBottom - 200 && scrollPosition >= containerOffset - 200){
//                 $(this).addClass('active');
//             } else{
//                 $(this).removeClass('active');
//             }
    
//         });
//     });
// });

$(".s__spy").on("click",function(){
  $(".s__spy").removeClass("active");
  $(this).addClass("active");
});

$(document).on("click","#countryCode__dropdown",function(){
  $(".country__code__box").toggleClass("active-div");
});

// search country code start
function searchCountryCode(searchval) {
  var input, filter, ul, li, a, i, txtValue;
  input = document.querySelector(".search_"+searchval);
  filter = input.value.toUpperCase();
  ul = document.getElementById("myUL_"+searchval);
  li = ul.getElementsByTagName("li");
  let matchFound = false;
  $('.no-data').show();
  for (i = 0; i < li.length; i++) {
      a = li[i].getElementsByTagName("a")[0];
      txtValue = a.textContent || a.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
          li[i].style.display = "";
          matchFound = true;
          $('.no-data').hide();
      } else {
          li[i].style.display = "none";
          
      }
  }
  const notFoundMessage = ul.querySelector('.no-data');
  if (notFoundMessage) {
      notFoundMessage.remove();
  }
  // If no match was found, append the "Data not found" message
  if (!matchFound) {
      const noDataLi = document.createElement('li');
      noDataLi.className = 'no-data'; // Add a class to identify this element
      noDataLi.textContent = 'No match found';
      ul.appendChild(noDataLi);
     
  }
};

const appendCountry = document.getElementById("countryCode__dropdown");
let contr = document.querySelectorAll(".conuntry__code__list__text");
contr.forEach(function(allCountryCode){
  allCountryCode.addEventListener("click",function(){
    let allCoCode = allCountryCode.textContent;
    var countryCode = allCoCode.match(/\(\+\d+\)/)[0];
    countryCode = countryCode.replace(/[()]/g, '');
    // appendCountry.innerHTML= countryCode;
    $(".country__code").text(countryCode);
    if (countryCode.trim() != "+91") {
      $(".country-wise-msg").html("New users outside India are requested to register via email IDs and not mobile OTP.")
    } else {
      $(".country-wise-msg").html("We’ll send you an OTP to verify your account");
    }
    $(".country-stdisdcode-class").val(countryCode);
    $(contr).removeClass("active");
    $(this).addClass("active");
    $(".country__code__box").toggleClass("active-div");
  })
});
// search country code end

function isValidContact(isInput) {
	// alert("true");
  // Regular expressions for email and mobile number validation
  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  const mobilePattern = /^\d{8,}$/;

  if (emailPattern.test(isInput)) {
	return true;
  } else if (mobilePattern.test(isInput)) {
	return true;
  } else {
  	$('.get-otp-message').html("Please Enter Valid Details");
  	return false;
  }
}


function sendAjaxRequest(url, method, data, successCallback, errorCallback, contentType = false) {

  $.ajax({
      type: method,
      url: url,
      data: data,
      contentType: contentType,
      cache: false,
      processData: false,
      dataType: 'json',
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (data) {
          successCallback(data);
      },
      error: function (xhr, ajaxOptions, thrownError) {
          errorCallback(xhr);
      },
      complete: function () {

      }
  });

  return false;

  /*
  var xhr = new XMLHttpRequest();
  xhr.open(method, url, true);

  xhr.setRequestHeader('Content-Type', false);
  // xhr.setRequestHeader('Content-Type', 'application/json');

  // xhr.setRequestHeader('Content-Type', 'multipart/form-data');
  xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));

  xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
              if (successCallback) {
                  var responseData = JSON.parse(xhr.responseText);
                  successCallback(responseData);
              }
          } else {
              if (errorCallback) {
                  errorCallback(xhr.status);
              }
          }
      }
  };
  console.log(data);
  xhr.send(data);
  */
}

// Example usage
function onSuccess(response) {
  showToaster(response?.message, 1);

  if (response.payload?.redirect != undefined) {
      setTimeout(() => {
          window.location.href = response.payload?.redirect;
      }, 1000);
  }
  console.log('Success:', response);
}

function onError(xhr) {
  $msg = 'Some Error occured';
  try {
      $res = JSON.parse(xhr.responseText);
      if ($res.message != undefined) {
          $msg = $res.message;
      }
  } catch (err) { }
  showToaster($msg, 2);
  console.log('Error:', xhr);
}

const showToaster = (message, type = 1, timeout = 4000) => {
  toastr.remove();
  if (type == 1) {
      toastr.success(message, "Success", {
          timeOut: timeout
      });
  } else {
      toastr.error(message, "Error", {
          timeOut: timeout
      });
  }
};

$(document).on('click', '.emptyText', function () {
  $(this).parents('.input-field').find('input.form-control').val('');
});



// start add to wishlist
$(document).on('click', '.addToList', function () {
  let action = $(this).data('action');
  let id = $(this).data('id');
  let type = $(this).data('type');

  let element = $(this);

  let requestData = {
      content_id: id,
      action: action,
      type: type,
  };

  sendAjaxRequest(APP_URL + '/wishlist?content_id='+id+'&action='+action+'&type='+type, 'GET', null, onWishlistSuccess, onError, 'application/json');

  function onWishlistSuccess(response) {
      console.log('type : ' + type);
      if (type == 1) {
          console.log(response.payload?.icon);
          element.replaceWith(response.payload?.icon);
      } else if (type == 3) {
          element.data('action', element.data('action') === 'add' ? 'delete' : 'add');

          if (action == 'add') {
              element.find('.wl_add').hide();
              element.find('.wl_remove').show();
          } else {
              element.find('.wl_add').show();
              element.find('.wl_remove').hide();
          }

      } else {
          element.data('action', element.data('action') === 'add' ? 'delete' : 'add');
          element.toggleClass('add-icon delete-icon');
      }


      showToaster(response?.message, 1);
  }
});
// end start add to wishlist

$(document).on('keydown', '.onlydigit', function (e) {
  if (e.key.match(/[^0-9]/) && e.key !== 'Backspace' && e.key !== 'Delete' && e.key !== 'ArrowLeft' && e.key !== 'ArrowRight') {
      e.preventDefault();
  }
});

//social share
$(document).on('click', '.shareThis', function () {
  let url = $(this).data('url');
  let title = $(this).data('title') || 'Epic On';
  let data_type = $(this).data('type');

  var assetPath = APP_URL+'/assets/img/share-x.svg';

  $('#shareDiv').html('<div class="socialJS"><a onclick="share(this)" data-title="'+title+'" data-type="'+data_type+'" data-method="Link Copy"  href="javascript:void(0)" data-url="'+url+'" id="linkCopy" data-toggle="tooltip" title="Copy" class="my-tool-tip"><i class="fas fa-copy" style="color:#b9b9b9"></i></a><a onclick="share(this)" data-title="'+title+'" data-type="'+data_type+'" data-method="facebook" data-action="social-share" href="https://www.facebook.com/sharer.php?u='+url+'" target="_blank"><i class="fab fa-facebook" style="color:#4267B2"></i></a><a onclick="share(this)" data-title="'+title+'" data-type="'+data_type+'" data-method="twitter" data-action="social-share" href="https://twitter.com/share?url='+url+'" target="_blank"><img src="'+assetPath+'"></a></div>');

  // $('#shareDiv').empty();
  // $('#shareDiv').socialSharingPlugin({
  //     url: url,
  //     title: title,
  //     description: title,
  //     // description: $('meta[property="og:description"]').attr('content'),
  //     // img: $('meta[property="og:image"]').attr('content'),
  //     enable: ['copy', 'facebook', 'twitter'],
  //     copyMessage:'Copy to clipboard',

  // });
  $('#shareModal').modal('show');
  $('#linkCopy').click(function() {
      var textToCopy = $('#linkCopy').attr('data-url');
      var tempTextarea = $('<textarea>');
      $('#shareDiv').append(tempTextarea);
      tempTextarea.val(textToCopy).select();
      document.execCommand('copy');
      tempTextarea.remove();
      $('#linkCopy').attr("title", "Copied!").tooltip("_fixTitle")
      .tooltip("show").attr("title", "Copied!").tooltip("_fixTitle");
     
    });

});

//end social share

$('.menu-close').click(function (e) {
  e.preventDefault();
});

$('#side-menu').on('click', function (e) {
  // Check if the click was not inside the .abc class
  if (!$(e.target).hasClass('ps-3')) {
      $('.menu-close').trigger('click');
  }
});

// Get the URL query parameters
var queryParams = new URLSearchParams(window.location.search);
var isSorted = false;

$(document).ready(function () {
    $(".profile_date_picker").datepicker({
        //dateFormat: 'dd-M-yy',
        dateFormat: 'dd/mm/yy',
        maxDate: '-1d',
        changeMonth: true,
        changeYear: true,
        maxDate: "-1Y",
        minDate: "-100Y",
        yearRange: "-100:-1"
    });

    $("#seasonSelect").trigger("change");

    $("#seasonSelect").change(function () {
        var slug = $(this).val();
        if (slug != "" && slug != 0) {
            $(".season-episode-main").addClass('hide');
            $("#pills-episode-" + slug).removeClass('hide');
            let sortType = $("#seasonSelect").val() || "";
            if (isSorted) {
                isSorted = true;
                sortingEp($(this).val(), sortType);
            }
        } else {
            return false;
        }
    })
    //Sorting
    $("#SortingEp").off("change").on("change", function () {
        let id = $("#seasonSelect").val() || "";
        //console.log("id: " + id)
        sortingEp(id, $(this).val());
    })

    $(document).on("click", ".copyUrl", function () {
        // $('#linkCopy').attr("title", "Copied!").tooltip("_fixTitle")
        // .tooltip("show").attr("title", "Copied!").tooltip("_fixTitle");
        var shareurl = $(this).attr('data-url');
        // alert(shareurl);
        // var dummy = $('<input id="test">').val(shareurl);//.appendTo('body').select();
        var dummy = document.createElement("input");
        dummy.value = shareurl;
        document.body.appendChild(dummy);
        dummy.select();
        dummy.focus();
        document.execCommand('copy');
        document.body.removeChild(dummy);
        $(this).attr("title", "Copied!").tooltip("_fixTitle")
            .tooltip("show").attr("title", "Copied!").tooltip("_fixTitle");
    });

    $(document).on("mouseover", ".copyUrl", function () {
        $(this).attr("title", "Copy").tooltip("_fixTitle")
            .tooltip("show").attr("title", "Copy").tooltip("_fixTitle");
    });

    // $('#linkCopy').click(function() {
    //     alert("true linkcopy");
    //     var textToCopy = $('#linkCopy').attr('data-url');
    //     var tempTextarea = $('<textarea>');
    //     $('#shareDiv').append(tempTextarea);
    //     tempTextarea.val(textToCopy).select();
    //     document.execCommand('copy');
    //     tempTextarea.remove();
    //     $('#linkCopy').attr("title", "Copied!").tooltip("_fixTitle")
    //     .tooltip("show").attr("title", "Copied!").tooltip("_fixTitle");

    //   });

    //focus otp input
    $(".mx-1").on("input", function () {
        const maxLength = parseInt($(this).attr("maxlength"));
        const currentLength = $(this).val().length;

        // If the current input field is filled, move to the next field
        if (currentLength === maxLength) {
            $(this).next(".mx-1").val('');
            $(this).next(".mx-1").focus();
        }
    });

    $(".childpin-input .backpress").keydown(function (event) {
        if (event.keyCode == 8 && $(this).val().length == 0) {
            if ($(this).prev('.childpin-input .backpress')) {
                $(this).prev('.childpin-input .backpress').focus();
            }
        }
    });


    $(".login-with-subscription").click(function () {
        window.history.pushState({}, '', "?ref=subscription");
        var rediUrl = window.location.href;
        localStorage.setItem("redirectURL", rediUrl);
        $('#closePlayer').trigger('click');
        $('.loginBtn.login').trigger('click');


    });

    $(".allAccessBtn").unbind().click(function (event) {
        if (!event.isTrigger) {
            window.history.replaceState({}, document.title, "?");
            localStorage.setItem("redirectURL", "");
        }
        var checkstaus = $(this).is(':checked');
        var kidsUrl = $("input#kidsUrlH").val();
        var isLoggedIn = $(this).data('log');
        if (checkstaus) {
            $(this).prop('checked', false);
            if (parseInt(isLoggedIn) != 1) {
                window.history.pushState({}, '', "?profile=kids");
                $('.loginBtn.login').trigger('click');
                return false;
            } else {
                console.log('else in kids');
                window.location.href = kidsUrl;
                return false;
            }
        } else {
            $(".allAccessBtn").prop("checked", true);
            $("#child-pin-modal").modal('show');
            return false;
        }
    })

    $(".allAccessBtn-sub").click(function () {
        var rediUrl = window.location.href;
        localStorage.setItem("redirectURL", rediUrl);
        window.history.pushState({}, '', "?ref=subscription");
        var dispcss = $('.videoContainer').css('display');
        if (dispcss == 'block') {
            $('#closePlayer').trigger('click');
        }
        $("#child-pin-modal").modal('show');
    });

    $('.goBackButton').click(function () {
        // Go back to the previous page
        window.history.back();
    });

    $(".eye-toggle").click(function () {
        var targetId = $(this).data("target");
        var inputField = $("#" + targetId);
        var isPasswordType = inputField.attr('type') === 'password';

        if (isPasswordType) {
            inputField.attr('type', 'text');
            $(this).find('.eye-close-' + targetId).css('display', 'none');
            $(this).find('.eye-open-' + targetId).css('display', 'block');
        } else {
            inputField.attr('type', 'password');
            $(this).find('.eye-open-' + targetId).css('display', 'none');
            $(this).find('.eye-close-' + targetId).css('display', 'block');
        }
    });

    $(".subscription-login").on("click", function () {
        var rediUrl = window.location.href;
        localStorage.setItem("SubredirectURL", rediUrl);
        $(".loginBtn.login").trigger('click');

    });

})

$(document).on("click", ".check-content-url", function () {
    var content_url = $(this).attr('data-url');
    var is_premium = $(this).data('premium');
    var active_subscriber = $(this).data('activesubscriber');
    var Islogin = $(this).attr('check-login');
    var rediUrl = window.location.href;
    localStorage.setItem("redirectURL", rediUrl);
    if (is_premium == 1 && active_subscriber != 1) {
        if (Islogin == "allAccessBtn") {
            window.history.pushState({}, '', "?ref=subscription");
            $(".allAccessBtn").trigger('click');
            return false;
        } else {
            window.location.href = APP_URL + '/subscription';
            return false;
        }

        //showToaster("Please subscribe to play this game.", 2);
        return;
    }
    if (content_url == "") {
        showToaster("Content not found.", 2);
        return;
    }
    window.open(content_url, '_blank');
    // window.location.href = content_url;
});


$(window).on('load', function () {
    /*kids section*/
    // open login popup
    if (queryParams.get('profile') == "kids") {
        $('.loginBtn.login').trigger('click');
    }
    /*kids section end*/

    /*logout if token not found*/
    if (queryParams.get('type') == "logout") {
        showToaster("You have been logged out. Kindly relogin to continue.", 2, 5000)
        window.history.replaceState({}, document.title, "/");
    }
    // open login popup
    if (queryParams.get('type') == "login" || (queryParams.get('userUuid') != "" && queryParams.get('userUuid') != null && queryParams.get('userUuid') != "undefined") ) {
        $('.loginBtn.login').trigger('click');
    }
})

$(document).on("click", ".interest-suggetion", function (e) {
    e.preventDefault();
    var genreCount = 0;
    $("input[name='genreInterest[]']").each(function (key, value) {
        if (value.checked) {
            genreCount++;
        }
    });

    var interest = $(this).find("input[type='checkbox']");
    if (interest.is(":checked")) {
        interest.prop("checked", false);
        genreCount--;
    } else {
        if (genreCount < 5) {
            interest.prop("checked", true);
            genreCount++;
        }
    }
    $(".genre-select-count").text(genreCount + " of 5");
})

function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

// distro search

if ($('.distro-search-main').length) {

    $('.distro-search-input').val('');

    $(".distro-search-input").on("click", function () {
        $(".distro-search-main").addClass("dsm-style");
        if ($(".distro-back-btn").css({ "display": "none" })) {
            $(".distro-back-btn").css({ "display": "block" })
        }
    });

    $("#distBack").on("click", function () {
        $(".distro-search-main").removeClass("dsm-style");
        $(this).css({ "display": "none" });
        $(".distro-search-input").val("");
        $(".distro-search-select, .distro-search-show, .distro-search-clear").hide();
        $('.distro-search-show').html('');
    });

    $(".distro-filter").on("click", function () {
        if (!this.value) {
            $(".distro-search-select").toggle();
        }
        $(".distro-filter img").toggleClass("dis-img-toggle");
        $(".distro-search-show").hide();
        $(".distro-search-main").addClass("dsm-style");
        if ($(".distro-back-btn").css({ "display": "none" })) {
            $(".distro-back-btn").css({ "display": "block" })
        }
    });
    $(".distro-search-clear").on("click", function () {
        $(".distro-search-input").val("");
        $(".distro-search-select, .distro-search-show, .distro-search-clear").hide();
        $('.distro-search-show').html('');
    });

    $('.distro-search-select .npq').click(function () {
        $('.distro-search-select .npq').removeClass('active');
        $(this).addClass('active');
        $(".distro-search-input").val("");
        $(".distro-search-select, .distro-search-show, .distro-search-clear").hide();
        $('.distro-search-show').html('');
    });

    $(document).on('click', '.distro-s-li', function () {
        let url = $(this).data('url');
        window.location.href = url;
        return;
    });

    $(".distro-search-input").on("keyup", function () {
        $(".distro-search-show, .distro-search-select").hide();
        $('.distro-search-show').html('');

        var searchtext = $('.distro-search-input').val();
        if (searchtext.length > 1) {

            if (searchtext != "") {
                $(".distro-search-clear").show();
            } else {
                $(".distro-search-clear").hide();
            }

            let type = $('.distro-search-select .npq.active').data('type');
            $.ajax({
                url: APP_URL + "/distro-tv-search",
                type: 'GET',
                data: { 'term': searchtext, 'type': type },
                dataType: 'json',
                async: true,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    var response = data.payload.html;
                    $(".distro-search-show").html(response);
                    $(".distro-search-show").show();
                },
                error: function (xhr, status, error) {
                    console.log("in error function");
                }
            });
        }
    });
}

function sortingEp(id, sortType) {
    //console.log("sortType: " + sortType)
    //console.log($("#pills-episode-" + id).hasClass(sortType));
    if ($("#pills-episode-" + id).hasClass(sortType)) {
        return false;
    }
    $("#pills-episode-" + id).removeClass(sortType == "asc" ? "desc" : "asc");
    $("#pills-episode-" + id).addClass(sortType);
    let ul = document.getElementById("pills-episode-" + id);
    //console.log(ul);
    var lis = ul.getElementsByTagName("li");
    var vals = [];
    for (var i = 0, l = lis.length; i < l; i++) {
        vals.push(lis[i].innerHTML);
    }
    vals.reverse();
    for (var i = 0, l = lis.length; i < l; i++) {
        lis[i].innerHTML = vals[i];
    }
    var currentUrl = window.location.href;
    if (currentUrl.includes("/podcast")) {
        sortEpisodes(sortType);
    }
}

function checkPin(selector, length)
{
  selector.css({"border": "1px solid #494949"});
  let value = selector.map(function () {
    if ($(this).val().trim() == "") {
        $(this).css({"border": "1px solid red"});
    }
    return $(this).val().trim();
  }).get();
  if (value.length !== length || value.some(pin => pin === "")) {
    return false;
  }
  return true;
}
