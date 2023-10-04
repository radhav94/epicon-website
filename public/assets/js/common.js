$(document).ready(function() {
    $("#seasonSelect").change(function() {
        var url = $(this).val();
        if (url != ""){
            window.location.href = window.location.protocol + "//" + window.location.host + "/" + url;
        }
    })
})