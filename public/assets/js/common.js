// Get the URL query parameters
var queryParams = new URLSearchParams(window.location.search);

$(document).ready(function () {
    $( ".profile_date_picker" ).datepicker({
        //dateFormat: 'dd-M-yy',
        dateFormat: 'dd/mm/yy',
        maxDate: '-1d',
        changeMonth: true,
        changeYear: true,
        maxDate: "-1Y",
        minDate: "-100Y",
        yearRange: "-100:-1"
    });

    $("#seasonSelect").change(function () {
        var slug = $(this).val();
        if (slug != "" && slug != 0) {
            $(".season-episode-main").addClass('hide');
            $("#pills-episode-" + slug).removeClass('hide');
        }else{
            return false;
        }
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
       
      $(".childpin-input .backpress").keydown(function(event) {
        if (event.keyCode == 8 && $(this).val().length == 0) {
          if ($(this).prev('.childpin-input .backpress')) {
            $(this).prev('.childpin-input .backpress').focus();
          }
        }
      });


      $(".login-with-subscription").click(function(){
        window.history.pushState({},'',"?ref=subscription");
        var rediUrl = window.location.href;
        localStorage.setItem("redirectURL", rediUrl);
        $('#closePlayer').trigger('click');
        $('.loginBtn.login').trigger('click');
       

      });

    $(".allAccessBtn").unbind().click(function(event) {
        if (!event.isTrigger) {
            window.history.replaceState({}, document.title, "?" );
            localStorage.setItem("redirectURL", "");
        }
        var checkstaus = $(this).is(':checked');
        var kidsUrl= $("input#kidsUrl").val();
        var isLoggedIn = $(this).data('log');
        if(checkstaus){
            $(this).prop('checked', false);
            if (parseInt(isLoggedIn) != 1) {
                window.history.pushState({},'',"?profile=kids");
                $('.loginBtn.login').trigger('click');
                return false;
            } else {
                console.log('else in kids');
                window.location.href=kidsUrl;
                return false;
            }
        }else{
            $(".allAccessBtn").prop( "checked", true );
            $("#child-pin-modal").modal('show');
            return false;
        }
    })

    $(".allAccessBtn-sub").click(function() {
        window.history.pushState({},'',"?ref=subscription");
        var dispcss = $('.videoContainer').css('display');
        if(dispcss == 'block'){
            $('#closePlayer').trigger('click');
        }
        $("#child-pin-modal").modal('show');
    });

    $('.goBackButton').click(function() {
        // Go back to the previous page
        window.history.back();
    });

    $(".eye-toggle").click(function() {
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
        if(Islogin == "checklogin"){
            $(".login").trigger('click');
            return false;
        }else if(Islogin == "allAccessBtn"){
            $(".allAccessBtn").trigger('click');
            return false;
        }else{
            window.location.href = APP_URL+'/subscription';
            return false; 
        }
        
        //showToaster("Please subscribe to play this game.", 2);
        return;
    }
    if (content_url == "") {
        showToaster("Content not found.", 2);
        return;
    }
    window.open(content_url,'_blank');
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
    if (queryParams.get('type') == "login") {
        $('.loginBtn.login').trigger('click');
    }
})

$(document).on("click", ".interest-suggetion", function(e){
    e.preventDefault();
    var genreCount = 0;
    $("input[name='genreInterest[]']").each(function(key, value) {
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

