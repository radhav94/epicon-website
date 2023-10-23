
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
                        console.log(topResult);
                        
                        if (topResult) {
                            $('#Alltopresult').html(topResult.AllResult);
                            $('#Moviestopresult').html(topResult.MoviesResult);
                            $('#Showtopresult').html(topResult.ShowsResult);
                            $('#Podcasttopresult').html(topResult.PodcastsResult);
                            $('#Kidstopresult').html(topResult.KidsResult);
                            $('#Gamestopresult').html(topResult.GamesResult);
                        } else {
                            $('.topResult').html('');
                        }

                        if (otherResult) {
                            if (otherResult.AllResult != "") {
                                result = true;
                                $('#AllOtherResult').html(otherResult.AllResult);
                            }
                            if (otherResult.MoviesResult != "") {
                                result = true;
                                $('#MoviesOtherResult').html(otherResult.MoviesResult);
                            }
                            if (otherResult.ShowsResult != "") {
                                result = true;
                                $('#ShowOtherResult').html(otherResult.ShowsResult);
                            }
                            if (otherResult.PodcastsResult != "") {
                                result = true;
                                $('#PodcastOtherResult').html(otherResult.PodcastsResult);
                            }
                            if (otherResult.KidsResult != "") {
                                result = true;
                                $('#KidsOtherResult').html(otherResult.KidsResult);
                            }
                            if (otherResult.GamesResult != "") {
                                result = true;
                                $('#GamesOtherResult').html(otherResult.GamesResult);
                            }
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