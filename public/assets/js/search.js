
$(document).ready(function () {
    $("#searchname").on("keyup", function () {
        $("#searchTab, #noData-error").hide();
        $('.otherResult .topResult').html('');
        var searchtext = $('input[name="search"]').val();
        if (searchtext != "") {
            $(".remove-text").show();
        } else {
            $(".remove-text, .Alltopresult-error").hide();
            $('#Alltopresult, #Moviestopresult, #Showtopresult, #Podcasttopresult, #Kidstopresult, #Gamestopresult').html("");
        }
        console.log(searchtext + " Text Value");
        var lang = $("html").attr("lang") != 'en' ? $("html").attr("lang") + "/" : "";
        var ajaxUrl = lang + 'get-search';
        if (searchtext.length > 2) {
            searchEvent();
            $.ajax({
                url: "/" + ajaxUrl,
                type: 'POST',
                data: { 'searchinput': searchtext },
                dataType: 'json',
                async: true,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    var response = data.payload.data;

                    if (data.payload.success) {
                        $("#search-result").hide();
                        var result = false;
                        var topResult = response.topResult;
                        var otherResult = response.otherResult;
                        // console.log(topResult);

                        if (topResult) {
                            Object.keys(topResult).forEach(function (key) {
                                $('#' + key + 'Top').html(topResult[key]);
                            });
                        } else {
                            $('.topResult').html('');
                        }

                        if (otherResult) {
                            Object.keys(otherResult).forEach(function (key) {
                                if (otherResult[key] !== "") {
                                    result = true;
                                    $('#' + key + 'Other').html(otherResult[key]);
                                }
                            });
                        } else {
                            $('.otherResult').html('');
                        }

                        if (result) {
                            $("#searchTab").show();
                        } else {
                            $("#searchTab").hide();
                            $("#noData-error").show();
                        }
                    } else {
                        $("#searchTab").hide();
                        $("#noData-error").show();
                    }
                },
                error: function (xhr, status, error) {
                    console.log("in error function");
                }
            });
        }
    });
});

$(document).on('click', '.remove-text', function () {
    $('input[name="search"]').val('');
    $("#searchTab, #noData-error").hide();
    $('.otherResult .topResult').html('');
    $(this).hide();
    $("#search-result").show();
});