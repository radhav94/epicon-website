// Get the URL query parameters
const queryParams = new URLSearchParams(window.location.search);

$(document).ready(function () {
    $("#seasonSelect").change(function () {
        var url = $(this).val();
        if (url != "") {
            window.location.href = window.location.protocol + "//" + window.location.host + "/" + url;
        }
    })

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

    $(".check-content-url").click(function () {
        var content_url = $(this).attr('data-url');
        var is_premium = $(this).data('premium');
        var active_subscriber = $(this).data('activesubscriber');
        if (is_premium == 1 && active_subscriber != 1) {
            showToaster("Please subscribe to play this game.", 2);
            return;
        }
        if (content_url == "") {
            showToaster("Content not found.", 2);
            return;
        }
        window.location.href = content_url;
    })

    $("#allAccessBtn").click(function() {
        var checkstaus = $(this).is(':checked');
        var kidsUrl= $("#kidsUrl").val();
        //alert(kidsUrl);
        if(checkstaus){
            window.location.href=kidsUrl;
        }else{
            $("#allAccessBtn").prop( "checked", true );
            $("#child-pin-modal").modal('show');
        }
        
    })
})

$(document).on("click", ".check-content-url", function () {
    var content_url = $(this).attr('data-url');
    var is_premium = $(this).data('premium');
    var active_subscriber = $(this).data('activesubscriber');
    if (is_premium == 1 && active_subscriber != 1) {
        showToaster("Please subscribe to play this game.", 2);
        return;
    }
    if (content_url == "") {
        showToaster("Content not found.", 2);
        return;
    }
    window.location.href = content_url;
});


$(window).on('load', function () {
    /*kids section*/
    // open login popup
    if (queryParams.get('profile') == "kids") {
        $('.login').trigger('click');
    }

    console.log(getCookie("KidsMode"));
    if (getCookie('KidsMode') == 1 && window.location.href.indexOf("/kids") == -1) {
        location.href = '/kids/'
    }
    /*kids section end*/

    /*logout if token not found*/
    if (queryParams.get('type') == "logout") {
        showToaster("Your token has been expired.", 2, 5000)
        window.history.replaceState({}, document.title, "/" );
    }
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
